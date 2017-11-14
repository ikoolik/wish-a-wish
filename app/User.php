<?php

namespace App;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasSlug, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug', 'name', 'email', 'password',
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

    /**
     * @return HasMany
     */
    public function socialAccounts()
    {
        return $this->hasMany(SocialAccount::class);
    }

    public function owns(Wish $wish)
    {
        return $this->id === $wish->user_id;
    }

    public function avatarUrl()
    {
        if($this->avatar) {
            return $this->avatar;
        }
        $hash = md5(strtolower(trim($this->email)));
        return "https://www.gravatar.com/avatar/{$hash}?s=200&d=mm";
    }

    public function scopeByQuery($query, $q)
    {
        return $query->where('name', 'ilike', "%$q%")
            ->orWhere('email', 'ilike', "%$q%")
            ->orWhere('slug', 'ilike', "%$q%");
    }

    public function searchableAs()
    {
        return 'users_index';
    }
}
