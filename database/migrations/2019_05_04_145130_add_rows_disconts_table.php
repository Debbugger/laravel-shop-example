<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRowsDiscontsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('disconts', function (Blueprint $table) {
            $table->string('category_id')->nullable()->after('slug');
            $table->string('product_id')->nullable()->after('category_id');
            $table->text('discont')->after('product_id');
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
            $table->dropColumn('category_id');
            $table->dropColumn('product_id');
            $table->dropColumn('discont');
        });
    }
}
