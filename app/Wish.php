<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Image;
use AWS;
use Config;

class Wish extends Model
{
    /** @var array  */
    protected $fillable = ['name', 'description'];

    /** @var array  */
    protected $appends = ['image'];

    /**
     * @return BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function setImageFromFile(UploadedFile $file)
    {
        if(!$this->exists) {
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
        $this->image_url = $s3->putObject($params)->get('ObjectURL');

        return $this;
    }

    public function getImageAttribute()
    {
        return $this->image_url?: "http://previews.123rf.com/images/naddya/naddya1311/naddya131100064/24188141-Gift-box-Vector-black-silhouette--Stock-Vector-gift.jpg";
    }
}
