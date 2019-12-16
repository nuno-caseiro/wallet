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
    // get auth user
    Route::get('/user',function (Request $request){
        return $request->user();
    });

    Route::post('logout', 'LoginControllerAPI@logout');

    //TODO proteger para apenas administrador
    Route::get('users','UserControllerAPI@index');
    Route::delete('users/{id}','UserControllerAPI@destroy');

    //TODO apenas proprio user ou admin
    Route::get('users/{id}', 'UserControllerAPI@show');

    //TODO apenas o proprio user
    //Route::put('users/{id}', 'UserControllerAPI@update');
    Route::patch('users/{id}', 'UserControllerAPI@update');

    //unactivate User
    Route::patch('user/unactivate/{id}', 'UserControllerAPI@unactivate');
    //activate User
    Route::patch('user/activate/{id}', 'UserControllerAPI@activate');

    Route::get('oauth_access_tokens','UserControllerAPI@show');

    Route::delete('wallets/{id}', 'WalletControllerAPI@delete');

    Route::get('wallets/{id}', 'WalletControllerAPI@show');

    Route::put('wallets/{id}', 'WalletControllerAPI@update');

    Route::post('movements', 'MovementControllerAPI@store');
    Route::put('movements/{id}', 'MovementControllerAPI@update');

    Route::put('movements/id/{id}', 'MovementControllerAPI@updateEdit');

    Route::get('movements','MovementControllerAPI@index');
    Route::get('movements/{id}','MovementControllerAPI@show');

    Route::get('movements/id/{wallet_id}','MovementControllerAPI@showMovementsOfWallet');
    Route::post('movements', 'MovementControllerAPI@store');

    Route::delete('movements/{id}', 'MovementControllerAPI@delete');

    Route::get('categories','CategoryControllerAPI@index');
    Route::get('categories/{id}','CategoryControllerAPI@show');
    Route::post('categories', 'CategoryControllerAPI@store');
    Route::delete('categories/{id}', 'CategoryControllerAPI@delete');

    Route::get('categories/type/{type}','CategoryControllerAPI@getCategoriesByType');
    
    
    ///////////////////////////////////STATISTICS//////////////////////////////////////////////////////////
    Route::get('/movements/totalMovements/{dates}', 'Statistics@getTotalMovsFromGivenMonth');

});
////Movement filter
Route::get('movements/1/filter','MovementControllerAPI@filter'); //TODO para mudar de local e de rota

///User filter
Route::get('users/1/filter','UserControllerAPI@filter');


Route::post('login', 'LoginControllerAPI@login')->name('login');

Route::post('users','UserControllerAPI@store');

Route::post('users/email','UserControllerAPI@showByEmail');

Route::get('wallets', 'WalletControllerAPI@index');

Route::post('wallets', 'WalletControllerAPI@store');


