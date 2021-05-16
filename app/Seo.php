<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    protected $table = 'seo';

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
