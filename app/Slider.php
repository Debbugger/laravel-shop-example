<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = json_encode($value);
    }
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = json_encode($value);
    }
}
