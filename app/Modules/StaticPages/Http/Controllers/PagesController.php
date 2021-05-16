<?php

namespace App\Modules\StaticPages\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function about(){
        return view('modules.staticPages.about');
    }
}
