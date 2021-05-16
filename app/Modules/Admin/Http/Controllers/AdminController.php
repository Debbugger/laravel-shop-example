<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Product;
use App\Stock;

class AdminController extends Controller
{
    public function __invoke()
    {
        $mounth = [
            '1'  => 'Январь',
            '2'  => 'Февраль',
            '3'  => 'Март',
            '4'  => 'Апрель',
            '5'  => 'Май',
            '6'  => 'Июнь',
            '7'  => 'Июль',
            '8'  => 'Август',
            '9'  => 'Сентябрь',
            '10' => 'Октябрь',
            '11' => 'Ноябрь',
            '12' => 'Декабрь',
        ];
        $all = [];
        $stocks = Stock::with('product')->orderBy('created_at', 'asc')->get();
        $count = 0;
        $have = 0;
        $send = 0;
        $countProduct = 0;
        foreach ($stocks as $stock) {
            if ($stock->type == 1) {
                $have += $stock->product->cost * $stock->count;

            }
            if ($stock->type == 2) {
                $send += $stock->product->cost * $stock->count;
                $count++;
            }
        }
        if ($count) {
            for ($i = intval($stocks->first()->created_at->format('m')); $i <= intval($stocks->last()->created_at->format('m')); $i++) {
                $all[$i] = $mounth[$i];
            }
            $costNoBuy = $have - $send;
            foreach (Product::all() as $elem) {
                $countProduct += $elem->count;
            }

            $days = array_values(Stock::graphMounth(date('m')));
            $colDays = count($days);

            return view('admin::dashboard')->with([
                'mounthes'     => $all,
                'currM'        => intval(date('m')),
                'days'         => json_encode($days),
                'colDays'      => $colDays,
                'costNoBuy'    => intval($costNoBuy),
                'send'         => intval($send),
                'countProduct' => $countProduct,
                'count'        => $count,
                'status'       => 1
            ]);

        }

        return view('admin::dashboard')->with(['message' => 'Статистика не доступна. Склад пуст', 'status' => 0]);
    }
}
