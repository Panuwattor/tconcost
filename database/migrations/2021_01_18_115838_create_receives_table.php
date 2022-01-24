<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receives', function (Blueprint $table) {
            $table->id();
            $table->string('receive_code');
            $table->integer('project_id');
            $table->integer('po_id');
            $table->integer('supplier_id');
            $table->integer('user_id');
            $table->date('date');
            $table->string('type');
            $table->decimal('po_remain',16,2);
            $table->decimal('po_remain_percent');
            $table->string('note')->nullable();
            $table->integer('status')->default(0);
            $table->decimal('sum_price', 12, 2);
            $table->decimal('vat_amount', 12, 2);
            $table->decimal('sum', 12, 2);
            $table->decimal('special_discount', 12, 2)->default(0.00);
            $table->dateTime('approveDate')->nullable();
            $table->integer('user_approve_id')->nullable();
            $table->string('reject_note')->nullable();
            $table->string('payment_condition');
            $table->integer('duedate_id')->nullable();
            $table->integer('other_receive_status')->nullable();
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
        Schema::dropIfExists('receives');
    }
}
