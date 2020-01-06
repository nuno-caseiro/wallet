<?php

namespace App\Http\Controllers;

use App\Wallet;
use Illuminate\Http\Request;
use App\Http\Resources\Wallet as WalletResource;

class WalletControllerAPI extends Controller
{
    public function index(Request $request){
        if($request->has('page')){
            return WalletResource::collection(Wallet::paginate(5));
        }else{
            return WalletResource::collection(Wallet::all());
        }
    }

    public function show($id){
        return new WalletResource(Wallet::find($id));
    }

    public function store(Request $request){


            $wallet= new Wallet();
            $wallet->fill($request->all());
            $wallet->save();

            return response()->json(new WalletResource($wallet),201);



    }

    public function update(Request $request, $id){
        $wallet= Wallet::findOrFail($id);
        $wallet->update($request->all());
        return new WalletResource($wallet);
    }

    public function destroy($id){
        $wallet= Wallet::findOrFail($id);
        $wallet->delete();
        return response()->json(null,204);

    }

}
