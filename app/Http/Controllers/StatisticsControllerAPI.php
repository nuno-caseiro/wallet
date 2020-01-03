<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Movement;



class StatisticsControllerAPI extends Controller
{
   


    public function getTotalMoneyMovedByUsersBetweenYears(Request $request){
        try{
            $startYear=$request->startYear;
            $stopYear=$request->stopYear;
            $totalMoney=0;
            $arrayMoney= array();
            for ($i=$startYear;$i<=$stopYear;$i++){
                for($j=1;$j<=12;$j++){

                $totalMovements= DB::table('movements')->where('type','!=','i')
                    ->where('transfer','!=','0')->whereYear('date', '=', $i)->whereMonth('date','=',$j)->get();
                    $totalMoney=0;

                    foreach ($totalMovements as $movement ){
                    $totalMoney+=$movement->value;
                }
                array_push($arrayMoney, ['day_month' => $i."-".$j, 'total_money' => round($totalMoney,2)]);
                }

            }
        }catch (\Exception $e){
            return response()->json(['error' => 'ERROR getting total money moved by users.'], 500);
        }
        return response()->json($arrayMoney, 200);
    }


    public function getTotalMoneyMovedByUsersAllDaysOfMonth(Request $request){
        try{
            $date=$request->date;

            $daysOfMonth=Carbon::parse($date)->daysInMonth;
            $arrayMoney= array();
                for($j=1;$j<=$daysOfMonth;$j++){
                    $totalMovements= DB::table('movements')->where('type','!=','i')
                        ->where('transfer','!=','0')->whereYear('date', '=', Carbon::parse($date)->format('Y'))->
                        whereMonth('date','=',Carbon::parse($date)->format('m'))->whereDay('date','=',$j)->get();
                    $totalMoney=0;

                    foreach ($totalMovements as $movement ){
                        $totalMoney+=$movement->value;
                    }
                    array_push($arrayMoney, ['day_month' => $j."-".Carbon::parse($date)->format('m').'-'.Carbon::parse($date)->format('Y'), 'total_money' => round($totalMoney,2)]);
                }
        }catch (\Exception $e){
            return response()->json(['error' => 'ERROR getting total money moved by users.'], 500);
        }
        return response()->json($arrayMoney, 200);
    }

