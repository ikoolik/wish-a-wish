<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', [
    'as' => 'landing',
    'uses' => function () {
        if (Auth::check()) {
            return redirect(route('wishes.index'));
        }
        return view('welcome');
    }
]);
Route::resource('wishes', 'WishController');
Route::get('{user}/wishes', ['as' => 'wishes.user_index', 'uses' => 'WishController@index']);
Route::post('wishes/{wishes}/archive', ['as' => 'wishes.archive', 'uses' => 'WishController@archive']);
Route::post('wishes/{wishes}/book', ['as' => 'wishes.book', 'uses' => 'WishController@book']);
Route::post('wishes/{wishes}/unbook', ['as' => 'wishes.unbook', 'uses' => 'WishController@unbook']);

Route::get('/oauth/{provider}', ['uses' => 'Auth\SocialAccountsController@redirect']);
Route::get('/oauth/{provider}/callback', ['uses' => 'Auth\SocialAccountsController@callback']);

Route::get('/users', ['as' => 'users.index', 'uses' => 'UserController@index']);
Route::get('{user}', ['as' => 'users.show', 'uses' => 'UserController@show']);
Route::get('{user}/edit', ['as' => 'users.edit', 'uses' => 'UserController@edit']);
Route::put('{user}/update', ['as' => 'users.update', 'uses' => 'UserController@update']);
