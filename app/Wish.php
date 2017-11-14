<?php

namespace App;

use AWS;
use Carbon\Carbon;
use Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Presenters\WishPresenter;

class Wish extends Model
{
    protected $guarded = [];
    protected $appends = ['image'];
    protected $dates = ['archived_at'];

    static protected function boot()
    {
        parent::boot();

        static::saving(function (Wish $wish) {
            $wish->description = htmlentities($wish->description);
        });
    }

    function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    function bookedBy()
    {
        return $this->belongsTo(User::class, 'booked_by');
    }

    function isBooked()
    {
        return !is_null($this->bookedBy);
    }

    function isBookedBy(User $user)
    {
        return $this->bookedBy->id === $user->id;
    }

    function setImageFromFile(UploadedFile $file)
    {
        if (!$this->exists) {
            return false;
        }

        $pathName = $file->getPathname();
        Image::make($pathName)->fit(200)->save($pathName);

        $s3 = AWS::createClient('S3');
        $params = [
            'Bucket' => Config::get('aws.bucket'),
            'Key' => md5(env('APP_KEY') . $this->id),
            'content-type' => $file->getMimeType(),
            'ACL' => 'public-read',
            'Body' => file_get_contents($pathName)
        ];
        $this->image_url = $s3->putObject($params)->get('ObjectURL') . "?cache=" . md5(time());

        return $this;
    }

    /**
     * @return $this
     */
    function archive()
    {
        $this->archived_at = Carbon::create();
        $this->save();
        return $this;
    }

    function isArchived()
    {
        return !is_null($this->archived_at);
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    function scopeNotArchived($query)
    {
        return $query->whereNull('archived_at');
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    function scopeArchived($query)
    {
        return $query->whereNotNull('archived_at');
    }


    /**
     * @return string
     */
    function getImageAttribute()
    {
        return $this->image_url ?: "/images/default.png";
    }

    function presenter()
    {
        return new WishPresenter($this);
    }
}
