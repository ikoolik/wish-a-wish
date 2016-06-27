<?php

namespace Wish\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Wish\User;

class UserPolicy
{
    use HandlesAuthorization;

    public function update(User $user, User $target)
    {
        return $user->id == $target->id;
    }
}
