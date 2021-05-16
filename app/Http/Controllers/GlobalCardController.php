<?php

namespace App\Http\Controllers;

use App\OrderProduct;
use App\Product;
use App\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class GlobalCardController extends Controller
{
    public function removeElemCookie($currentCookie, $id)
    {
        if (count($currentCookie) > 1) {
            unset($currentCookie[$id]);
            $cookie = Cookie::make('card', json_encode($currentCookie), 1440);
        } else {
            $cookie = Cookie::forget('card');
        }

        return $cookie;
    }
    public function getCookie(){
        if (!empty(Cookie::get('card'))) {
            $currentCookie = json_decode(Cookie::get('card'), true);
        } else {
            $currentCookie = [];
        }
        return $currentCookie;
    }

    public function activeSend($currentCookie)
    {
        foreach ($currentCookie as $product_id => $count) {
            if (!$this->haveCountProduct($count, $product_id)) {
                return 0;
            }
        }

        return 1;
    }

    public function haveCountProduct($count, $product_id)
    {
        if (Product::find($product_id)->whereHas('category', function ($q) {
                $q->where('status', 1);
            })->count() <= 0) {
            return 0;
        }

        $col = Product::find($product_id)->count;
        if ($col >= $count) {
            return 1;
        }

        return 0;

    }

    public function countProduct($product_id)
    {
        if (Product::find($product_id)->whereHas('category', function ($q) {
                $q->where('status', 1);
            })->count() <= 0) {
            return 0;
        }

        return Stock::countProductLeft($product_id)-OrderProduct::countProductOut($product_id);
    }

    public function updateCookie($currentCookie, $id)
    {
        if ($currentCookie[$id] > Product::find($id)->count) {
            $currentCookie[$id] = Product::find($id)->count;
        }
        if ($currentCookie[$id] <= 0) {
            return $this->removeElemCookie($currentCookie, $id);
        }

        return Cookie::make('card', json_encode($currentCookie), 1440);
    }

}
