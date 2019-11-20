<?php

namespace App\Http\Controllers;

use App\Wallet;
use Illuminate\Http\Request;
use App\Http\Resources\Wallet as WalletResource;

class WalletControllerAPI extends Controller
{
    public function index(Request $request){
        if($request->has('page')){
            return WalletResource::collection(User::paginate(5));
        }else{
            return WalletResource::collection(User::all());
        }
    }

    public function show($id){
        return new WalletResource(Wallet::find($id));
    }

    public function store(Request $request){
        //TODO validacoes && verificar se ja existe do lado do cliente aka vue?? depois de criar cliente enviar post para criar wallet??

        if(Wallet::findOrFail($request->id)!=false ){
            $wallet= new Wallet();
            $wallet->fill($request->all());
            $wallet->balance=0;
            $wallet->save();

            //TODO create wallet if type user...
            return response()->json(new WalletResource($wallet),201);
        }


    }

    public function update(Request $request, $id){
        //TODO validacoes
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
