<?php

namespace Wish\Http\Controllers;

use AWS;
use Image;
use Config;
use Wish\Http\Requests;
use Wish\User;
use Wish\Wish;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['create', 'store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param User $user
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
        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'string',
            'image' => 'image',
            'image_url' => 'string',
            'image_upload_type' => 'string'
        ]);

        $wish = Auth::user()->wishes()->create($request->except('image_url', 'image_upload_type'));

        if($request->get('image_upload_type')) {
            switch ($request->get('image_upload_type')) {
                case 'file' :
                    if(!is_null($request->file('image'))) {
                        $wish->setImageFromFile($request->file('image'))->save();
                    }
                    break;
                case 'url' :
                    if(!is_null($request->get('image_url'))) {
                        $wish->image_url = $request->get('image_url');
                        $wish->save();
                    }
            }
        }
        
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

        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'string',
            'image' => 'image',
            'image_url' => 'string',
            'image_upload_type' => 'string'
        ]);

        $wish->update($request->except('image_url', 'image_upload_type'));

        if($request->get('image_upload_type')) {
            switch ($request->get('image_upload_type')) {
                case 'file' :
                    if(!is_null($request->file('image'))) {
                        $wish->setImageFromFile($request->file('image'))->save();
                    }
                    break;
                case 'url' :
                    if(!is_null($request->get('image_url'))) {
                        $wish->image_url = $request->get('image_url');
                        $wish->save();
                    }
            }
        }

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
