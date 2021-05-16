<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Advantage extends Model
{

    public function setImageAttribute($value)
    {
        if (!empty($this->attributes['image'])) {
            if ($this->attributes['image'] != null) {
                Storage::disk('public')->delete($this->attributes['image']);
            }
        }
        $this->attributes['image'] = $value;
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = json_encode($value);
    }

}
