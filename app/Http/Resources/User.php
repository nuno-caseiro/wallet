<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=> $this->id,
            'name'=> $this->name,
            'email' => $this->email,
            'type'=>$this->type,
            'active'=>$this->active,
            'photo' =>$this->photo  ? $this->photo : "",
            'nif'=>$this->nif,
            'balance_status'=>$this->wallet ? $this->wallet->balance : " - ",
        ];
        //return parent::toArray($request);
    }
}