    public function getTotalMovementsFromExternalIncomesByAllDaysOfMonth(Request $request){
        try{
            $date=$request->date;

            $daysOfMonth=Carbon::parse($date)->daysInMonth;
            $arrayMovs= array();
            for($j=1;$j<=$daysOfMonth;$j++){
                $totalMovements= DB::table('movements')->where('type','=','i')
                    ->where('transfer','=','0')->whereYear('date', '=', Carbon::parse($date)->format('Y'))->
                    whereMonth('date','=',Carbon::parse($date)->format('m'))->whereDay('date','=',$j)->count();

                array_push($arrayMovs, ['day_month' => $j."-".Carbon::parse($date)->format('m').'-'.Carbon::parse($date)->format('Y'), 'total_money' => $totalMovements]);
            $arrayMoney= array();
            for($j=1;$j<=$daysOfMonth;$j++){
                $totalMovements= DB::table('movements')->where('type','=','i')
                    ->where('transfer','=','0')->whereYear('date', '=', Carbon::parse($date)->format('Y'))->
                    whereMonth('date','=',Carbon::parse($date)->format('m'))->whereDay('date','=',$j)->get();
                $totalMoney=0;

                foreach ($totalMovements as $movement ){
                    $totalMoney+=$movement->value;
                }
                array_push($arrayMoney, ['day_month' => $j."-".Carbon::parse($date)->format('m').'-'.Carbon::parse($date)->format('Y'), 'total_money' => round($totalMoney,2)]);
            }
        }catch (\Exception $e){
            return response()->json(['error' => 'ERROR getting total money moved by users.'], 500);
        }
        return response()->json($arrayMovs, 200);
    }

    public function getTotalMovementsFromExternalIncomesBetweenYears(Request $request){
        try{
            $startYear=$request->startYear;
            $stopYear=$request->stopYear;
            $arrayMovs= array();
            for ($i=$startYear;$i<=$stopYear;$i++){
                for($j=1;$j<=12;$j++){
                    $totalMovements= DB::table('movements')->where('type','=','i')
                        ->where('transfer','=','0')->whereYear('date', '=', $i)->whereMonth('date','=',$j)->count();
                    array_push($arrayMovs, ['year_month' => $j."-".$i, 'total_money' => round($totalMovements,2)]);
                }
        return response()->json($arrayMoney, 200);
    }

    public function getTotalMoneyFromExternalIncomesBetweenYears(Request $request){
        try{
            $startYear=$request->startYear;
            $stopYear=$request->stopYear;
            $totalMoney=0;
            $arrayMoney= array();
            for ($i=$startYear;$i<=$stopYear;$i++){
                for($j=1;$j<=12;$j++){

                    $totalMovements= DB::table('movements')->where('type','=','i')
                        ->where('transfer','=','0')->whereYear('date', '=', $i)->whereMonth('date','=',$j)->get();
                    $totalMoney=0;

                    foreach ($totalMovements as $movement ){
                        $totalMoney+=$movement->value;
                    }
                    array_push($arrayMoney, ['year_month' => $i."-".$j, 'total_money' => round($totalMoney,2)]);
                }

            }
        }catch (\Exception $e){
            return response()->json(['error' => 'ERROR getting total money moved by users.'], 500);
        }
        return response()->json($arrayMovs, 200);
    }

    public function getTotalInternalTransfersAllDaysOfMonth(Request $request){
        try{
            $date=$request->date;

            $daysOfMonth=Carbon::parse($date)->daysInMonth;
            $arrayMovs= array();
            for($j=1;$j<=$daysOfMonth;$j++){
                $totalMovements=0;
                $totalMovements= DB::table('movements')->where('type','=','e')
                    ->where('transfer','=','1')->whereYear('date', '=', Carbon::parse($date)->format('Y'))->
                    whereMonth('date','=',Carbon::parse($date)->format('m'))->whereDay('date','=',$j)->count();

                array_push($arrayMovs, ['day_month' => $j."-".Carbon::parse($date)->format('m').'-'.Carbon::parse($date)->format('Y'), 'total_movs' => $totalMovements]);
            }
        }catch (\Exception $e){
            return response()->json(['error' => 'ERROR getting total money moved by users.'], 500);
        }
        return response()->json($arrayMovs, 200);

    }

    public function getTotalInternalTransfersBetweenYears(Request $request){
        try{
            $startYear=$request->startYear;
            $stopYear=$request->stopYear;
            $arrayMovs= array();
            for ($i=$startYear;$i<=$stopYear;$i++){
                for($j=1;$j<=12;$j++){
                    $totalMovements= DB::table('movements')->where('type','=','e')
                        ->where('transfer','=','1')->whereYear('date', '=', $i)->whereMonth('date','=',$j)->count();

                    array_push($arrayMovs, ['year_month' => $j."-".$i, 'total_movs' => $totalMovements]);
                }
            }
        }catch (\Exception $e){
            return response()->json(['error' => 'ERROR getting total money moved by users.'], 500);
        }
        return response()->json($arrayMovs, 200);
    }

    // USER


    public function getTotalExpensesByUser(Request $request){
        try{
            $userId=$request->wallet_id;

                $totalExpenses= DB::table('movements')->where('type','=','e')
                    ->where('transfer','=','0')->where('wallet_id','=',$userId)->count();

                array_push($totalExpensesArray, ['total_expenses' => $totalExpenses]);

        }catch (\Exception $e){
            return response()->json(['error' => 'ERROR getting total expenses of user.'], 500);

        }
        return response()->json($totalExpensesArray, 200);

    }


    public function getTotalMoneyExpensesAllDaysOfMonth(Request $request){
        try{
            $date=$request->date;
            $userId=$request->wallet_id;
            $daysOfMonth=Carbon::parse($date)->daysInMonth;
            $arrayMoney= array();
                $totalMoney=0;
            for($j=1;$j<=$daysOfMonth;$j++){
                $totalMovements= DB::table('movements')->where('type','=','e')->where('wallet_id','=',$userId)
                    ->whereYear('date', '=', Carbon::parse($date)->format('Y'))->
                    whereMonth('date','=',Carbon::parse($date)->format('m'))->whereDay('date','=',$j)->get();
                $totalMoney=0;
                foreach ($totalMovements as $movement ){
                    $totalMoney+=$movement->value;
                }
                array_push($arrayMoney, ['day_month' => $j."-".Carbon::parse($date)->format('m').'-'.Carbon::parse($date)->format('Y'), 'total_money' => $totalMoney]);
            }
        }catch (\Exception $e){
            return response()->json(['error' => 'ERROR getting total money moved by users.'], 500);
        }
        return response()->json($arrayMoney, 200);

    }

    public function getTotalMoneyExpensesOfUserBetweenYears(Request $request){
        try{
            $startYear=$request->startYear;
            $stopYear=$request->stopYear;
            $userId=$request->wallet_id;
            $arrayMoney= array();
            for ($i=$startYear;$i<=$stopYear;$i++){
                for($j=1;$j<=12;$j++) {
                    $totalMovements= DB::table('movements')->where('type','=','e')->where('wallet_id','=',$userId)
                        ->where('transfer','!=','0')->whereYear('date', '=', $i)->whereMonth('date','=',$j)->get();
                    $totalMoney=0;
                    foreach ($totalMovements as $movement ){
                        $totalMoney+=$movement->value;
                    }
                    array_push($arrayMoney, ['year_month' => $i."-".$j, 'total_money' => round($totalMoney,2)]);
                }
            }
        }catch (\Exception $e){
            return response()->json(['error' => 'ERROR getting total money moved by users.'], 500);
        }
        return response()->json($arrayMoney, 200);

    }

    public function getTotalMoneyIncomesAllDaysOfMonth(Request $request){
        try{
            $date=$request->date;
            $userId=$request->wallet_id;
            $daysOfMonth=Carbon::parse($date)->daysInMonth;
            $arrayMoney= array();
            $totalMoney=0;
            for($j=1;$j<=$daysOfMonth;$j++){
                $totalMovements= DB::table('movements')->where('type','=','i')->where('wallet_id','=',$userId)
                    ->whereYear('date', '=', Carbon::parse($date)->format('Y'))->
                    whereMonth('date','=',Carbon::parse($date)->format('m'))->whereDay('date','=',$j)->get();
                $totalMoney=0;
                foreach ($totalMovements as $movement ){
                    $totalMoney+=$movement->value;
                }
                array_push($arrayMoney, ['day_month' => $j."-".Carbon::parse($date)->format('m').'-'.Carbon::parse($date)->format('Y'), 'total_money' => $totalMoney]);
            }
        }catch (\Exception $e){
            return response()->json(['error' => 'ERROR getting total money moved by users.'], 500);
        }
        return response()->json($arrayMoney, 200);

    }

    public function getTotalMoneyIncomessOfUserBetweenYears(Request $request){
        try{
            $startYear=$request->startYear;
            $stopYear=$request->stopYear;
            $userId=$request->wallet_id;
            $arrayMoney= array();
            for ($i=$startYear;$i<=$stopYear;$i++){
                for($j=1;$j<=12;$j++) {
                    $totalMovements= DB::table('movements')->where('type','=','i')->where('wallet_id','=',$userId)
                        ->where('transfer','!=','0')->whereYear('date', '=', $i)->whereMonth('date','=',$j)->get();
                    $totalMoney=0;
                    foreach ($totalMovements as $movement ){
                        $totalMoney+=$movement->value;
                    }
                    array_push($arrayMoney, ['year_month' => $i."-".$j, 'total_money' => round($totalMoney,2)]);
                }
            }
        }catch (\Exception $e){
            return response()->json(['error' => 'ERROR getting total money moved by users.'], 500);
        }
        return response()->json($arrayMoney, 200);

    }

    public function getBalanceThroughTimeAllDaysOfMonth(Request $request){
        try{
            $date=$request->date;
            $userId=$request->wallet_id;
            $daysOfMonth=Carbon::parse($date)->daysInMonth;
            $arrayMoney= array();
            $totalMoney=0;
            for($j=1;$j<=$daysOfMonth;$j++){
                $totalMovements= DB::table('movements')->where('wallet_id','=',$userId)
                    ->whereYear('date', '=', Carbon::parse($date)->format('Y'))->
                    whereMonth('date','=',Carbon::parse($date)->format('m'))->whereDay('date','=',$j)->get();
                foreach ($totalMovements as $movement ){
                    if($movement->type=='i'){

                    $totalMoney+=$movement->value;
                    }else{
                        $totalMoney-=$movement->value;

                    }
                }
                array_push($arrayMoney, ['day_month' => $j."-".Carbon::parse($date)->format('m').'-'.Carbon::parse($date)->format('Y'), 'total_money' => $totalMoney]);
            }
        }catch (\Exception $e){
            return response()->json(['error' => 'ERROR getting total money moved by users.'], 500);
        }
        return response()->json($arrayMoney, 200);

    }

    public function getBalanceThroughTimeBetweenYears(Request $request){
        try{
            $startYear=$request->startYear;
            $stopYear=$request->stopYear;
            $userId=$request->wallet_id;
            $arrayMoney= array();
            $totalMoney=0;
            for ($i=$startYear;$i<=$stopYear;$i++) {
                for ($j = 1; $j <= 12; $j++) {
                    $totalMovements = DB::table('movements')->where('wallet_id', '=', $userId)
                        ->whereYear('date', '=', $i)->whereMonth('date', '=', $j)->get();

                    foreach ($totalMovements as $movement) {
                        if ($movement->type == 'i') {

                            $totalMoney += $movement->value;
                        } else {
                            $totalMoney -= $movement->value;

                        }
                    }
                    array_push($arrayMoney, ['year_month' => $i . "-" . $j, 'total_money' => round($totalMoney, 2)]);
                }
            }
        }catch (\Exception $e){
            return response()->json(['error' => 'ERROR getting total money moved by users.'], 500);
        }
        return response()->json($arrayMoney, 200);

    }



    public function getTotalAccesses(Request $request){
        $totalAccessesArray = array();
        try{
            $accesses = DB::table('oauth_access_tokens')->count();
            array_push($totalAccessesArray, ['total_accesses' => $accesses]);
        }catch (\Exception $e){
            return response()->json(['error' => 'ERROR getting total accesses.'], 500);

        }
        return response()->json($totalAccessesArray, 200);

    }

    

    public function getTotalActiveUsers(Request $request){
        $totalExpensesArray = array();
        try{
            $users = DB::table('users')->where('active','=',1)->count();
            array_push($totalExpensesArray, ['total_users' => $users]);
        }catch (\Exception $e){
            return response()->json(['error' => 'ERROR getting total active users.'], 500);

        }
        return response()->json($totalExpensesArray, 200);

    }

    public function getTotalMovements(Request $request){
        $totalMovementsArray = array();
        try{
            $movs = DB::table('movements')->count();
            array_push($totalMovementsArray, ['total_movs' => $movs]);
        }catch (\Exception $e){
            return response()->json(['error' => 'ERROR getting total movements.'], 500);

        }
        return response()->json($totalMovementsArray, 200);

    }

    public function getTotalMoneyOnPlatform(Request $request){
        $totalMoneyArray = array();
        $totalMoney=0;
        try{
            $wallets = DB::table('wallets')->get();
            foreach ($wallets as $wallet ){
                $totalMoney+=$wallet->balance;
            }
            array_push($totalMoneyArray, ['total_money' => round($totalMoney,2)]);
        }catch (\Exception $e){
            return response()->json(['error' => 'ERROR getting total movements.'], 500);

        }
        return response()->json($totalMoneyArray, 200);

    }






}
