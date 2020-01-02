<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Movement;



class Statistics extends Controller
{
    //totalMovimentos
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
                array_push($arrayOfDatesAndAVG, ['date' => $date, 'Total Movements' => $totalMovsFromGivenMonth]);
            }catch (\Exception $e){
                return response()->json(['error' => 'Invalid date format.'], 500);
            }
        }
        return response()->json($arrayOfDatesAndAVG, 200);
    }

    //total de users
    public function getTotalUsersFromGivenMonth(Request $request, $dates) {
        $arrayOfDatesAndAVG = array();
        $datesToCompare = explode(',', $dates);

        foreach ($datesToCompare as $date) {
            try {
                $totalMovsFromGivenMonth = 
                    DB::table('users')
                        ->whereYear('date', '=', Carbon::parse($date)->format('Y'))
                        ->whereMonth('date', '=', Carbon::parse($date)->format('m'))
                        ->count();
                array_push($arrayOfDatesAndAVG, ['date' => $date, 'Total Users' => $totalMovsFromGivenMonth]);
            }catch (\Exception $e){
                return response()->json(['error' => 'Invalid date format.'], 500);
            }
        }
        return response()->json($arrayOfDatesAndAVG, 200);
    }





}
