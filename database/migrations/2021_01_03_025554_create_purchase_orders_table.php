<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->integer('project_id');
            $table->integer('supplier_id');
            $table->integer('branch_id');
            $table->date('po_date');
            $table->date('due_date');
            $table->string('address');
            $table->string('tel');
            $table->integer('main_user_id');
            $table->string('payment_type');
            $table->integer('cradit')->default(0)->nullable();
            $table->decimal('total_price', 16, 2);
            $table->decimal('special_discount', 16, 2)->default(0)->nullable();
            $table->decimal('sum_price', 16, 2);
            $table->string('vat_type')->nullable();
            $table->string('vat_amount')->default(0)->nullable();
            $table->string('patment_condition')->nullable();
            $table->string('note')->nullable();
            $table->integer('status')->default(0)->nullable();
            $table->integer('user_id');
            $table->integer('approve_user_id')->nullable();
            $table->string('reject_note')->nullable();
            $table->integer('notify')->nullable();
            $table->string('po_type');
            $table->integer('contract_id')->nullable();
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
        Schema::dropIfExists('purchase_orders');
    }
}
