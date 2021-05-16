<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    public function values(){
        return $this->belongsToMany('App\Value');
    }

    public function setNameAttribute($value){
        $this->attributes['name']=json_encode($value);
    }
    public function categorySpecification(){
        $this->hasMany(CategorySpecification::class,'specification_id','id');
    }
    public function categories(){
        return $this->belongsToMany(Category::class);
    }
}
