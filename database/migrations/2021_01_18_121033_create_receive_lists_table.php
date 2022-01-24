<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiveListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receive_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('receive_id');
            $table->string('name');
            $table->decimal('amount', 25,16);
            $table->string('unit');
            $table->decimal('unit_price', 16,2);
            $table->decimal('unit_discount', 16,2)->default(0.00);
            $table->decimal('price', 16,2);
            $table->decimal('vat', 12, 2)->default(0.00);
            $table->decimal('invoice_discount', 12, 2)->default(0.00);
            $table->integer('po_list_id');
            $table->decimal('fromAmount', 25,16)->default(0);
            $table->integer('accounting_id')->nullable();
            $table->decimal('special_discount', 12, 2)->default(0.00);
            $table->integer('other_receive_list_id')->nullable();
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
        Schema::dropIfExists('receive_lists');
    }
}
