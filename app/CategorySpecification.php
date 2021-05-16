<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategorySpecification extends Model
{
 protected $table='category_specification';
    protected $fillable = [
        'specification_id',
        'category_id'
    ];
    public function specification(){
        return $this->hasOne('App\Specification','id','specification_id');
    }
}
