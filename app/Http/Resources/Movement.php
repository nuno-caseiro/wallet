<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Wallet as WalletResource;
class Movement extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // $movements = select('*')->
        // order_by('date','desc')->
        // get();
        //TODO retficar julgo que alguns estao mal
        return ['id'=>$this->id,
            //acho que é $this->wallet->id
            'wallet_id'=> $this->wallet_id,
            'wallet_email'=>$this->wallet->email,
            //'wallet'=>$this->wallet,
            //'wallet'=>new WalletResource($this->wallet),
            'type'=>$this->type,
            'transfer'=>$this->transfer,
            'transfer_movement_id'=>$this->transfer_movement_id,
            'transfer_wallet_id'=>$this->transfer_wallet_id,
            'type_payment'=>$this->type_payment,
            'category_id'=>$this->category_id,
            'iban'=>$this->iban,
            'mb_entity_code'=>$this->mb_entity_code,
            'mb_payment_reference'=>$this->mb_payment_reference,
            'description'=>$this->description,
            'source_description'=>$this->source_description,
            'date'=>$this->date,
            'start_balance'=>$this->start_balance,
            'end_balance'=>$this->end_balance,
            'value'=>$this->value,
//$this->when(! is_null($this->details), $this->details),
            'category_name'=> $this->category ? $this->category->name : "-",
            // 'user_photo'=>$this->transfer_wallet_id->wallet->user->photo ?: null,
            // 'movements' => $movements,

            ];
    }
}
