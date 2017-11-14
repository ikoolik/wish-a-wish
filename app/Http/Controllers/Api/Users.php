<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Controllers\Controller;

class Users extends Controller
{
    function show(User $user)
    {
        return response()->json($user);
    }

    function index()
    {
        $users = User::search(request('query'))->take(5)->get();
        return response()->json($users);
    }
}
