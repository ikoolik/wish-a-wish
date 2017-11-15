<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.  These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::resource('users', 'Users');
Route::resource('wishes', 'Wishes');
Route::resource('users.wishes', 'UserWishes');
Route::resource('bookings', 'Bookings');
Route::resource('archived', 'Archived');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
