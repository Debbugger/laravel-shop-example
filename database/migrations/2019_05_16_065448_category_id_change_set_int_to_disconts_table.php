<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CategoryIdChangeSetIntToDiscontsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('disconts', function (Blueprint $table) {
            $table->dropColumn('category_id');
            $table->dropColumn('product_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('disconts', function (Blueprint $table) {
            $table->bigInteger('category_id');
            $table->bigInteger('product_id');
        });
    }
}
