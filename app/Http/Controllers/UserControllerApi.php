<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserControllerApi extends Controller
{
    public function index(Request $request){
        if($request->has('page')){
            return UserResource::collection(User::paginate(5));
        }else{
            return UserResource::collection(User::all());
        }


    }

    public function show($id){
        return new UserResource(User::find($id));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
            'email' => 'required|email|unique:users,email,',
            'nif' => 'integer|between:9,12',
            'password' => 'required|min:3',
            'password_confirmation' => 'required|min:3',
        ]);
        //TODO validacoes
        $user= new User();
        $user->fill($request->all());
        $user->password= Hash::make($user->password);
        $user->save();

        //TODO create wallet if type user...
        return response()->json(new UserResource($user),201);
    }

    public function update(Request $request, $id){
        //TODO validacoes
        $user= User::findOrFail($id);
        $user->update($request->all());
        return new UserResource($user);
    }

    public function destroy($id){
        $user= User::findOrFail($id);
        $user->delete();
        return response()->json(null,204);

    }


}
