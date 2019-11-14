<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //

    public function movement(){
        return $this->hasMany('App\Movement', 'category_id');
    }
}
