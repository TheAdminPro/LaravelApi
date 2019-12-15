<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::middleware('auth:api')->post('/signup', 'Auth\RegisterController@create');

// Route::post('/api/signup', 'Auth\RegisterController@create');

// Route::apiResource('/signup', 'Auth');


Route::post('/signup', 'Auth@signup');

Route::post('/login', 'Auth@login');

Route::post('/logout', 'Auth@logout')
        ->middleware('apiAuth');

Route::get('/user', 'Auth@user');


