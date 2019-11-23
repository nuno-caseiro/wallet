<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


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

    public function showByEmail(Request $request){
        return new UserResource(User::where('email',$request->email)->get());
    }

    public function store(Request $request){
        /*$request->validate([
            // 'name' => 'required|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
            // 'email' => 'required|email|unique:users,email,',
            // 'NIF'=> 'required|min:8|unique',
            // 'selectedFile' => 'nullable',
            // 'password' => 'required|min:3|confirmed',
            // 'password_confirmation' => 'required|min:3'
        ]);*/
        //TODO validacoes
        $user= new User();
        $user->fill($request->all()+['remember_token'=> Str::random(10)]);
        if($request->photo!=null){
            $imageName= time().'.'.$request->photo->getClientOriginalExtension();
            $request->image->move(public_path('fotos'),$imageName);

            $user->photo=$imageName;
        }else{
            $user->photo=null;
        }


        $user->password= Hash::make($user->password);
        $user->save();

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
