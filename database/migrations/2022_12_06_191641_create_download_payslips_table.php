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
        Schema::create('download_payslips', function (Blueprint $table) {
            $table->id();
            $table->string('month', 20)->nullable();
            $table->integer('year')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_url')->nullable();
            $table->string('description');
            $table->unsignedTinyInteger('email_status')->default(0)->comment('0 = Not Sent, 1 = Sent');
            $table->unsignedBigInteger('created_by');
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
        Schema::dropIfExists('download_payslips');
    }
};
