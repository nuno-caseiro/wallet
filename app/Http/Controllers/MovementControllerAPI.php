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
                $data['iban'] = null; 
                $data['mb_entity_code']= null;
                $data['mb_payment_reference']=null;  
            }
        }
        

        if($data['type'] === 'i'){

            if($data['type_payment'] === 'c'){
                $data['iban']=null;   
            }

        }
        
        

        //TODO validacoes e deve ser preciso fazer mais alguma coisa
        if(($data['type']) == 'i'){
            $request->validate([
                'wallet_id'=>'required',
                'start_balance'=>'required',
                'category_id'=> 'nullable',
                'description' => 'nullable|string|max:200',
                'source_description' => 'nullable|string|max:200',
                'value'=> 'nullable | max:4',
                'type_payment'=> 'required|in:bt,c',
                
            ]);


                if(($data['type_payment'])=='bt'){

                    $request->validate([
                        'iban'=> 'required | regex:/^[a-zA-Z]{2}[0-9]{2}[0-9]{4}[0-9]{4}[0-9]{11}[0-9]{2}$/',
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
                'value'=>'required | max:4',
                'category_id'=> 'nullable', ///TODO: colcolar in: groceries,restaurant ????
                'description' => 'nullable|string|max:200',
            ]);
            if(($data['transfer']) === true){
                $request->validate([
                    //'transfer_movement_id' => 'required', TODO : ESTE VALOR ESTA A NULL 
                    'transfer_wallet_id' => 'required',

                ]);
            }
             else{
                
                $request->validate([
                    'type_payment'=> 'required|in:mb,bt',

                ]);
                if(($data['type_payment']) == 'mb'){
                    $request->validate([
                        'mb_entity_code'=> 'required | regex:/^[0-9]{5}$/g',
                        'mb_payment_reference'=> 'required | regex:/^[0-9]{9}$/g',

                ]);
                }
                if(($data['type_payment']) == 'bt'){
                    $request->validate([
                        'iban'=> 'required | regex:/^[a-zA-Z]{2}[0-9]{2}[0-9]{4}[0-9]{4}[0-9]{11}[0-9]{2}$/g',
                    ]);
                }
            }
        }
        

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
