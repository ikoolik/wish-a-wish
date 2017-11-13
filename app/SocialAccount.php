<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    protected $fillable = ['provider', 'external_id'];

    /**
     * @return
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
