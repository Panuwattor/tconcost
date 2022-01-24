<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('purchase_order_id');
            $table->string('name');
            $table->decimal('amount', 16,2);
            $table->decimal('received', 25 ,16)->default(0.00);
            $table->string('unit');
            $table->decimal('unit_price', 16,3);
            $table->decimal('unit_discount', 16,2)->default(0.00);
            $table->decimal('price', 16,2);
            $table->string('vat')->nullable();
            $table->integer('accounting_id')->nullable();
            $table->decimal('special_discount', 16, 2)->default(0.00);
            $table->decimal('receive_special_discount', 16, 2)->default(0.00);
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
        Schema::dropIfExists('purchase_order_lists');
    }
}
