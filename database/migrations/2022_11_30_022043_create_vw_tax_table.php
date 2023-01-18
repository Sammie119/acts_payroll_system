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
        DB::unprepared("CREATE OR REPLACE VIEW vw_tax as
                SELECT
                    lp.`id` as pay_id,
                    staff.`staff_id` AS `staff_id`,
                    `staff_number` AS `staff_number`,
                    `firstname` AS `firstname`,
                    `othernames` AS `othernames`,
                    CONCAT(
                        `firstname`,
                        ' ',
                        `othernames`
                    ) AS `fullname`,
                    `lp`.`tax` AS `tax`,
                    `lp`.`tax_relief` AS `tax_relief`,
                    `lp`.`tier_3` AS `tier_3`,
                    `lp`.`incomes` AS `incomes`,
                    `lp`.`rate_incomes` AS `rate_incomes`,
                    `lp`.`amount_incomes` AS `amount_incomes`,
                    `lp`.`deductions` AS `deductions`,
                    `lp`.`rate_deductions` AS `rate_deductions`,
                    `lp`.`amount_deductions` AS `amount_deductions`,
                    CASE 
                        WHEN MONTH(`lp`.`created_at`) = 1 THEN 'January' 
                        WHEN MONTH(`lp`.`created_at`) = 2 THEN 'February' 
                        WHEN MONTH(`lp`.`created_at`) = 3 THEN 'March' 
                        WHEN MONTH(`lp`.`created_at`) = 4 THEN 'April' 
                        WHEN MONTH(`lp`.`created_at`) = 5 THEN 'May' 
                        WHEN MONTH(`lp`.`created_at`) = 6 THEN 'June' 
                        WHEN MONTH(`lp`.`created_at`) = 7 THEN 'July' 
                        WHEN MONTH(`lp`.`created_at`) = 8 THEN 'August' 
                        WHEN MONTH(`lp`.`created_at`) = 9 THEN 'September' 
                        WHEN MONTH(`lp`.`created_at`) = 10 THEN 'October' 
                        WHEN MONTH(`lp`.`created_at`) = 11 THEN 'November' 
                        WHEN MONTH(`lp`.`created_at`) = 12 THEN 'December'
                    END AS `pay_month`,
                    YEAR(`lp`.`created_at`) AS `pay_year`
                FROM
                    (
                        `payroll_dependecies` `lp`
                    JOIN `staff`
                    )
                WHERE `staff`.`staff_id` = `lp`.`staff_id` 
                    AND `lp`.`deleted_at` IS NULL"
            );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP VIEW IF EXISTS vw_tax');
    }
};
