<?php

namespace Wish\Policies;

use Wish\User;
use Wish\Wish;
use Illuminate\Auth\Access\HandlesAuthorization;

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
