<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\User;
use App\Wish;
use Gate;
use Illuminate\Http\Request;
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
        if (!$user->exists) {

            if (!Auth::check()) {
                return redirect(url('/login'))->withErrors('Чтоб просматривать список желаний нужно авторизоваться.');
            }

            $user = Auth::user();
        }

        $wishes = $user->wishes()->orderBy('created_at', 'desc')->get();
        return view('wishes.index', compact('wishes', 'user'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->middleware('auth');

        return view('wishes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->middleware('auth');

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
        if (Gate::denies('update', $wish)) {
            return redirect(route('wishes.show', $wish->id))->withErrors("У вас нет прав на изменение этого желания");
        }

        return view('wishes.edit', compact('wish'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Wish $wish
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wish $wish)
    {
        if (Gate::denies('update', $wish)) {
            return abort(403, 'Insufficient permission');
        }

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
        if (Gate::denies('delete', $wish)) {
            return abort(403, 'Insufficient permission');
        }

        $wish->delete();
        return redirect(route('wishes.index'));
    }
}
