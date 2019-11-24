<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{



    protected $fillable = ['wallet_id','type','transfer','transfer_movement_id','transfer_wallet_id',
        'type_payment','category_id','iban','mb_entity_code','mb_payment_reference','description','source_description','date',
        'start_balance','end_balance','value'];
//
    protected $hidden = ['updated_at','created_at'];

    public $timestamps = false;


    public function wallet(){
        $this->belongsTo('App\Wallet');
    }

    public function category(){
        $this->belongsTo('App\Category');
    }

    public function movement(){
        $this->hasOne('App\Movement', 'transfer_movement_id', 'id');
    }

}
