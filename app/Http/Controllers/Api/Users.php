<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Controllers\Controller;
use Inwave\LaravelUploadcare\Facades\Uploadcare;

class Users extends Controller
{
    function __construct() {
        $this->middleware('auth:api')->only(['update']);
    }

    function show(User $user)
    {
        return response()->json($user);
    }

    function index()
    {
        $users = User::search(request('query'))->take(5)->get();
        return response()->json($users);
    }

    function update(User $user)
    {
        if(request()->user()->cannot('update', $user)) {
            abort(403);
        }

        $data = request()->validate([
            'name' => 'required|string',
            'slug' => 'required|string|unique:users,slug,'.$user->id,
            'avatar' => 'nullable|string'
        ]);

        if($user->avatar !== $data['avatar']) {
            if($user->avatar) Uploadcare::getFile($user->avatar)->delete();
            if($data['avatar']) Uploadcare::getFile($data['avatar'])->store();
        }
        $user->update($data);

        return response()->json($user);
    }
}
