<?php

namespace Wish;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
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
        'name',
        'email',
        'password',
        'slug'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

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

    public function avatarUrl()
    {
        $hash = md5(strtolower(trim($this->email)));
        return "https://www.gravatar.com/avatar/{$hash}?s=200&d=mm";
    }

    public function scopeByQuery($query, $q)
    {
        return $query->where('name', 'ilike', "%$q%")
            ->orWhere('email', 'ilike', "%$q%")
            ->orWhere('slug', 'ilike', "%$q%");
    }
}
