<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_components', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned()->nullable(false);
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('CASCADE');       
            $table->integer('component_id')->unsigned()->nullable(false);
            $table->foreign('component_id')
                  ->references('id')
                  ->on('components')
                  ->onDelete('RESTRICT');
            $table->boolean('price_by_size')->nullable(false); // true: price changed by product size. (follow extra table)
            $table->double('default_price', 10, 3)->nullable(false);
            $table->string('img', 200)->nullable();
            $table->tinyInteger('default')->nullable(false);
            $table->tinyInteger('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_components');
    }
}
