<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;
use App\Wish;

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

    public function book(User $user, Wish $wish)
    {
        return !$user->owns($wish) && !$wish->isBooked();
    }

    public function unbook(User $user, Wish $wish)
    {
        return !$user->owns($wish) && $wish->isBooked() && $wish->isBookedBy($user);
    }
}
