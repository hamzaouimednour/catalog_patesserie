<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSizePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_size_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned()->nullable(false);
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('CASCADE');       
            $table->integer('size_id')->unsigned()->nullable(false);
            $table->foreign('size_id')
                  ->references('id')
                  ->on('sizes')
                  ->onDelete('RESTRICT');
            $table->double('price', 10, 3)->nullable(false);
            $table->boolean('default')->nullable(false)->default(false);
            $table->tinyInteger('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_size_prices');
    }
}
