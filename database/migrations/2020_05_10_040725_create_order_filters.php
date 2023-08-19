<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderFilters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_filters', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned()->nullable(false);
            $table->foreign('order_id')
                    ->references('id')
                    ->on('orders')
                    ->onDelete('CASCADE');
            $table->integer('company_section_id')->unsigned()->nullable(false);
            $table->foreign('company_section_id')
                    ->references('id')
                    ->on('company_users')
                    ->onDelete('CASCADE');
            $table->longText('tags')->nullable();
            $table->longText('sub_tags')->nullable();
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
        //
    }
}
