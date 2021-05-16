<?php

namespace App\Modules\News\Http\Controllers;

use App\News;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    public function index(){
        $articles=News::all();
        return view('modules.news.index')->with('articles',$articles);
    }
    public function show($slug){
        $item=News::where('slug',$slug)->first();
        return view('modules.news.show')->with('item',$item);
    }
}
