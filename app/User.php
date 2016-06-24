<?php

namespace Wish;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Wish\Traits\HasSlug;

class User extends Authenticatable
{
    use HasSlug, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return HasMany
     */
    public function wishes()
    {
        return $this->hasMany(Wish::class);
    }

    public function owns(Wish $wish)
    {
        return $this->id === $wish->user_id;
    }
}
