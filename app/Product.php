<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Mews\Purifier\Facades\Purifier;

class Product extends Model
{
    public $images_add;


    public function scopeInStockAttribute($value)
    {
        $col = Stock::countProductLeft($this->attributes['id']) - OrderProduct::countProductOut($this->attributes['id']);
        if ($col) {
            $this->attributes['status'] = 0;
        }
        if (($this->attributes['status'] = 0) || ($col < $value)) {
            return 0;
        }

        return 1;
    }

    public function setImageAttribute($value)
    {
        if (!empty($this->attributes['image'])) {
            Storage::disk('public')->delete($this->attributes['image']);
        }
        $this->attributes['image'] = $value;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = json_encode($value);
    }

    public function getTypeAttribute()
    {
        if ($this->attributes['type'] == null) {
            return 0;
        } else {
            return $this->attributes['type'];
        }
    }

    public function setDescriptionAttribute($value)
    {
        $value = Purifier::clean($value);
        $this->attributes['description'] = json_encode($value);
    }

    public function setImagesAttribute($value)
    {
        $this->images_add = $value;
        if (!empty($this->attributes['id'])) {
            DB::transaction(function () use ($value) {
                foreach ($value as $image) {
                    $path = Storage::disk('public')->putFile('/images/product', $image);
                    $image = Image::create(['path' => $path]);
                    ImageProduct::create(['product_id' => $this->id, 'image_id' => $image->id]);
                }
            }, 1);
            $this->images_add = null;
        }
    }

    public function images()
    {
        return $this->belongsToMany('App\Image');
    }

    public function values()
    {
        return $this->hasMany(ProductValue::class, 'product_id', 'id');

    }

    public function getCostAttribute()
    {
        $attributeStart = Carbon::parse($this->attributes['start_date']);
        $attributeEnd = Carbon::parse($this->attributes['end_date']);
        if (($attributeStart->lessThan(date('Y-m-d'))) && ($attributeEnd->greaterThan(date('Y-m-d')))) {
            if ($this->attributes['type_discont'] == 1) {
                return intval($this->attributes['discont']);
            }
            if ($this->attributes['type_discont'] == 2) {
                return intval($this->attributes['cost'] - ($this->attributes['cost'] * $this->attributes['discont'] / 100));
            }
        }

        return intval($this->attributes['cost']);
    }

    public function getCostToAttribute()
    {
        $attributeStart = Carbon::parse($this->attributes['start_date']);
        $attributeEnd = Carbon::parse($this->attributes['end_date']);
        if (($attributeStart->lessThan(date('Y-m-d'))) && ($attributeEnd->greaterThan(date('Y-m-d')))) {
            if ($this->attributes['type_discont'] == 1) {
                return 0;
            }
            if ($this->attributes['type_discont'] == 2) {
                if (intval($this->attributes['cost_to']) > 0) {
                    return intval($this->attributes['cost_to'] - ($this->attributes['cost_to'] * $this->attributes['discont'] / 100));
                }

                return 0;
            }
        }

        return intval($this->attributes['cost_to']);
    }

    public function getCostFrontAttribute()
    {
        if ($this->costTo != 0) {
            return intval(($this->cost + $this->costTo) / 2);
        } else {
            return $this->cost;
        }
    }

    public function getCurrentCostAttribute()
    {
        return intval($this->attributes['cost']);
    }

    public function getCurrentCostToAttribute()
    {

        return intval($this->attributes['cost_to']);
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
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
