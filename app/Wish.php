<?php

namespace Wish;

use Wish\Presenters\WishPresenter;
use AWS;
use Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Wish extends Model
{
    /** @var array */
    protected $fillable = ['name', 'description'];

    /** @var array */
    protected $appends = ['image'];

    /**
     * Register the lifecycle hooks
     */
    static protected function boot()
    {
        parent::boot();

        static::saving(function (Wish $wish) {
            $wish->description = htmlentities($wish->description);
        });
    }

    /**
     * @return BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @param UploadedFile $file
     *
     * @return $this|bool
     */
    public function setImageFromFile(UploadedFile $file)
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
    
    public function presenter()
    {
        return new WishPresenter($this);
    }

    /**
     * @return string
     */
    public function getImageAttribute()
    {
        return $this->image_url ?: "http://previews.123rf.com/images/naddya/naddya1311/naddya131100064/24188141-Gift-box-Vector-black-silhouette--Stock-Vector-gift.jpg";
    }
}
