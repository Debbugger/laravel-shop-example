<?php

namespace App;

use Cocur\Slugify\Slugify;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Category extends Model
{
    // protected $table = "category";
    public $specifications_add;

    public $defaultCategoryImage = 'images/default/default_category.png';

    public function getImageAttribute()
    {
        return $this->attributes['image'] ?? $this->defaultCategoryImage;
    }


    public function setImageAttribute($value)
    {
        if (!empty($this->attributes['image'])) {
            if ($this->attributes['image'] != null) {
                Storage::disk('public')->delete($this->attributes['image']);
            }
        }
        $this->attributes['image'] = $value;
    }

    public function specifications()
    {
        return $this->belongsToMany('App\Specification');
    }

    public function products()
    {

        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function setNameAttribute($value)
    {
        if (empty($this->attributes['slug'])) {
            $slug = new Slugify();
            $col = Category::where('slug' ,'like', '%'.$slug->slugify(parseMultiLanguageString($value ?? null, config('app.adminLanguage'))).'%')->count();
            if ($col > 0) {
                $str = parseMultiLanguageString($value ?? null, config('app.adminLanguage')).$col;
            } else {
                $str = parseMultiLanguageString($value ?? null, config('app.adminLanguage'));
            }
            $this->attributes['slug'] = $slug->slugify($str);
        }
        $this->attributes['name'] = json_encode($value);
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = json_encode($value);
    }

    public function setSpecificationsAttribute($value)
    {
        $this->specifications_add = $value;
        if (!empty($this->id)) {
            DB::transaction(function () use ($value) {
                foreach ($this->specifications_add as $val) {
                    CategorySpecification::create(['category_id' => $this->id, 'specification_id' => $val]);
                }
            }, 1);
        }

        return $value;
    }

    public function getShortHameAttribute()
    {
        if (strlen(parseMultiLanguageString($item->description ?? null, app()->getLocale())) > 23) {
            return substr(parseMultiLanguageString($this->attributes['name'] ?? null, LaravelLocalization::getCurrentLocale()), 0, 23) . '...';
        } else {
            return parseMultiLanguageString($this->attributes['name'] ?? null, LaravelLocalization::getCurrentLocale());
        }
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

    public function getParentIdAttribute()
    {
        if ($this->attributes['parent_id'] == null) {
            return 0;
        }

        return $this->attributes['parent_id'];
    }

    public function setParentIdAttribute($value)
    {
        if ($value == 0) {
            $this->attributes['parent_id'] = null;
        } else {
            $this->attributes['parent_id'] = $value;
        }
    }

}
