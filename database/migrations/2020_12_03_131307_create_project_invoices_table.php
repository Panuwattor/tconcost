<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->date('date');
            $table->string('code');
            $table->string('note')->nullable();
            $table->string('payment_condition');
            $table->integer('credit_amount')->nullable();
            $table->string('credit_note')->nullable();
            $table->date('credit_date')->nullable();
            $table->integer('status')->default(0);
            $table->integer('user_id');
            $table->integer('branch_id');
            $table->decimal('discount', 16, 2)->default(0);
            $table->string('vat_type');
            $table->decimal('tax_base', 16, 2)->default(0);
            $table->decimal('vat_amount', 16, 2)->default(0);
            $table->decimal('total', 16, 2)->default(0);
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
        Schema::dropIfExists('project_invoices');
    }
}
