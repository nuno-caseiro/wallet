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

    //TODO proteger para apenas administrador
    Route::get('users','UserControllerAPI@index');
    //

    Route::get('users/{id}', 'UserControllerAPI@show');
    Route::post('users','UserControllerAPI@store');
    Route::put('users/{id}', 'UserControllerAPI@update');
    Route::delete('users/{id}','UserControllerAPI@destroy');

});




Route::post('login', 'LoginControllerAPI@login')->name('login');
Route::middleware('auth:api')->post('logout', 'LoginControllerAPI@logout');
