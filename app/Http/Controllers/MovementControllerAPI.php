<?php

namespace App\Http\Controllers;

use App\Support\CollectionHelper;
use App\Wallet;
use Carbon\Carbon;
use DateTime;
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
        $movement= Movement::find($id);
        if(auth()->guard('api')->user()->id==$movement->wallet_id||auth()->guard('api')->user()->id==$movement->transfer_wallet_id ) {

            return new MovementResource($movement);
        }
    }

    public function showMovementsOfWallet($wallet_id){
        if(auth()->guard('api')->user()->id==$wallet_id){

        return (MovementResource::collection(Movement::where('wallet_id',$wallet_id)->orderBy('date', 'desc')->paginate(5)))->response()->setStatusCode(200);
        }
    }

    public function filter(Request $request){
            $query=null;

        $query= Movement::where('id', '>',0);

       if($request->has('id')){
            $query=$query->where('id','=',$request->id);
        }

        if($request->has('wallet_id')){
            $query=$query->where('wallet_id','=',$request->wallet_id);
        }

        if($request->has('transfer_wallet_id')){
            $query=$query->where('transfer_wallet_id','=',$request->transfer_wallet_id);
        }

        if($request->has('type')){
            $query=  $query->where('type','=', $request->type);
        }

        if($request->has('date1')){
            $query=  $query->where('date','>=', Carbon::parse($request->date1));
        }

        if($request->has('date2')){
            $query=  $query->where('date','<=', Carbon::parse($request->date2));
        }

        if($request->has('category_id')){
            $query=  $query->where('category_id','=', $request->category_id);
        }

        if($request-> has('type_payment')){
            $query=  $query->where('type_payment','=', $request->type_payment);

        }
        if($request-> has('transfer')){
            $query=  $query->where('transfer','=', $request->transfer);

        }


        /*$total = $query->count();
        $pageSize = 20;
        //falta dos transfer-email
        return   CollectionHelper::paginate($query,$total,$pageSize);*/

        return MovementResource::collection($query->orderBy('date','desc')->paginate(5));

    }



    public function store(Request $request){

        $data = $request;
        if($data['type'] === 'e'){
            if($data['transfer'] === true){
                $data['iban']=null;
                $data['mb_entity_code']=null;
                $data['mb_payment_reference']=null;
            }else{
                $data['wallet_email_source']=null;
                $data['transfer_wallet_id']=null;
                $data['source_description']=null;
            }

            if($data['type_payment'] === 'mb'){
                $data['iban']=null;
            }
            if($data['type_payment'] === 'bt'){
                $data['mb_entity_code']= null;
                $data['mb_payment_reference']=null;
            }
        }


        if($data['type'] === 'i'){

            if($data['type_payment'] === 'c'){
                $data['iban']=null;
            }

        }



        if(($data['type']) == 'i'){
            $request->validate([
                'wallet_id'=>'required|numeric',
                'start_balance'=>'required',
                'category_id'=> 'nullable|numeric ',
                'description' => 'nullable|string|max:200',
                'source_description' => 'nullable|string|max:200',
                'value'=> 'required|numeric|max:5000|min:0',

            ]);

            if(($data['transfer'])==false){
                $request->validate([
                    'type_payment'=> 'required|in:bt,c',
                ]);
            }

                if(($data['type_payment']) =='bt'){

                    $request->validate([
                        'iban'=> 'required|regex:/^[a-zA-Z]{2}[0-9]{2}[0-9]{4}[0-9]{4}[0-9]{11}[0-9]{2}$/',
                    ]);

                }else{
                    if(($data['type_payment'])=='c'){
                        $request->validate([
                            'iban'=> 'nullable',
                        ]);
                }
            }
        }

        if(($data['type']) == 'e'){
            $request->validate([
                'value'=> 'required|numeric|max:5000|min:0',
                'category_id'=> 'nullable|numeric',
                'description' => 'nullable|string|max:200',
            ]);

            if(($data['transfer']) == true){
                $request->validate([
                    'transfer_wallet_id' => 'required',

                ]);
            }else{

                $request->validate([
                    'type_payment'=> 'required|in:mb,bt',

                ]);


                if(($data['type_payment']) === 'mb'){
                    $request->validate([
                        'mb_entity_code'=> 'required|regex:/^[0-9]{5}$/',
                        'mb_payment_reference'=> 'required|regex:/^[0-9]{9}$/',

                    ]);
                }

                if(($data['type_payment']) === 'bt'){
                    $request->validate([
                        'iban' => 'required|regex:/^[a-zA-Z]{2}[0-9]{2}[0-9]{4}[0-9]{4}[0-9]{11}[0-9]{2}$/',
                    ]);
                }
            }
        }


        $wallet= Wallet::findOrFail($request->wallet_id);
        if($wallet->balance-$request->value<0 && $data['type']=='e'){
            return response()->json("You dont have money",400);

        }else{


            $now= new DateTime();
            $movement= new Movement();
            $movement->fill($request->all());
            $movement->date=$now;
            $movement->save();

            return response()->json(new MovementResource($movement),201);
        }
    }

    public function update(Request $request, $id){
        $movement= Movement::findOrFail($id);
        if(auth()->guard('api')->user()->id==$movement->wallet_id || auth()->guard('api')->user()->id==$movement->transfer_wallet_id){
        $movement->fill($request->all());
        $movement->date=Carbon::parse($request->date['date']);
        $movement->save();
        return new MovementResource($movement);
        }
    }



    public function updateEdit(Request $request, $id){

        $request->validate([
                'category_id'=> 'nullable | numeric',
                'source_description' => 'nullable|string|max:200',
         ]);


        $movement= Movement::findOrFail($id);
        $movement->update($request->all());
        return new MovementResource($movement);
    }


}
