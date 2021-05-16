<?php

namespace App\Observers;

use App\Http\Controllers\GlobalCardController;
use App\Product;
use App\Stock;

class StockObserver
{
    /**
     * Handle the stock "created" event.
     *
     * @param  \App\Stock  $stock
     * @return void
     */
    public function created(Stock $stock)
    {
        $product = Product::find($stock->product_id);
        $cardController = new GlobalCardController();
        $product->count = $cardController->countProduct($stock->product_id);
        $product->save();
    }

    /**
     * Handle the stock "updated" event.
     *
     * @param  \App\Stock  $stock
     * @return void
     */
    public function updated(Stock $stock)
    {
        $product = Product::find($stock->product_id);
        $cardController = new GlobalCardController();
        $product->count = $cardController->countProduct($stock->product_id);
        $product->save();
    }

    /**
     * Handle the stock "deleted" event.
     *
     * @param  \App\Stock  $stock
     * @return void
     */
    public function deleted(Stock $stock)
    {
        $product = Product::find($stock->product_id);
        $cardController = new GlobalCardController();
        $product->count = $cardController->countProduct($stock->product_id);
        $product->save();
    }

    /**
     * Handle the stock "restored" event.
     *
     * @param  \App\Stock  $stock
     * @return void
     */
    public function restored(Stock $stock)
    {
        //
    }

    /**
     * Handle the stock "force deleted" event.
     *
     * @param  \App\Stock  $stock
     * @return void
     */
    public function forceDeleted(Stock $stock)
    {
        //
    }
}
