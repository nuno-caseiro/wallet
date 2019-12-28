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
            //return Resource::collection(User::all());
            return UserResource::collection(User::paginate(5));
        }


    }

    public function show($id){
        return new UserResource(User::find($id));
    }

    public function showByEmail(Request $request){
        return new UserResource(User::where('email',$request->email)->get());
    }

    public function store(Request $request){
        
        $data = $request->all();
        if(($request['type']) == 'u'){
            $request->validate([
                'name' => 'required|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
                'email' => 'required|email|unique:users,email,',
                'nif'=> 'required|min:9|unique:users|regex:/^[0-9]+$/',
                'password' => 'required|min:3',
            ]);
        }
        else{
            $request->validate([
                'name' => 'required|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
                'email' => 'required|email|unique:users,email,',
                'nif'=> 'nullable|min:9|unique:users|regex:/^[0-9]+$/',
                'password' => 'required|min:3',
            ]);
        }

      

        //TODO validacoes
        $user= new User();
        $user->fill($request->all()+['remember_token'=> Str::random(10)]);

        if(strpos($request->input('photo'),'data:image/')!==false){
            $exploded=explode(',', $request->photo);
            $decoded= base64_decode($exploded[1]);
            if(Str::contains($exploded[0],'jpeg')|| Str::contains($exploded[0],'jpg')){
                $extension='jpg';
            }else{
                $extension='png';
            }
            $fileName= Str::random().'.'.$extension;

            $path=storage_path('app/public/fotos/').$fileName;
            file_put_contents($path,$decoded);

            $user->photo=$fileName;
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
        $data = $request->all();
        
        if(Hash::check($data['old_password'], $user->password)){
        $request->merge(['password' => Hash::make($request->get('password'))]);
        $user->fill($request->all());
        }
        
        //else{
        //     $user->delete();
        //     return response()->json(null,204); 
        // }
        $user->save();
        return (new UserResource($user))->response()->setStatusCode(200);
    }


    public function updateWithoutPass(Request $request, $id){
        //TODO validacoes
        $user= User::findOrFail($id);
        //$data = $request->all();
        $user->fill($request->all());
        $user->save();
        return (new UserResource($user))->response()->setStatusCode(200);
    }

    

    public function destroy($id){
        $user= User::findOrFail($id);
        $user->delete();
        return response()->json(null,204);

    }

    public function unactivate(Request $request, $id){
        $user= User::findOrFail($id);
        $user->active = 0;
        $user->save();
        return (new UserResource($user))->response()->setStatusCode(200);
    }

    public function activate(Request $request, $id){
        $user= User::findOrFail($id);
        $user->active = 1;
        $user->save();
        return (new UserResource($user))->response()->setStatusCode(200);
    }

    // public function updatePassword(Request $request, $id){
    //     $user= User::findOrFail($id);
    //     //if (Hash::check(string($user->oldPassword), $user->password)) {
    //     $user->password= Hash::make($user->newPassword);
    //     //}
    //     $user->save();
    //     return (new UserResource($user))->response()->setStatusCode(200);
    // }
    public function showUserWithEmail($email){
        return new UserResource(User::find($email));
    }
    
    public function filter(Request $request){
        $query=null;
        $query= User::where('id', '>',0);

        if($request->has('type')){
            $query=$query->where('type','=',$request->type);
        }

        if($request->has('name')){
            $query=$query->where('name','=',$request->name); 
        }

        if($request->has('email')){
            $query=  $query->where('email','=', $request->email);
        }

        if($request->has('active')){
            $query=  $query->where('active','=', $request->active);
        }


        return UserResource::collection($query->paginate(5));

    }


    

}
