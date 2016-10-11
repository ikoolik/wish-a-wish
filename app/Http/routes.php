<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', [
    'as' => 'landing',
    'uses' => function () {
        if (Auth::check()) {
            return redirect(route('wishes.index'));
        }
        return view('welcome');
    }
]);

Route::get('login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@showLoginForm']);
Route::post('login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@login']);
Route::get('logout', ['as' => 'auth.logout', 'uses' => 'Auth\AuthController@logout']);

// Registration Routes...
Route::get('register', ['as' => 'auth.register', 'uses' => 'Auth\AuthController@showRegistrationForm']);
Route::post('register', ['as' => 'auth.register', 'uses' => 'Auth\AuthController@register']);

// Password Reset Routes...
Route::get('password/reset/{token?}',
    ['as' => 'auth.password.reset', 'uses' => 'Auth\PasswordController@showResetForm']);
Route::post('password/email', ['as' => 'auth.password.email', 'uses' => 'Auth\PasswordController@sendResetLinkEmail']);
Route::post('password/reset', ['as' => 'auth.password.reset', 'uses' => 'Auth\PasswordController@reset']);


Route::resource('wishes', 'WishController');
Route::get('{user}/wishes', ['as' => 'wishes.user_index', 'uses' => 'WishController@index']);
Route::post('wishes/{wishes}/archive', ['as' => 'wishes.archive', 'uses' => 'WishController@archive']);


Route::get('{user}', ['as' => 'users.show', 'uses' => 'UserController@show']);
Route::get('{user}/edit', ['as' => 'users.edit', 'uses' => 'UserController@edit']);
Route::put('{user}/update', ['as' => 'users.update', 'uses' => 'UserController@update']);
