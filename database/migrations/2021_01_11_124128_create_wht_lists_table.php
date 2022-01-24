<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhtListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wht_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('wht_id');
            $table->integer('accounting_id')->nullable();
            $table->string('article')->nullable();
            $table->string('note')->nullable();
            $table->decimal('amount', 12, 2);
            $table->decimal('rate', 6 ,2);
            $table->decimal('wht_tax', 12, 2);
            $table->integer('wht_group_id')->nullable();
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
        Schema::dropIfExists('wht_lists');
    }
}
