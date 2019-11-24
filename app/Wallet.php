<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    //

    protected $fillable = ['email','balance'];

    protected $hidden = [];


    public function user()
    {
        return $this->belongsTo('App\User','id');
    }

    public function movement(){
        return $this->hasMany('App\Movement', 'wallet_id');
        //return $this->hasMany('App\Movement', 'transfer_wallet_id');
    }
}
