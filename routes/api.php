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
    Route::get('users','UserControllerAPI@index')->middleware(['admin','user','operator']);
    Route::delete('users/{id}','UserControllerAPI@destroy')->middleware('admin');

    Route::get('users/{id}', 'UserControllerAPI@show');

    //TODO apenas o proprio user
    Route::put('users/{id}', 'UserControllerAPI@updateWithoutPass')->middleware('user');
    Route::patch('users/{id}', 'UserControllerAPI@update')->middleware('user');

    //unactivate User
    Route::patch('user/unactivate/{id}', 'UserControllerAPI@unactivate')->middleware('admin');
    //activate User
    Route::patch('user/activate/{id}', 'UserControllerAPI@activate')->middleware('admin');

    Route::get('oauth_access_tokens','UserControllerAPI@show');

    Route::delete('wallets/{id}', 'WalletControllerAPI@delete');

    Route::get('wallets/{id}', 'WalletControllerAPI@show')->middleware('user');

    Route::put('wallets/{id}', 'WalletControllerAPI@update')->middleware('user');

    Route::post('movements', 'MovementControllerAPI@store')->middleware(['user','operator']);

    Route::put('movements/{id}', 'MovementControllerAPI@update')->middleware('user');

    Route::put('movements/id/{id}', 'MovementControllerAPI@updateEdit')->middleware('user');

    Route::get('movements','MovementControllerAPI@index')->middleware('user');
    Route::get('movements/{id}','MovementControllerAPI@show')->middleware('user');

    Route::get('movements/id/{wallet_id}','MovementControllerAPI@showMovementsOfWallet')->middleware('user');

   // Route::delete('movements/{id}', 'MovementControllerAPI@delete');

    Route::get('categories','CategoryControllerAPI@index')->middleware(['user','operator']);

    Route::get('categories/{id}','CategoryControllerAPI@show')->middleware(['user','operator']);

    Route::post('categories', 'CategoryControllerAPI@store')->middleware(['user','operator']);

    Route::delete('categories/{id}', 'CategoryControllerAPI@delete')->middleware(['user','operator']);

    Route::get('categories/type/{type}','CategoryControllerAPI@getCategoriesByType')->middleware(['user','operator']);


    ///////////////////////////////////STATISTICS//////////////////////////////////////////////////////////
    Route::get('/movements/totalMovements/{dates}', 'Statistics@getTotalMovsFromGivenMonth');

Route::get('movements/1/filter','MovementControllerAPI@filter')->middleware('user');

Route::get('users/1/filter','UserControllerAPI@filter')->middleware('admin');


Route::post('email', 'EmailAPI@sendEmail')->middleware(['user','operator']);
});

Route::get('wallets', 'WalletControllerAPI@index');

Route::post('login', 'LoginControllerAPI@login')->name('login');

Route::post('users','UserControllerAPI@store');


Route::post('wallets', 'WalletControllerAPI@store');

Route::get('user/email/{email}','UserControllerAPI@showByEmail');


