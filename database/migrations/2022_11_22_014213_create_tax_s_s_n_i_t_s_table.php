<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_s_s_n_i_t_s', function (Blueprint $table) {
            $table->id();
            $table->decimal('first_0', 8,2);
            $table->decimal('next_5', 8,2);
            $table->decimal('next_10', 8,2);
            $table->decimal('next_17_5', 8,2);
            $table->decimal('next_25', 8,2);
            $table->decimal('exceeding', 8,2);
            $table->decimal('rate_0', 6,2)->default(0.00);
            $table->decimal('rate_1', 6,2);
            $table->decimal('rate_2', 6,2);
            $table->decimal('rate_3', 6,2);
            $table->decimal('rate_4', 6,2);
            $table->decimal('rate_5', 6,2);
            $table->decimal('ssf_employer', 4,2);
            $table->decimal('ssf_employee', 4,2);
            $table->timestamps();
        });

        DB::table('tax_s_s_n_i_t_s')->insert([
            'first_0' => 365.00,
            'next_5' => 110.00,
            'next_10' => 130.00,
            'next_17_5' => 3000.00,
            'next_25' => 16395.00,
            'exceeding' => 20000.00,
            'rate_0' => 0,
            'rate_1' => 5,
            'rate_2' => 10,
            'rate_3' => 17.5,
            'rate_4' => 25,
            'rate_5' => 30,
            'ssf_employer' => 13.00,
            'ssf_employee' =>  5.50
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tax_s_s_n_i_t_s');
    }
};
