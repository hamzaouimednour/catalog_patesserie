<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductImgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_imgs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned()->nullable(false);
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('RESTRICT');
            $table->string('img')->nullable(false);
            $table->tinyInteger('thumb');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_imgs');
    }
}
