<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table='order_product';
    protected $fillable = [
        'order_id',
        'product_id',
        'count',
        'cost'
    ];
    public function order()
    {
        return $this->hasOne('App\Order','id','order_id');
    }
    public function product()
    {
        return $this->hasOne('App\Product','id','product_id');
    }
    public function scopeCountProductOut($query,$value){
      return  $query->with('order')->where(['product_id'=>$value])->whereHas('order',function ($query){
          $query->where('status',1);
      })->sum('count');
    }
}
