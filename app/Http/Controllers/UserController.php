<?php

namespace App\Http\Controllers;

use Gate;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{

    /**
     * @return mixed
     */
    public function index()
    {
        if(!request('q')) {
            return [];
        }

        return User::take(request('limit', 5))->byQuery(request('q'))->get(['name', 'slug']);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     *
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Display the edit page
     *
     * @param User $user
     *
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        if (Gate::denies('update', $user)) {
            return redirect(route('users.show', $user->slug))->withErrors("Не достаточно прав");
        }

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if (Gate::denies('update', $user)) {
            return abort(403, 'Insufficient permission');
        }

        $this->validate($request, [
            'slug' => 'required|string|unique:users,slug,' . $user->id,
            'name' => 'required|string'
        ]);

        $user->update($request->only(['name', 'slug']));

        return redirect(route('users.show', $user));
    }
}
