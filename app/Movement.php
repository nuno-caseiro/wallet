<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    protected $fillable = [];

    protected $hidden = [];

    public function Wallet(){
        $this->belongsTo(Wallet::class);
    }
    
}
