<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModuleGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('module_id')->unsigned()->nullable(false);
            $table->foreign('module_id')
                    ->references('id')
                    ->on('modules')
                    ->onDelete('RESTRICT');
            $table->integer('group_id')->unsigned()->nullable(false);
            $table->foreign('group_id')
                  ->references('id')
                  ->on('group_permissions')
                  ->onDelete('CASCADE');
            $table->string('actions')->nullable(true);
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
