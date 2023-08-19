<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanySectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_sections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned()->nullable(false);
            $table->foreign('company_id')
                  ->references('id')
                  ->on('company')
                  ->onDelete('RESTRICT');
            $table->string('name')->nullable(false);
            $table->string('ville', 100)->nullable();
            $table->enum('section', ['S', 'F'])->nullable(false)->comment('S: Sales Point, F: Factory');
            $table->tinyInteger('status')->unsigned()->nullable(false)->default(1)->comment('1: Enabled, 0: Disabled');
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
        Schema::dropIfExists('company_sections');
    }
}
