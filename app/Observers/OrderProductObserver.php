<?php

namespace App\Observers;

use App\Http\Controllers\GlobalCardController;
use App\OrderProduct;
use App\Product;

class OrderProductObserver
{
    /**
     * Handle the order product "created" event.
     *
     * @param  \App\OrderProduct  $orderProduct
     * @return void
     */
    public function created(OrderProduct $orderProduct)
    {
        $product = Product::find($orderProduct->product_id);
        $cardController = new GlobalCardController();
        $product->count = $cardController->countProduct($orderProduct->product_id);
        $product->save();
    }

    /**
     * Handle the order product "updated" event.
     *
     * @param  \App\OrderProduct  $orderProduct
     * @return void
     */
    public function updated(OrderProduct $orderProduct)
    {
        $product = Product::find($orderProduct->product_id);
        $cardController = new GlobalCardController();
        $product->count = $cardController->countProduct($orderProduct->product_id);
        $product->save();
    }

    /**
     * Handle the order product "deleted" event.
     *
     * @param  \App\OrderProduct  $orderProduct
     * @return void
     */
    public function deleted(OrderProduct $orderProduct)
    {
        $product = Product::find($orderProduct->product_id);
        $cardController = new GlobalCardController();
        $product->count = $cardController->countProduct($orderProduct->product_id);
        $product->save();
    }

    /**
     * Handle the order product "restored" event.
     *
     * @param  \App\OrderProduct  $orderProduct
     * @return void
     */
    public function restored(OrderProduct $orderProduct)
    {
        //
    }

    /**
     * Handle the order product "force deleted" event.
     *
     * @param  \App\OrderProduct  $orderProduct
     * @return void
     */
    public function forceDeleted(OrderProduct $orderProduct)
    {
        //
    }
}
