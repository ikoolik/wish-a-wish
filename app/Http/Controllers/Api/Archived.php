<?php

namespace App\Http\Controllers\Api;

use App\Wish;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Archived extends Controller
{
    function __construct()
    {
        $this->middleware('auth:api');
    }

    function store()
    {
        $wish = Wish::findOrFail(request('id'));
        if(request()->user()->cannot('update', $wish)) {
            abort(403);
        }

        $wish->archive();
        return response()->json($wish);
    }
}
