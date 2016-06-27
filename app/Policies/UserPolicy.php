<?php

namespace Wish\Policies;

use Wish\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function update(User $user, User $target)
    {
        return $user->id == $target->id;
    }
}
