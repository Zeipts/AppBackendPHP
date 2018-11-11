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


Route::middleware('auth:api', 'cors')->group(function () {
    Route::get('/registercard/{cid}', 'WebController@showTerms');
    Route::get('/doregistercard', 'WebController@presentCardForm')->name('register-card');
});

Route::get('/SuccessPage', 'WebController@cardSuccess');
Route::get('/CancelPage', 'WebController@cardCancelled');
Route::get('/FailPage', 'WebController@cardFailed');