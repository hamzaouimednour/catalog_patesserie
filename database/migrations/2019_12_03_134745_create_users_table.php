<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('username')->nullable(false)->unique();
            $table->string('email')->nullable();
            $table->integer('phone')->unsigned()->unique();
            $table->string('password');
            $table->tinyInteger('status')->unsigned()->nullable(false)->default(1)->comment('1: Active, 0: Blocked');
            $table->tinyInteger('is_admin')->unsigned()->nullable(false)->default(0)->comment('1: true, 0: false');
            $table->datetime('last_login')->nullable();
            $table->rememberToken();
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
