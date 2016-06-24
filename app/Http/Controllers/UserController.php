<?php

namespace Wish\Http\Controllers;

use Wish\User;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
}
