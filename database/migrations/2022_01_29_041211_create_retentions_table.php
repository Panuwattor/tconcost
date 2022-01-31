<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetentionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retentions', function (Blueprint $table) {
            $table->id();
            $table->integer('receive_id');
            $table->integer('project_id');
            $table->integer('branch_id');
            $table->integer('customer_id');
            $table->decimal('price', 12, 2);
            $table->integer('user_id');
            $table->integer('staus')->default(0);
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
        Schema::dropIfExists('retentions');
    }
}
