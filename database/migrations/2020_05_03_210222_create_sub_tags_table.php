<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tag_id')->unsigned()->nullable(false);
            $table->foreign('tag_id')
                    ->references('id')
                    ->on('tags')
                    ->onDelete('CASCADE');
            $table->string('name', 200)->nullable(false);
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
        //
    }
}
