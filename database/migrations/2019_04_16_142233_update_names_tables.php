<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateNamesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::rename('category', 'categories');
        Schema::rename('product', 'products');
        Schema::rename('image_products', 'image_product');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::rename('categories', 'category');
        Schema::rename('products', 'product');
        Schema::rename('image_product', 'image_products');
    }
}
