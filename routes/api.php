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

    //TODO proteger para apenas administrador
    Route::get('users','UserControllerAPI@index');
    Route::delete('users/{id}','UserControllerAPI@destroy');

    //TODO apenas proprio user ou admin
    Route::get('users/{id}', 'UserControllerAPI@show');

    //TODO apenas o proprio user
    Route::put('users/{id}', 'UserControllerAPI@update');

    Route::put('wallets/{id}', 'WalletControllerAPI@update');
    Route::delete('wallets/{id}', 'WalletControllerAPI@delete');


    Route::get('movements','MovementControllerAPI@index');
    Route::get('movements/{id}','MovementControllerAPI@show');
    Route::post('movements', 'MovementControllerAPI@store');
    Route::delete('movements/{id}', 'MovementControllerAPI@delete');


});

Route::post('login', 'LoginControllerAPI@login')->name('login');

Route::get('wallets', 'WalletControllerAPI@index');

Route::post('users','UserControllerAPI@store');
Route::post('wallets', 'WalletControllerAPI@store');

