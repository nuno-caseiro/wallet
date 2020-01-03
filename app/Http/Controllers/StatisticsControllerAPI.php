<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Movement;



class StatisticsControllerAPI extends Controller
{
    public function getTotalMovsFromGivenMonth(Request $request, $dates) {
        $arrayOfDatesAndAVG = array();
        $datesToCompare = explode(',', $dates);

        foreach ($datesToCompare as $date) {
            try {
                $totalMovsFromGivenMonth =
                    DB::table('movements')
                        ->whereYear('date', '=', Carbon::parse($date)->format('Y'))
                        ->whereMonth('date', '=', Carbon::parse($date)->format('m'))
                        ->count();
                array_push($arrayOfDatesAndAVG, ['date' => $date, 'total_movements' => $totalMovsFromGivenMonth]);
            }catch (\Exception $e){
                return response()->json(['error' => 'Invalid date format.'], 500);
            }
        }
        return response()->json($arrayOfDatesAndAVG, 200);
    }


    public function getTotalMoneyMovedByUsersByMonth(Request $request){
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
                array_push($arrayMoney, ['year_month' => $i."-".$j, 'total_money' => round($totalMoney,2)]);
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

    public function getTotalMoneyMovedByUsersByMonthOfYear(Request $request){
        try{
            $year=$request->year;
            $totalMoney=0;
            $arrayMoney= array();
                for($j=1;$j<=12;$j++){
                    $totalMovements= DB::table('movements')->where('type','!=','i')
                        ->where('transfer','!=','0')->whereYear('date', '=', $year)->whereMonth('date','=',$j)
                        ->get();
                    $totalMoney=0;
                    foreach ($totalMovements as $movement ){
                        $totalMoney+=$movement->value;
                    }
                    array_push($arrayMoney, ['year_month' => $year."-".$j, 'total_money' => round($totalMoney,2)]);
                }
        }catch (\Exception $e){
            return response()->json(['error' => 'ERROR getting total money moved by users.'], 500);
        }
        return response()->json($arrayMoney, 200);
    }

    public function getTotalMoneyFromExternalIncomesByMonthOfYear(Request $request){
        try{
            $year=$request->year;
            $totalMoney=0;
            $arrayMoney= array();
            for($j=1;$j<=12;$j++){
                $totalMovements= DB::table('movements')->where('type','=','i')
                    ->where('transfer','=','0')->whereYear('date', '=', $year)->whereMonth('date','=',$j)
                    ->get();
                $totalMoney=0;
                foreach ($totalMovements as $movement ){
                    $totalMoney+=$movement->value;
                }
                array_push($arrayMoney, ['year_month' => $year."-".$j, 'total_money' => round($totalMoney,2)]);
            }
        }catch (\Exception $e){
            return response()->json(['error' => 'ERROR getting total money moved by users.'], 500);

        }
        return response()->json($arrayMoney, 200);

    }

    public function getTotalTransfersByUsersByMonthOfYear(Request $request){
        try{
            $year=$request->year;
            $totalMoney=0;
            $arrayMoney= array();
            for($j=1;$j<=12;$j++){
                $totalMovements= DB::table('movements')->where('type','!=','i')
                    ->where('transfer','=','1')->whereYear('date', '=', $year)->whereMonth('date','=',$j)
                    ->count();

                array_push($totalMovements, ['year_month' => $year."-".$j, 'total_money' => $totalMovements]);
            }
        }catch (\Exception $e){
            return response()->json(['error' => 'ERROR getting total money moved by users.'], 500);

        }
        return response()->json($arrayMoney, 200);

    }

    // USER


    public function getTotalExpensesByUser(Request $request){
        try{

                $totalExpenses= DB::table('movements')->where('type','!=','i')
                    ->where('transfer','=','1')->where('wallet_id','=','userId')->count();

                array_push($totalExpensesArray, ['total_expenses' => $totalExpenses]);

        }catch (\Exception $e){
            return response()->json(['error' => 'ERROR getting total expenses of user.'], 500);

        }
        return response()->json($totalExpensesArray, 200);

    }








}
