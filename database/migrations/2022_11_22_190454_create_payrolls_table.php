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
        Schema::create('payroll_episodes', function (Blueprint $table) {
            $table->id('pay_id');
            $table->unsignedInteger('staff_id');
            $table->unsignedBigInteger('depend_id')->nullable();
            $table->unsignedBigInteger('loan_pay_id')->nullable();
            $table->string('description');
            $table->string('positon', 50);
            $table->decimal('basic', 12,2);
            $table->decimal('gross_income', 12,2);
            $table->decimal('net_income', 12,2);
            $table->string('pay_month', 15);
            $table->string('pay_year', 4);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payroll_episodes');
    }
};
