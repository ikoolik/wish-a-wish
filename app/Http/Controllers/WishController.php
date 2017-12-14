<?php

namespace App\Http\Controllers;

use AWS;
use Config;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;
use App\Http\Requests;
use App\User;
use App\Wish;

class WishController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['create']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        if (!$user->exists) {

            if (!auth()->check()) {
                return redirect(url('/login'))->withErrors('Чтоб просматривать список желаний нужно авторизоваться.');
            }

            return redirect(route('wishes.user_index', auth()->user()->slug));
        }

        $wishes = $user->wishes()->notArchived()->orderBy('created_at', 'desc')->get();
        return view('wishes.index', compact('wishes', 'user'));

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
     * Display the specified resource.
     *
     * @param Wish $wish
     *
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
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Wish $wish)
    {
        if (Gate::denies('update', $wish)) {
            return redirect(route('wishes.show', $wish->id))->withErrors("У вас нет прав на изменение этого желания");
        }

        return view('wishes.edit', compact('wish'));
    }
}
