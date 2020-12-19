<?php

namespace App;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasSlug, Searchable, HasApiTokens;

    protected $fillable = ['slug', 'name', 'email', 'password', 'avatar', 'api_token'];

    protected $hidden = ['password', 'remember_token', 'api_token'];

    protected $appends = ['avatar_url'];

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
        return $this->avatar_url;
    }

    public function getAvatarUrlAttribute()
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
