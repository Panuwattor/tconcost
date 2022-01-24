<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->integer('invoice_id')->nullable();
            $table->string('type');
            $table->string('description');
            $table->string('unit');
            $table->date('date');
            $table->decimal('price', 16, 2)->default(0);
            $table->decimal('percent', 9, 4)->default(0);
            $table->decimal('discount', 16, 2)->default(0);
            $table->decimal('total', 16, 2)->default(0);
            $table->string('note')->nullable();
            $table->boolean('status')->default(0);
            $table->decimal('receive_price', 16, 2)->default(0);
            $table->decimal('vat', 16, 2)->default(0);
            $table->decimal('price_before_vat', 16, 2)->default(0);
            $table->decimal('sum_price_vat', 16, 2)->default(0);
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
        Schema::dropIfExists('incomes');
    }
}
