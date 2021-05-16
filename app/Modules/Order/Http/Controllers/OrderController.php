<?php

namespace App\Modules\Order\Http\Controllers;

use App\Http\Controllers\GlobalCardController;
use App\Order;
use App\OrderProduct;
use App\Product;
use App\Stock;
use App\Traits\SaveTrait;
use App\User;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;

class OrderController extends Controller
{
    public function register()
    {
        if (!empty(Cookie::get('card'))) {
            $currentCookie = json_decode(Cookie::get('card'), true);
        } else {
            return response(['status' => 0, 'message' => trans('alert.order-empty')]);
        }
        $cardController = new GlobalCardController();
        $status = $cardController->activeSend($currentCookie);
        Cache::lock('foo')->get(function () use ( $currentCookie, $status) {
            if ($status) {
                $user=Auth::user();
                $order = Order::create(['user_id' => $user->id, 'status' => 1,'count'=>0,'name'=>' ']);
                $sum = 0;
                $Allcount = 0;
                $first = 1;
                foreach ($currentCookie as $key => $count) {
                    $product=Product::findOrFail($key);
                    if ($first) {
                        $first = 0;
                        $order->name = $product->name;
                    }
                    OrderProduct::create(['count' => $count, 'order_id' => $order->id, 'product_id' => $key, 'cost' => $product->costFront * $count]);
                    $sum += $product->costFront * $count;
                    $Allcount += $count;
                }
                $order->sum = $sum;
                $order->count = $Allcount;
                $order->save();
            }
        });
        $cookie = Cookie::forget('card');
        if ($status) {
            return response(['status' => 1, 'message' => trans('alert.order-add'), 'redirect' => route('userHome')])->withCookie($cookie);
        } else {
            return response(['status' => 0, 'message' => trans('alert.order-fail'), 'redirect' => route('card')])->withCookie($cookie);
        }
    }


}
