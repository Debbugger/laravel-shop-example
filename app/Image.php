<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
public $timestamps=true;
    protected $fillable = [
        'path'
    ];

}
