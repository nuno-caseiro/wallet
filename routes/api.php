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
    Route::put('/withoutPass/users/{id}', 'UserControllerAPI@updateWithoutPass');

    Route::patch('users/{id}', 'UserControllerAPI@update');

    Route::get('users/{id}', 'UserControllerAPI@show')->middleware('forAll');

    //unactivate User
    Route::patch('user/unactivate/{id}', 'UserControllerAPI@unactivate')->middleware('admin');
    //activate User
    Route::patch('user/activate/{id}', 'UserControllerAPI@activate')->middleware('admin');

    // Route::get('oauth_access_tokens','UserControllerAPI@show');

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
    Route::get('/movements/all/totalMoneyMovedByUsersBetweenYears', 'StatisticsControllerAPI@getTotalMoneyMovedByUsersBetweenYears')->middleware('admin');
    Route::get('/movements/all/totalMoneyMovedByUsersAllDaysOfMonth', 'StatisticsControllerAPI@getTotalMoneyMovedByUsersAllDaysOfMonth')->middleware('admin');
    Route::get('/movements/all/totalMovementsFromExternalIncomesByAllDaysOfMonth', 'StatisticsControllerAPI@getTotalMovementsFromExternalIncomesByAllDaysOfMonth')->middleware('admin');
    Route::get('/movements/all/totalMovementsFromExternalIncomesBetweenYears', 'StatisticsControllerAPI@getTotalMovementsFromExternalIncomesBetweenYears')->middleware('admin');
    Route::get('/movements/all/totalInternalTransfersAllDaysOfMonth', 'StatisticsControllerAPI@getTotalInternalTransfersAllDaysOfMonth')->middleware('admin');
    Route::get('/movements/all/totalInternalTransfersBetweenYears', 'StatisticsControllerAPI@getTotalInternalTransfersBetweenYears')->middleware('admin');

    Route::get('/movements/all/totalActiveUsers', 'StatisticsControllerAPI@getTotalActiveUsers')->middleware('admin');
    Route::get('/oauth_access_tokens/all/totalAccesses', 'StatisticsControllerAPI@getTotalAccesses')->middleware('admin');
    Route::get('/movements/all/totalMovements', 'StatisticsControllerAPI@getTotalMovements')->middleware('admin');
    Route::get('/wallets/all/totalMoneyOnPlatform', 'StatisticsControllerAPI@getTotalMoneyOnPlatform')->middleware('admin');
    Route::get('/movements/all/totalMoneyExpensesAllDaysOfMonth', 'StatisticsControllerAPI@getTotalMoneyExpensesAllDaysOfMonth')->middleware('user');
    Route::get('/movements/all/totalMoneyExpensesOfUserBetweenYears', 'StatisticsControllerAPI@getTotalMoneyExpensesOfUserBetweenYears')->middleware('user');
    Route::get('/movements/all/totalMoneyIncomesAllDaysOfMonth', 'StatisticsControllerAPI@getTotalMoneyIncomesAllDaysOfMonth')->middleware('user');
    Route::get('/movements/all/totalMoneyIncomesOfUserBetweenYears', 'StatisticsControllerAPI@getTotalMoneyIncomesOfUserBetweenYears')->middleware('user');
    Route::get('/movements/all/balanceThroughTimeAllDaysOfMonth', 'StatisticsControllerAPI@getBalanceThroughTimeAllDaysOfMonth')->middleware('user');
    Route::get('/movements/all/balanceThroughTimeBetweenYears', 'StatisticsControllerAPI@getBalanceThroughTimeBetweenYears')->middleware('user');

    Route::get('/statistics/all/totalExpensesOfUser/{wallet_id}', 'StatisticsControllerAPI@getTotalExpensesOfUser')->middleware('user');
    Route::get('/statistics/all/totalIncomesOfUser/{wallet_id}', 'StatisticsControllerAPI@getTotalIncomesOfUser')->middleware('user');



    Route::get('movements/1/filter','MovementControllerAPI@filter')->middleware('user');

Route::get('users/1/filter','UserControllerAPI@filter')->middleware('admin');


Route::post('email', 'EmailAPI@sendEmail')->middleware('userAndOperator');
});

Route::get('wallets', 'WalletControllerAPI@index');

Route::post('login', 'LoginControllerAPI@login');

Route::post('users','UserControllerAPI@store');

Route::post('wallets', 'WalletControllerAPI@store');

Route::get('user/email/{email}','UserControllerAPI@showByEmail');




    //Route::get('/movements/all/expensesByCategoryBetweenYears', 'StatisticsControllerAPI@getExpensesByCategoryBetweenYears');







