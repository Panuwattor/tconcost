<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('customer_id')->nullable();
            $table->integer('project_type_id')->nullable();
            $table->string('code')->nullable();
            $table->string('year')->nullable();
            $table->boolean('general')->nullable();
            $table->boolean('type')->nullable();
            $table->decimal('project_cost', 16,2);
            $table->decimal('vat', 8,2)->nullable();
            $table->string('address')->nullable();
            $table->string('vat_type')->nullable();
            $table->date('start_date')->nullable();
            $table->date('finish_date')->nullable();
            $table->string('note')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('main_user_id')->nullable();
            $table->integer('status')->nullable();
            $table->integer('branch_id')->nullable();
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
        Schema::dropIfExists('projects');
    }
}
