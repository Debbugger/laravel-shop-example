<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Value extends Model
{
    public function setValueAttribute($value){
        $this->attributes['value']=json_encode($value);
    }
    public function category(){
       return $this->hasOne(SpecificationValue::class,'value_id','id');
    }
}
