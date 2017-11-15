<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Wish;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Bookings extends Controller
{
    function __construct()
    {
        $this->middleware('auth:api');
    }

    function destroy(Wish $wish)
    {
        if(request()->user()->cannot('unbook', $wish)) {
            abort(403);
        }

        $wish->bookedBy()->associate(null);
        $wish->save();

        return response()->json($wish->fresh());
    }

    function store()
    {
        $wish = Wish::findOrFail(request('id'));
        if(request()->user()->cannot('book', $wish)) {
            abort(403);
        }

        $wish->bookedBy()->associate(request()->user());
        $wish->save();

        return response()->json($wish);
    }
}
