<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectCostPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_cost_plans', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->integer('cost_plan_id');
            $table->integer('cost_plan_list_id');
            $table->decimal('cost', 16, 2)->default(0);
            $table->decimal('use_cost', 16, 2)->default(0);
            $table->string('note')->nullable();
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
        Schema::dropIfExists('project_cost_plans');
    }
}
