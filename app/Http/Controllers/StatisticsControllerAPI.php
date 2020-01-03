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

    public function getTotalMoneyMovedByUsersByYear(Request $request){
        try{
            $startYear=2014;
            $stopYear=2020; //TODO mudar anos
            $totalMoney=0;
            $arrayMoney= array();
            for ($i=$startYear;$i<=$stopYear;$i++){
                $totalMovements= DB::table('movements')->where('type','!=','i')
                    ->where('transfer','!=','0')->whereYear('date', '=', $i)->get();
                foreach ($totalMovements as $movement ){
                    $totalMoney+=$movement->value;
                }
                array_push($arrayMoney, ['year' => $i, 'total_money' => round($totalMoney,2)]);
            }
        }catch (\Exception $e){
            return response()->json(['error' => 'ERROR getting total money moved by users.'], 500);

        }
        return response()->json($arrayMoney, 200);
    }

    public function getTotalMoneyMovedByUsersByMonth(Request $request){
        try{
            $startYear=2014;
            $stopYear=2020; //TODO mudar anos
            $totalMoney=0;
            $arrayMoney= array();
            for ($i=$startYear;$i<=$stopYear;$i++){
                for($j=1;$j<=12;$j++){

                $totalMovements= DB::table('movements')->where('type','!=','i')
                    ->where('transfer','!=','0')->whereYear('date', '=', $i)->whereMonth('date','=',$j)->get();
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

    public function getTotalMoneyMovedByUsersByMonthOfYear(Request $request){
        try{
            $year=2019; //TODO Mudar
            $totalMoney=0;
            $arrayMoney= array();
                for($j=1;$j<=12;$j++){
                    $totalMovements= DB::table('movements')->where('type','!=','i')
                        ->where('transfer','!=','0')->whereYear('date', '=', $year)->whereMonth('date','=',$j)
                        ->get();
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
            $year=2019; //TODO Mudar
            $totalMoney=0;
            $arrayMoney= array();
            for($j=1;$j<=12;$j++){
                $totalMovements= DB::table('movements')->where('type','=','i')
                    ->where('transfer','=','0')->whereYear('date', '=', $year)->whereMonth('date','=',$j)
                    ->get();
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
            $year=2019; //TODO Mudar
            $totalMoney=0;
            $arrayMoney= array();
            for($j=1;$j<=12;$j++){
                $totalMovements= DB::table('movements')->where('type','!=','i')
                    ->where('transfer','=','1')->whereYear('date', '=', $year)->whereMonth('date','=',$j)
                    ->get();
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
