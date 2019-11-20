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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/
Route::middleware('auth:api')->group(function () {
    Route::post('logout', 'LoginControllerAPI@logout');

    Route::post('users','UserControllerAPI@store');

    //TODO proteger para apenas administrador
    Route::get('users','UserControllerAPI@index');
    Route::delete('users/{id}','UserControllerAPI@destroy');


    //TODO apenas proprio user ou admin
    Route::get('users/{id}', 'UserControllerAPI@show');

    //TODO apenas o proprio user
    Route::put('users/{id}', 'UserControllerAPI@update');

    Route::get('wallets', 'WalletControllerAPI@index');
    Route::post('wallets', 'WalletControllerAPI@store');
    Route::put('wallets/{id}', 'WalletControllerAPI@update');
    Route::delete('wallets/{id}', 'WalletControllerAPI@delete');


});

Route::post('login', 'LoginControllerAPI@login')->name('login');
Route::post('register', 'RegisterControllerAPI@register')->name('register'); //TODO
//Route::middleware('auth:api')->post('logout', 'LoginControllerAPI@logout');
