<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    //

    protected $fillable = ['id','email','balance'];

    protected $hidden = [];

    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo('App\User','id');
    }

    public function movement(){
        return $this->hasMany('App\Movement', 'id');

    }


}
