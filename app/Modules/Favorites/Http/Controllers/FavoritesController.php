<?php

namespace App\Modules\Favorites\Http\Controllers;

use App\Favorite;
use App\Http\Controllers\GlobalCardController;
use App\Product;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class FavoritesController extends Controller
{
    public function add(Request $request)
    {
        if (!Auth::check()) {
            return response(['status' => 0, 'message' => trans('alert.favorite-login-error')]);
        }
        $user = Auth::user();

        $favorite = Favorite::where(['user_id' => $user->id, 'product_id' => $request->input('id')])->first();
        $cardController = (new GlobalCardController());
        if ($request->input('count') < 0) {
            if (!$favorite) {
                return response(['status' => 0, 'message' => trans('alert.favorite-login-error'),'id'=>$request->input('id')]);
            }
            if (!$cardController->haveCountProduct($favorite->count + $request->input('count'), $request->input('id'))) {
                $favorite->count = $cardController->countProduct($request->input('id'));
                $favorite->save();
                if ($favorite->count < 0) {

                    return response(['status' => 1, 'message' => trans('alert.product-empty'), 'count' => $favorite->count, 'delete','id'=>$request->input('id')]);
                }


                return response(['status' => 1, 'message' => 'Всего доступно: ' . $favorite->count . ' товаров', 'count' => $favorite->count,'id'=>$request->input('id')]);
            }
            if ($favorite->count + $request->input('count') < 0) {
                $favorite->delete();

                return response(['status' => 0, 'message' => 'Даного товара больше нету в наличии', 'delete' => 1,'id'=>$request->input('id')]);
            }
            if ($favorite->count + $request->input('count')>0)
            $favorite->count = $favorite->count + $request->input('count');
            $favorite->save();
            return response(['status' => 1, 'message' => 'Изменения сохранены', 'count' => $favorite->count,'id'=>$request->input('id')]);
        }
        if ($favorite) {
            if (($request->input('update') == 1)&&($favorite->count>0)) {
                $favorite->delete();
                return response(['status' => 0, 'message' => trans('alert.favorite-remove-error'), 'count' => 0,'id'=>$request->input('id')]);
            }
            if (!$cardController->haveCountProduct($favorite->count + $request->input('count'), $request->input('id'))) {
                $favorite->count = $cardController->countProduct($request->input('id'));
                $favorite->save();
                $alert=str_replace('$count',$favorite->count,trans('alert.card-have'));
                return response(['status' => 0, 'message' => $alert, 'count' => $favorite->count,'id'=>$request->input('id')]);
            }
            $favorite->count = $favorite->count + $request->input('count');
            $favorite->save();

            return response(['status' => 1, 'message' => trans('alert.favorite-add'), 'count' => $favorite->count,'id'=>$request->input('id')]);
        }
        Favorite::create(['user_id' => $user->id, 'product_id' => $request->input('id'), 'count' => $request->input('count')]);

        return response(['status' => 1, 'message' => trans('alert.favorite-add'), 'count' => $request->input('count'),'id'=>$request->input('id')]);


    }


    public function delete(Request $request)
    {

        Favorite::where(['user_id' => Auth::user()->id, 'product_id' => $request->input('id')])->delete();

        return response(['status' => 1, 'message' => trans('alert.product-remove')]);
    }

    public function send(Request $request){
        $favorite=Favorite::findOrFail($request->id);
        if (!empty(Cookie::get('card'))) {
            $currentCookie = json_decode(Cookie::get('card'), true);
        } else {
            $currentCookie = [];
        }
        if (empty($currentCookie[$favorite->product_id])) {
            $currentCookie[$favorite->product_id] = 0;
        }
        else{
            unset($currentCookie[$favorite->product_id]);
             return response(['status' => 0, 'message' => trans('alert.card-remove'),'id'=>$favorite->product_id])->withCookie(Cookie::make('card', json_encode($currentCookie), 1440));
        }
        $currentCookie[$favorite->product_id]=$favorite->count;
        return response(['status' => 1, 'message' => trans('alert.card-add'),'id'=>$favorite->product_id])->withCookie(Cookie::make('card', json_encode($currentCookie), 1440));
    }

}
