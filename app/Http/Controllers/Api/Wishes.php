<?php

namespace App\Http\Controllers\Api;

use App\Wish;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Wishes extends Controller
{
    function __construct()
    {
        $this->middleware('auth:api')->except('show');
    }

    function show(Wish $wish)
    {
        return response()->json($wish->load('user'));
    }

    function store()
    {
        $data = request()->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'image_url' => 'nullable|string',
        ]);

        $wish = request()->user()->wishes()->create($data);

        return response()->json($wish);
    }

    function destroy(Wish $wish)
    {
        if(request()->user()->cannot('delete', $wish)) {
            abort(403);
        }

        $wish->delete();
        return response()->json('ok');
    }
}
