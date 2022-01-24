<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptArsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt_ars', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->integer('branch_id');
            $table->string('code');
            $table->boolean('tax')->default(0); 
            $table->date('date');
            $table->string('note')->nullable();
            $table->decimal('amount', 12, 2);
            $table->decimal('remain', 12, 2);
            $table->decimal('receipt_amount', 12, 2);
            $table->integer('user_id');
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('receipt_ars');
    }
}
