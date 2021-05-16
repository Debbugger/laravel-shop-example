<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecificationValue extends Model
{
    protected $table='specification_value';
    protected $fillable = [
        'specification_id',
        'value_id',
        'category_id'
    ];
}
