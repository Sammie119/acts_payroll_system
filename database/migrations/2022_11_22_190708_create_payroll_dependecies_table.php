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
        Schema::create('payroll_dependecies', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('staff_id');
            $table->json('loan_ids')->comment('loan paid ids')->nullable();
            $table->json('incomes')->comment('basic, allowance, ect')->nullable();
            $table->json('rate_incomes')->comment('amonut, percentage')->nullable();
            $table->json('amount_incomes')->comment('basic, allowance, ect')->nullable();
            $table->json('deductions')->comment('Tax, Loans, ssnit, ect')->nullable();
            $table->json('rate_deductions')->comment('amonut, percentage')->nullable();
            $table->json('amount_deductions')->comment('Tax, Loans, ssnit, ect')->nullable();
            $table->decimal('tax', 8,2)->default(0.00)->comment('part of deductions');
            $table->decimal('tax_relief', 8, 2)->default(0.00);
            $table->decimal('tier_3', 8, 2)->default(0.00);
            $table->decimal('employer_ssf', 8,2)->default(0.00);
            $table->decimal('employee_ssf', 8,2)->default(0.00)->comment('part of deductions');
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
        Schema::dropIfExists('payroll_dependecies');
    }
};
