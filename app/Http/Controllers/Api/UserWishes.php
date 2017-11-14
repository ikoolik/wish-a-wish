<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserWishes extends Controller
{
    function index(User $user)
    {
        return response()->json($user->wishes);
    }
}
