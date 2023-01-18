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
        DB::unprepared("CREATE OR REPLACE VIEW vw_salary_ssnit as
                SELECT
                `payroll_episodes`.`pay_id`,
                `staff`.`staff_id` AS `staff_id`,
                    `staff_number` AS `staff_number`,
                    `firstname` AS `firstname`,
                    `othernames` AS `othernames`,
                    CONCAT(
                        `firstname`,
                        ' ',
                        `othernames`
                    ) AS `fullname`,
                    DATE_FORMAT(
                        FROM_DAYS(
                            TO_DAYS(CURRENT_TIMESTAMP()) - TO_DAYS(
                                `date_of_birth`
                            )),
                            '%Y'
                        ) + 0 AS `age`,
                        `position` AS `position`,
                        `banker` AS `banker`,
                        `bank_account` AS `bank_account`,
                        `bank_branch` AS `bank_branch`,
                        `bank_sort_code` AS `bank_sort_code`,
                        `ssnit_number` AS `ssnit_number`,
                        `ghana_card` AS `ghana_card`,
                        `description` AS `description`,
                        `basic` AS `basic`,
                        `gross_income` AS `gross_income`,
                        `net_income` AS `net_income`,
                        CASE WHEN `ssnit_number` = 'NA' THEN 0.00 ELSE ROUND(
                            `basic` *(13.5 / 100),
                            2
                        )
                    END AS `tier_1`,
                    CASE 
                        WHEN `staff_number` = 'AS013' THEN ROUND(
                            `basic` *(5 / 100) + `basic` *(13.5 / 100),
                            2
                        ) 
                        WHEN `staff_number` = 'AS014' THEN ROUND(
                            `basic` *(5 / 100) + `basic` *(13.5 / 100),
                            2
                        ) 
                        ELSE ROUND(
                            `basic` *(5 / 100),
                            2
                        )
                    END AS `tier_2`,
                    30.00 AS `welfare`,
                    `tin_number` AS `tin_number`,
                    `pay_month` AS `pay_month`,
                    `pay_year` AS `pay_year`
                FROM
                    (
                        (
                            `staff`
                        JOIN `users`
                        )
                    JOIN `payroll_episodes`
                    )
                WHERE `staff`.`staff_id` = `payroll_episodes`.`staff_id` 
                    AND `staff`.`updated_by` = `users`.`id` 
                    AND `staff`.`deleted_at` IS NULL"
            );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP VIEW IF EXISTS vw_salary_ssnit');
    }
};
