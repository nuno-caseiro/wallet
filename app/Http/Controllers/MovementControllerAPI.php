<?php

namespace App\Http\Controllers;

use App\Support\CollectionHelper;
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

    public function filter(Request $request){
            $query=null;

        $query= Movement::where('id', '>',0);

       if($request->has('id')){
            $query=$query->where('id','=',$request->id); //todo paginate
        }

        if($request->has('wallet_id')){
            $query=$query->where('wallet_id','=',$request->wallet_id); //todo paginate
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
        //TODO validacoes e deve ser preciso fazer mais alguma coisa
  /*      $data = $request->all();
        if(($data['type']) == 'i'){
                if(($data['type_payment'])=='mb'){

                    $request->validate([
                        'category_id'=> 'nullable',
                        'iban'=> 'required | regex:/^[a-zA-Z]{2}[0-9]{2}[0-9]{4}[0-9]{4}[0-9]{11}[0-9]{2}$/g',
                        'description' => 'nullable',
                        'source_description' => 'nullable',
                        'value'=> 'nullable',
                    ]);

                }else{
                    if(($data['type_payment'])=='c'){
                    $request->validate([
                        'category_id'=> 'nullable',
                        'iban'=> 'nullable',
                        'description' => 'nullable',
                        'source_description' => 'nullable',
                        'value'=> 'nullable',
                    ]);
                }
            }
        }

        if(($data['type']) == 'e'){
            if(($data['transfer']) === true){
                $request->validate([
                    'transfer_movement_id' => 'required',
                    'transfer_wallet_id' => 'required',
                    'value'=>'required | max:4',
                    'type_payment' => 'nullable',
                    'category_id'=> 'nullable',
                    'mb_entity_code'=> 'nullable',
                    'mb_payment_reference'=> 'nullable',
                    'description' => 'nullable | max:50',

                ]);
            }else{
                if(($data['type_payment']) == 'mb'){
                    $request->validate([
                        'category_id'=> 'nullable',
                        'transfer_movement_id' => 'nullable',
                        'type_payment' => 'required',
                        'mb_entity_code'=> 'required | regex:/^[0-9]{5}$/g',
                        'mb_payment_reference'=> 'required | regex:/^[0-9]{9}$/g',
                        'description' => 'nullable | max:50',
                        'iban'=>'nullable',

                    ]);
                }elseif(($data['type_payment']) == 'bt'){
                    $request->validate([
                        'category_id'=> 'nullable',
                        'transfer_movement_id' => 'nullable',
                        'type_payment' => 'required',
                        'mb_entity_code'=> 'nullable',
                        'mb_payment_reference'=> 'nullable',
                        'description' => 'nullable | max:50',
                        'iban'=> 'required | regex:/^[a-zA-Z]{2}[0-9]{2}[0-9]{4}[0-9]{4}[0-9]{11}[0-9]{2}$/g',
                    ]);
                }
            }
        }*/

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

    public function updateEdit(Request $request, $id){
        //TODO validacoes
        $movement= Movement::findOrFail($id);
        $movement->update($request->all());
        return new MovementResource($movement);
    }


}
