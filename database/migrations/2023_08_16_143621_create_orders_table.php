<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->integer('id')->unsigned()->autoIncrement();
            $table->string('order_id')->unique();
            $table->string('customer_name');
            $table->integer('process_id');
            $table->enum('order_status', ['ORDERED', 'PROCESSING', 'SUBMITTED' , 'FAILED'])->default('ORDERED');
            $table->float('order_value')->nullable();
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
