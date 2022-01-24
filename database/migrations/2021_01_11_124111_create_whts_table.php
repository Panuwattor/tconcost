<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whts', function (Blueprint $table) {
            $table->id();
            $table->integer('payment_id')->nullable();
            $table->string('payment_type')->nullable();
            $table->integer('project_id')->nullable();
            $table->integer('supplier_id');
            $table->string('code');
            $table->date('date');
            $table->string('type');
            $table->string('wht_payment_type');
            $table->string('note')->nullable();
            $table->string('name');
            $table->string('tax_id')->nullable();
            $table->string('address');
            $table->string('attribute');
            $table->integer('attribute_count')->default(0)->nullable();
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
        Schema::dropIfExists('whts');
    }
}
