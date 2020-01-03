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
    Route::get('users','UserControllerAPI@index')->middleware('forAll');
    Route::delete('users/{id}','UserControllerAPI@destroy')->middleware('admin');


    //TODO para operador admin e user
    Route::put('users/{id}', 'UserControllerAPI@updateWithoutPass')->middleware('forAll');

    Route::patch('users/{id}', 'UserControllerAPI@update')->middleware('forAll');

    Route::get('users/{id}', 'UserControllerAPI@show')->middleware('forAll');

    //unactivate User
    Route::patch('user/unactivate/{id}', 'UserControllerAPI@unactivate')->middleware('admin');
    //activate User
    Route::patch('user/activate/{id}', 'UserControllerAPI@activate')->middleware('admin');

    Route::get('oauth_access_tokens','UserControllerAPI@show');

    Route::delete('wallets/{id}', 'WalletControllerAPI@delete');

    Route::get('wallets/{id}', 'WalletControllerAPI@show')->middleware('user');

    Route::put('wallets/{id}', 'WalletControllerAPI@update')->middleware('userAndOperator');

    Route::post('movements', 'MovementControllerAPI@store');

    Route::put('movements/{id}', 'MovementControllerAPI@update')->middleware('user');

    Route::put('movements/id/{id}', 'MovementControllerAPI@updateEdit')->middleware('user');

    Route::get('movements','MovementControllerAPI@index');

    Route::get('movements/{id}','MovementControllerAPI@show')->middleware('user');

    Route::get('movements/id/{wallet_id}','MovementControllerAPI@showMovementsOfWallet')->middleware('user');

   // Route::delete('movements/{id}', 'MovementControllerAPI@delete');

    Route::get('categories','CategoryControllerAPI@index')->middleware('userAndOperator');

    Route::get('categories/{id}','CategoryControllerAPI@show')->middleware('userAndOperator');

    Route::post('categories', 'CategoryControllerAPI@store')->middleware('userAndOperator');

    Route::delete('categories/{id}', 'CategoryControllerAPI@delete')->middleware('userAndOperator');

    Route::get('categories/type/{type}','CategoryControllerAPI@getCategoriesByType')->middleware('userAndOperator');


    ///////////////////////////////////STATISTICS//////////////////////////////////////////////////////////
    Route::get('/movements/totalMovements/{dates}', 'StatisticsControllerAPI@getTotalMovsFromGivenMonth');


Route::get('movements/1/filter','MovementControllerAPI@filter')->middleware('user');

Route::get('users/1/filter','UserControllerAPI@filter')->middleware('admin');


Route::post('email', 'EmailAPI@sendEmail')->middleware('userAndOperator');
});

Route::get('wallets', 'WalletControllerAPI@index');

Route::post('login', 'LoginControllerAPI@login');

Route::post('users','UserControllerAPI@store');

Route::post('wallets', 'WalletControllerAPI@store');

Route::get('user/email/{email}','UserControllerAPI@showByEmail');


Route::get('/movements/all/totalMoneyMovedByUsersByMonth', 'StatisticsControllerAPI@getTotalMoneyMovedByUsersByMonth');
Route::get('/movements/all/totalMoneyMovedByUsersByMonthOfYear', 'StatisticsControllerAPI@getTotalMoneyMovedByUsersByMonthOfYear');
Route::get('/movements/all/totalMoneyMovedByUsersAllDaysOfMonth', 'StatisticsControllerAPI@getTotalMoneyMovedByUsersAllDaysOfMonth');
