<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    protected $fillable = [];

    protected $hidden = [];

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
