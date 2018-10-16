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

Route::middleware('auth:api')->group(function() {
    Route::post('/refreshLogin', 'ApiController@refreshLogin');
});

Route::post('/registercustomer', 'ApiController@handleRegister');
Route::post('/login', 'ApiController@handleLogin');
