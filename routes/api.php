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
// Route::resource('user', Api\AuthUserController::class);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', 'Api\AuthUserController@logout')->name('user.logout');
    Route::resource('/property', Api\PropertyController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::post('/property-bulk', 'Api\PropertyController@bulkLoad');
    Route::post('/MultipleLoad', 'Api\PropertyController@MultipleLoad');
});

Route::group(['middleware' => ['cors','json.response']], function () {
    Route::post('/login', 'Api\AuthUserController@login')->name('user.login');
    Route::post('/register', 'Api\AuthUserController@register')->name('user.register');
});
