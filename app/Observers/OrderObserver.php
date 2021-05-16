<?php

namespace App\Observers;

use App\Http\Controllers\GlobalCardController;
use App\Order;
use App\OrderProduct;
use App\Product;

class OrderObserver
{
    /**
     * Handle the order "created" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function created(Order $order)
    {
        //
    }

    /**
     * Handle the order "updated" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        foreach (OrderProduct::where('order_id',$order->id)->get() as $orderProduct) {
            $product = Product::find($orderProduct->product_id);
            $cardController = new GlobalCardController();
            $product->count = $cardController->countProduct($orderProduct->product_id);
            $product->save();
        }
    }

    /**
     * Handle the order "deleted" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        foreach (OrderProduct::where('order_id',$order->id)->get() as $orderProduct) {
            $product = Product::find($orderProduct->product_id);
            $cardController = new GlobalCardController();
            $product->count = $cardController->countProduct($orderProduct->product_id);
            $product->save();
        }
    }

    /**
     * Handle the order "restored" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the order "force deleted" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
