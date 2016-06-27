<?php

namespace Wish\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Wish\User;
use Wish\Wish;

class WishPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Wish $wish)
    {
        return $user->owns($wish);
    }

    public function delete(User $user, Wish $wish)
    {
        return $user->owns($wish);
    }
}
