<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductComponentPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_component_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_component_id')->unsigned()->nullable(false);
            $table->foreign('product_component_id')
                  ->references('id')
                  ->on('product_components')
                  ->onDelete('cascade');
            $table->integer('size_id')->unsigned()->nullable(false);
            $table->foreign('size_id')
                  ->references('id')
                  ->on('sizes')
                  ->onDelete('RESTRICT');
            $table->double('price', 10, 3)->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_component_prices');
    }
}
