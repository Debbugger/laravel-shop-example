<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageProduct extends Model
{
    protected $table="image_product";
    protected $fillable = [
        'product_id', 'image_id'
    ];
}
