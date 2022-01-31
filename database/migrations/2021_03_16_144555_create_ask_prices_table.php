<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAskPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ask_prices', function (Blueprint $table) {
            $table->id();
            $table->string('ap_id')->unique();
            $table->integer('project_id');
            $table->integer('main_user_id');
            $table->string('tel')->nullable();
            $table->string('delivery');
            $table->date('ap_date');
            $table->date('finish_date');
            $table->string('address');
            $table->string('photo')->nullable();
            $table->string('note')->nullable();
            $table->integer('user_id');
            $table->integer('branch_id');
            $table->integer('status')->default(0)->nullable();
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
        Schema::dropIfExists('ask_prices');
    }
}
