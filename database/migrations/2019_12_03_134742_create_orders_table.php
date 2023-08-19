<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_num')->nullable();
            $table->integer('customer_id')->unsigned()->nullable(false);
            $table->foreign('customer_id')
                  ->references('id')
                  ->on('customers')
                  ->onDelete('RESTRICT');
            $table->integer('company_id')->unsigned()->nullable(false);
            $table->foreign('company_id')
                  ->references('id')
                  ->on('company')
                  ->onDelete('CASCADE');
            $table->boolean('special')->nullable()->default(false);
            $table->longText('product_components')->nullable();
            $table->dateTime('delivery_date')->nullable();
            $table->enum('delivery_mode', ['S', 'C'])->nullable()->default('C')->comment('S : delivery by Society, C : Delivery by Customer');
            $table->enum('delivery_point', ['S', 'A'])->nullable()->default('S')->comment('S : Same Sales point, A : Another Sales point');
            $table->double('acompte', 10, 3)->nullable();
            $table->enum('acompte_type', ['C', 'E', 'T'])->nullable()->comment('C: Cheque, E: Espèces , T: Télépaiement');
            $table->double('cautionnement', 10, 3)->nullable(true);
            $table->double('total', 10, 3)->nullable(false);
            $table->text('instructions')->nullable();
            $table->enum('status', ['P', 'M', 'R', 'D', 'L', 'C'])->nullable(false)->default('P')->comment('P: pending, M: making, R: ready, D: delivery, L: delivred, C: cancled');
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
        Schema::dropIfExists('orders');
    }
}
