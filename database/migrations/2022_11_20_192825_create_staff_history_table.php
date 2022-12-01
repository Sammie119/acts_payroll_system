<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_history', function (Blueprint $table) {
            $table->id();
            $table->integer('staff_id');
            $table->string('staff_number', 10);
            $table->string('level_of_education')->nullable();
            $table->string('qualification')->nullable();
            $table->string('position')->nullable();
            $table->string('banker')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('bank_branch')->nullable();
            $table->date('insurance_expiry')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by');
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
        Schema::dropIfExists('staff_history');
    }
};
