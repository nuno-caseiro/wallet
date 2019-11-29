<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use App\Movement;
use App\Http\Resources\Movement as MovementResource;

class MovementControllerAPI extends Controller
{
    // $comment = App\Movement::find(1);

    // echo $comment->category->name;


    public function index(Request $request){
        if($request->has('page')){
            return MovementResource::collection(Movement::paginate(5));
        }else{
            return MovementResource::collection(Movement::all());

        }
    }

    public function show($id){
        return new MovementResource(Movement::find($id));
    }

    public function showMovementsOfWallet($wallet_id){
        return (MovementResource::collection(Movement::where('wallet_id',$wallet_id)->orderBy('date', 'desc')->paginate(5)))->response()->setStatusCode(200);
    }



    public function store(Request $request){
        //TODO validacoes e deve ser preciso fazer mais alguma coisa

            $now= new DateTime();
            $movement= new Movement();
            $movement->fill($request->all());
            $movement->date=$now;
            $movement->save();

            return response()->json(new MovementResource($movement),201);
    }

    public function update(Request $request, $id){
        //TODO validacoes
        $movement= Movement::findOrFail($id);
        $movement->fill($request->all());
        $movement->date=Carbon::parse($request->date['date']);
        $movement->save();
        return new MovementResource($movement);
    }

    public function destroy($id){
        $movement= Movement::findOrFail($id);
        $movement->delete();
        return response()->json(null,204);

    }


}
