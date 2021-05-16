<?php

namespace App\Modules\Home\Http\Controllers;

use App\Advantage;
use App\Category;
use App\Discount;
use App\Http\Controllers\Controller;
use App\Partner;
use App\Review;
use App\Slider;

class HomeController extends Controller
{
    public function __invoke()
    {
        $categoriesDay=Category::with('products')->where('status',1)->whereHas('products',function ($query){
            $query->where('type',1)->where('count','>',0);
        })->get();
        $reviews=Review::with('user')->where('status',1)->orderBy('id','desc')->limit(4)->get();
        $advansed=Advantage::where('status',1)->get();
        $sliders=Slider::where('status',1)->get();
        return view('modules.home.home')->with(['categories'=>Category::where('status',1)->whereNull('parent_id')->get(),'categoriesDay'=>$categoriesDay,'advansed'=>$advansed,'sliders'=>$sliders,'reviews'=>$reviews]);
    }
}
