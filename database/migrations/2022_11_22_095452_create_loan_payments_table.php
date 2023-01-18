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
        Schema::create('loan_payment_episodes', function (Blueprint $table) {
            $table->id('loan_pay_id');
            $table->unsignedBigInteger('loan_id');
            $table->unsignedBigInteger('staff_id');
            $table->decimal('amount', 12, 2)->default(0.00);
            $table->decimal('amount_paid', 10, 2)->default(0.00);
            $table->decimal('total_amount_paid', 12, 2)->default(0.00);
            $table->unsignedTinyInteger('months_paid')->default(0);
            $table->unsignedTinyInteger('status')->default(0)->comment('0=pending, 1=paying, 2=paid');
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
        Schema::dropIfExists('loan_payment_episodes');
    }
};
