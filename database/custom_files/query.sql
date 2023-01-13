-- Run the following:

--  ALTER TABLE `payroll_dependecies` ADD `tier_3` DECIMAL(8,2) NULL DEFAULT '0.00' AFTER `tax_relief`;

ALTER TABLE `tax_s_s_n_i_t_s` 
ADD `rate_0` DECIMAL(6, 2) NOT NULL DEFAULT '0.00' AFTER `exceeding`, 
ADD `rate_1` DECIMAL(6, 2) NOT NULL AFTER `rate_0`, 
ADD `rate_2` DECIMAL(6, 2) NOT NULL AFTER `rate_1`, 
ADD `rate_3` DECIMAL(6, 2) NOT NULL AFTER `rate_2`, 
ADD `rate_4` DECIMAL(6, 2) NOT NULL AFTER `rate_3`, 
ADD `rate_5` DECIMAL(6, 2) NOT NULL AFTER `rate_4`;