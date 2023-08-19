<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductComponentGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_component_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned()->nullable(false);
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('RESTRICT');            
            $table->integer('component_id')->unsigned()->nullable(false);
            $table->foreign('component_id')
                  ->references('id')
                  ->on('components')
                  ->onDelete('RESTRICT');            
            $table->integer('component_group_id')->unsigned()->nullable(false);
            $table->foreign('component_group_id')
                  ->references('id')
                  ->on('component_groups')
                  ->onDelete('RESTRICT');
            $table->tinyInteger('status')->default(1);
            $table->enum('usage', ['O', 'F'])->default('O')->comment('O: obligatoire, F: facultative');
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
        Schema::dropIfExists('product_component_groups');
    }
}
