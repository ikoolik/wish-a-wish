<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;

class UserPolicy
{
    use HandlesAuthorization;

    public function update(User $user, User $target)
    {
        return $user->id == $target->id;
    }
}
