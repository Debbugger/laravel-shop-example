<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductValue extends Model
{
    protected $table='product_value';
    protected $fillable = [
        'specification_id',
        'value_id',
        'product_id'
    ];
    public function product(){
        $this->hasOne('App\Product','id','product_id');
    }
    public function category(){
        $this->hasMany(SpecificationValue::class,'value_id','value_id');
    }
}
