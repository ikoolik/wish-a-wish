<?php

namespace App\Http\Controllers;

use Gate;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    function edit(User $user)
    {
        if (request()->user()->cannot('update', $user)) {
            return redirect(route('users.show', $user->slug))->withErrors("Не достаточно прав");
        }

        return view('users.edit', compact('user'));
    }
}
