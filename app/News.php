<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mews\Purifier\Facades\Purifier;

class News extends Model
{
    protected $table="news";
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = json_encode($value);
    }
    public function setFullTextAttribute($value)
    {
        $value=Purifier::clean($value);
        $this->attributes['full_text'] = json_encode($value);
    }
    public function setShortTextAttribute($value)
    {
        $value=Purifier::clean($value);
        $this->attributes['short_text'] = json_encode($value);
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

    public function setImagesAttribute($image)
    {
        if ($image) {
            if (isset($this->attributes['images']) && ($images = $this->attributes['images'])) {
                $image = array_merge(json_decode($images, true), $image);
            }
            $this->attributes['images'] = json_encode($image);
        }
    }


    public function getImagesAttribute($images)
    {
        return $images ? json_decode($images, true) : [];
    }

    public function setDeleteImageAttribute($image)
    {
        $img = array_search($image, $this->images);
        $file = public_path($this->images[$img]);
        if (file_exists($file) && is_file($file)) {
            unlink($file);
        }
        $images = json_decode($this->attributes['images'], true);
        unset($images[$img]);
        $this->attributes['images'] = empty($images) ? null : json_encode($images);
    }
}
