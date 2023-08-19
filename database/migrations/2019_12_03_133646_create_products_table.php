<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ref', 100)->nullable();
            $table->integer('company_id')->unsigned()->nullable(false);
            $table->foreign('company_id')
                  ->references('id')
                  ->on('company')
                  ->onDelete('RESTRICT');
            $table->string('name')->nullable();
            $table->boolean('price_by_size')->default(false); // F: False (product have only one price) T: True (product have many prices by size)
            $table->double('default_price', 10, 3)->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
