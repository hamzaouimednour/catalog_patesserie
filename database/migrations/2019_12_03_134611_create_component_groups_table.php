<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponentGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('component_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned()->nullable(false);
            $table->foreign('company_id')
                  ->references('id')
                  ->on('company')
                  ->onDelete('CASCADE');
            $table->string('name')->nullable(false);
            $table->text('description')->nullable();
            $table->enum('usage', ['M', 'S'])->comment('M: multiple, S: single');
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
        Schema::dropIfExists('component_groups');
    }
}
