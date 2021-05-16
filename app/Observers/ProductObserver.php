<?php

namespace App\Observers;

use App\Image;
use App\ImageProduct;
use App\Order;
use App\OrderProduct;
use App\Product;
use App\ProductValue;
use App\Stock;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductObserver
{
    /**
     * Handle the product "created" event.
     *
     * @param \App\Product $product
     * @return void
     */
    public function created(Product $product)
    {
        if (!empty($product->images_add)) {
            DB::transaction(function () use ($product) {

                foreach ($product->images_add as $image) {
                    $path = Storage::disk('public')->putFile('/images/product', $image);
                    $image = Image::create(['path' => $path]);
                    ImageProduct::create(['product_id' => $product->id, 'image_id' => $image->id]);
                }

            }, 1);
        }
    }

    /**
     * Handle the product "updated" event.
     *
     * @param \App\Product $product
     * @return void
     */
    public function updated(Product $product)
    {
        if (!empty($product->images_add)) {
            $images_add = ImageProduct::where('product_id', $product->id)->get();
            foreach ($images_add as $val) {
                $image = Image::find($val->image_id);
                $image->delete();
            }
            DB::transaction(function () use ($product) {
                ImageProduct::where('product_id', $product->id)->delete();
                foreach ($product->images_add as $image) {
                    $path = Storage::disk('public')->putFile('/images/product', $image);
                    $image = Image::create(['path' => $path]);
                    ImageProduct::create(['product_id' => $product->id, 'image_id' => $image->id]);
                }

            }, 1);
        }
    }

    /**
     * Handle the product "deleted" event.
     *
     * @param \App\Product $product
     * @return void
     */
    public function deleted(Product $product)
    {
        Storage::disk('public')->delete($product->image);
        $images_add =  ImageProduct::where('product_id', $product->id)->get();
        DB::transaction(function () use ($product, $images_add) {
            foreach ($images_add as $val) {
                $image = Image::find($val->image_id);
                Storage::disk('public')->delete($image->path);
                $image->delete();
            }
            ImageProduct::where('product_id', $product->id)->delete();
        });
        Stock::where('product_id',$product->id)->delete();
        OrderProduct::where('product_id',$product->id)->delete();
        ProductValue::where('product_id',$product->id)->delete();
    }

    /**
     * Handle the product "restored" event.
     *
     * @param \App\Product $product
     * @return void
     */
    public function restored(Product $product)
    {
        //
    }

    /**
     * Handle the product "force deleted" event.
     *
     * @param \App\Product $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        //
    }
}
