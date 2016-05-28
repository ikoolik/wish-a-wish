<?php

namespace App\Http\Controllers;

use App\User;
use App\Wish;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class WishController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        if(!$user->exists) {

            if(!Auth::check()) {
                abort(404);
            }
            
            $user = Auth::user();
        }

        $wishes = $user->wishes()->orderBy('created_at', 'desc')->get();
        return view('wishes.index', compact('wishes'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('wishes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Auth::user()->wishes()->create($request->all());
        return redirect(route('wishes.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param Wish $wish
     * @return \Illuminate\Http\Response
     */
    public function show(Wish $wish)
    {
        return view('wishes.show', compact('wish'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Wish $wish
     * @return \Illuminate\Http\Response
     */
    public function edit(Wish $wish)
    {
        return view('wishes.edit', compact('wish'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Wish $wish
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wish $wish)
    {
        $wish->update($request->all());

        return redirect(route('wishes.show', $wish->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Wish $wish
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wish $wish)
    {
        $wish->delete();
        return redirect(route('wishes.index'));
    }
}
