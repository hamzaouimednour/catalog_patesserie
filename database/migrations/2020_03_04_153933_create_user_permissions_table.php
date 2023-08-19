<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id')->unsigned()->nullable(false);
            $table->foreign('group_id')
                    ->references('id')
                    ->on('group_permissions')
                    ->onDelete('RESTRICT');
            $table->integer('user_id')->unsigned()->nullable(false);
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('CASCADE');
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
