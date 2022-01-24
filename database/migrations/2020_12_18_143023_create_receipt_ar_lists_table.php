<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptArListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt_ar_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('receipt_ar_id');
            $table->integer('project_invoice_id');
            $table->integer('income_id');
            $table->decimal('receipt', 12, 2);
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
        Schema::dropIfExists('receipt_ar_lists');
    }
}
