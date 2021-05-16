<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'count',
    ];
    public function product(){
        return $this->hasOne('App\Product','id','product_id');
    }

}
