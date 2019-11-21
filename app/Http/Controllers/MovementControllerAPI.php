<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movement;
use App\Http\Resources\Movement as MovementResource;

class MovementControllerAPI extends Controller
{
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

    public function store(Request $request){
        //TODO validacoes e deve ser preciso fazer mais alguma coisa

            $movement= new Wallet();
            $movement->fill($request->all());
            $movement->save();

            return response()->json(new WalletResource($movement),201);
    }

    public function update(Request $request, $id){
        //TODO validacoes
        $movement= Movement::findOrFail($id);
        $movement->update($request->all());
        return new MovementResource($movement);
    }

    public function destroy($id){
        $movement= Movement::findOrFail($id);
        $movement->delete();
        return response()->json(null,204);

    }
}
