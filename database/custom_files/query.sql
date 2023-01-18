-- Run the following:

ALTER TABLE `dropdowns` ADD `taxable` TINYINT NOT NULL DEFAULT '0' AFTER `dropdown_name`;

UPDATE `dropdowns` SET `taxable`= 1 WHERE `category_id` = 1;

ALTER TABLE `dropdowns` CHANGE `taxable` `taxable` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '1=taxable, 2=Not Taxable';

CREATE OR REPLACE VIEW vw_salary_ssnit as
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
                    AND `staff`.`deleted_at` IS NULL;


CREATE OR REPLACE VIEW vw_tax as
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
                    AND `lp`.`deleted_at` IS NULL;


    ALTER TABLE `payroll_dependecies` ADD `pay_month` VARCHAR(15) NOT NULL AFTER `employee_ssf`, ADD `pay_year` VARCHAR(4) NOT NULL AFTER `pay_month`;

    ALTER TABLE `loan_payment_episodes` ADD `pay_month` VARCHAR(15) NOT NULL AFTER `status`, ADD `pay_year` VARCHAR(4) NOT NULL AFTER `pay_month`;

    UPDATE `payroll_dependecies` SET `pay_month`= CASE 
                        WHEN MONTH(`created_at`) = 1 THEN 'January' 
                        WHEN MONTH(`created_at`) = 2 THEN 'February' 
                        WHEN MONTH(`created_at`) = 3 THEN 'March' 
                        WHEN MONTH(`created_at`) = 4 THEN 'April' 
                        WHEN MONTH(`created_at`) = 5 THEN 'May' 
                        WHEN MONTH(`created_at`) = 6 THEN 'June' 
                        WHEN MONTH(`created_at`) = 7 THEN 'July' 
                        WHEN MONTH(`created_at`) = 8 THEN 'August' 
                        WHEN MONTH(`created_at`) = 9 THEN 'September' 
                        WHEN MONTH(`created_at`) = 10 THEN 'October' 
                        WHEN MONTH(`created_at`) = 11 THEN 'November' 
                        WHEN MONTH(`created_at`) = 12 THEN 'December'
                    END,`pay_year`= YEAR(`created_at`) WHERE 1;

    UPDATE `loan_payment_episodes` SET `pay_month`= CASE 
                        WHEN MONTH(`created_at`) = 1 THEN 'January' 
                        WHEN MONTH(`created_at`) = 2 THEN 'February' 
                        WHEN MONTH(`created_at`) = 3 THEN 'March' 
                        WHEN MONTH(`created_at`) = 4 THEN 'April' 
                        WHEN MONTH(`created_at`) = 5 THEN 'May' 
                        WHEN MONTH(`created_at`) = 6 THEN 'June' 
                        WHEN MONTH(`created_at`) = 7 THEN 'July' 
                        WHEN MONTH(`created_at`) = 8 THEN 'August' 
                        WHEN MONTH(`created_at`) = 9 THEN 'September' 
                        WHEN MONTH(`created_at`) = 10 THEN 'October' 
                        WHEN MONTH(`created_at`) = 11 THEN 'November' 
                        WHEN MONTH(`created_at`) = 12 THEN 'December'
                    END,`pay_year`= YEAR(`created_at`) WHERE 1;