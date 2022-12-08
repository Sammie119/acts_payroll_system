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
        DB::unprepared("CREATE OR REPLACE VIEW vw_staff as
            SELECT
                `staff_id` AS `staff_id`,
                `staff_number` AS `staff_number`,
                `firstname` AS `firstname`,
                `othernames` AS `othernames`,
                CONCAT(
                    `firstname`,
                    ' ',
                    `othernames`
                ) AS `fullname`,
                `date_of_birth` AS `date_of_birth`,
                DATE_FORMAT(
                    FROM_DAYS(
                        TO_DAYS(CURRENT_TIMESTAMP()) - TO_DAYS(
                            `date_of_birth`
                        )),
                        '%Y'
                    ) + 0 AS `age`,
                    `phone` AS `phone`,
                    `staff`.`email` AS `email`,
                    `address` AS `address`,
                    `level_of_education` AS `level_of_education`,
                    `qualification` AS `qualification`,
                    `position` AS `position`,
                    `banker` AS `banker`,
                    `bank_account` AS `bank_account`,
                    `bank_branch` AS `bank_branch`,
                    `ssnit_number` AS `ssnit_number`,
                    `ghana_card` AS `ghana_card`,
                    `insurance_number` AS `insurance_number`,
                    `insurance_expiry` AS `insurance_expiry`,
                    TO_DAYS(
                        `insurance_expiry`
                    ) - TO_DAYS(CURRENT_TIMESTAMP()) AS `expiry_days`,
                    `tin_number` AS `tin_number`,
                    `created_by` AS `created_by`,
                    `updated_by` AS `updated_by`,
                    TRIM(
                        SUBSTR(
                            `users`.`name`,
                            1,
                            CHAR_LENGTH(`users`.`name`) - CHAR_LENGTH(
                                SUBSTRING_INDEX(
                                    REVERSE(`users`.`name`),
                                    ' ',
                                    1
                                )
                            )
                        )
                    ) AS `user`,
                   `staff`.`created_at` AS `created_at`,
                   `staff`.`updated_at` AS `updated_at`,
                   `staff`.`deleted_at` AS `deleted_at`
                FROM
                    (
                        `staff`
                    JOIN `users`
                    )
                WHERE `staff`.`updated_by` = `users`.`id` 
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
        DB::unprepared('DROP VIEW IF EXISTS vw_staff');
    }
};
