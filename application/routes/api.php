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

Route::middleware('auth:api', 'cors')->group(function() {
    Route::post('/refreshLogin/{cid}', 'ApiController@refreshLogin');
    Route::post('/cards/{cid}', 'ApiController@getCards');
    Route::post('/deletecard/{cid}/{cardid}', 'ApiController@removeCard');
    Route::post('/receipts/{cid}', 'ApiController@getReceipts');
});

Route::middleware('cors')->group(function() {
    Route::post('/registercustomer/', 'ApiController@handleRegister');
    Route::post('/login', 'ApiController@handleLogin');
});
