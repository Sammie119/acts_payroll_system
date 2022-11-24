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
        Schema::create('loan_episodes', function (Blueprint $table) {
            $table->id('loan_id');
            $table->unsignedBigInteger('staff_id');
            $table->string('description')->nullable();
            $table->decimal('amount', 12, 2)->default(0.00);
            $table->decimal('amount_per_month', 10, 2)->default(0.00);
            $table->unsignedTinyInteger('number_of_months')->default(0);
            $table->string('rate', 20)->default('Amount');
            $table->unsignedTinyInteger('status')->default(0)->comment('0=pending, 1=paying, 2=paid');
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
        Schema::dropIfExists('loan_episodes');
    }
};
