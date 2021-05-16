<?php

namespace App\Modules\Discount\Http\Controllers;

use App\Discount;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class DiscountController extends Controller
{
    public function discounts(){
        return view('modules.discounts.index')->with(['discounts'=>Discount::where('status',1)->get()]);
    }
    public function show($slug,Request $request){
        $discount=Discount::where('slug',$slug)->firstOrFail();
        return view('modules.discounts.show')->with(['discount'=>$discount]);
    }
}
