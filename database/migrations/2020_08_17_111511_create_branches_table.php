<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('tel')->nullable();
            $table->string('tax')->nullable();
            $table->string('note')->nullable();
            $table->string('company')->nullable();              //บริษัทอะไร
            $table->string('company_eng')->nullable();          //บริษัทอะไร Eng
            $table->string('logo')->nullable();                 //โลโก้
            $table->string('code')->nullable();                 //รหัสสาขา
            $table->string('tax_code')->nullable();             //รหัสภาษีสาขา
            $table->boolean('status')->default(1);              //สถานะ
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
        Schema::dropIfExists('branches');
    }
}
