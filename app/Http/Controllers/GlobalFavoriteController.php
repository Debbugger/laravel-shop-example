<?php

namespace App\Http\Controllers;

use App\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GlobalFavoriteController extends Controller
{
    public function favorites(){
        return Favorite::where('user_id',Auth::id())->get()->toArray();
    }
}
