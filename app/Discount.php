<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mews\Purifier\Facades\Purifier;

class Discount extends Model
{
    public function setDescriptionAttribute($value)
    {
        $value=Purifier::clean($value);
        $this->attributes['description'] = json_encode($value);
    }
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = json_encode($value);
    }
    public function setShortDescriptionAttribute($value)
    {
        $this->attributes['short_description'] = json_encode($value);
    }
    public function setProductsAttribute($value){
        $this->attributes['products']=json_encode($value);
    }
    public function getProductsAttribute(){
        return json_decode($this->attributes['products']);
    }

    public function setMetaTitleAttribute($value)
    {
        $this->attributes['meta_title'] = json_encode($value);
    }

    public function setMetaDescriptionAttribute($value)
    {
        $this->attributes['meta_description'] = json_encode($value);
    }

    public function setMetaKeywordsAttribute($value)
    {
        $this->attributes['meta_keywords'] = json_encode($value);
    }
}
