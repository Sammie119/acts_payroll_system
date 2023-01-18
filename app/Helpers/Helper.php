<?php

use App\Models\Dropdown;
use App\Models\Staff;
use App\Models\VWStaff;
use App\Models\TaxSSNIT;
use App\Models\PayrollDependecy;
use App\Models\SetupSalary;

    function getStaffName($staff_id)
    {
        return VWStaff::where('staff_id', $staff_id)->first()->fullname;
    }

    function getFirstname($fullname){
        $name = explode(" ", $fullname);
        return $name[0];
    }

    function getLoanStatus($status) 
    {
        switch ($status) {
            case 0:
                return "Pending";
                break;
            
            case 1:
                return "Paying";
                break;

            case 2:
                return "Paid";
                break;

            default:
                return "No Status";
                break;
        }
    }

    function getSsfEmployer($basic)
    {
        $tax = floatval(TaxSSNIT::select('ssf_employer')->orderByDesc('id')->first()->ssf_employer);
        return floatval($basic * ($tax/100));
    }

    function getSsfEmployee($basic)
    {
        $tax = floatval(TaxSSNIT::select('ssf_employee')->orderByDesc('id')->first()->ssf_employee);
        return floatval($basic * ($tax/100));
    }

    function getTaxRelief($staff_id)
    {
        return SetupSalary::select('tax_relief')->where('staff_id', $staff_id)->orderByDesc('salary_id')->first()->tax_relief;
    }

    function getTierThree($staff_id, $basic)
    {
        $tier_3 = SetupSalary::select('tier_3')->where('staff_id', $staff_id)->orderByDesc('salary_id')->first()->tier_3;
        
        if($tier_3 > 0){
            return floatval($basic * ($tier_3/100));
        }

        return 0;
    }

    function getTaxableAllowancesAmount(array $allownces = null, array $amounts = null): array
    {
        $allownces_amount = [];

        if ($allownces === null){
            return [0];
        }

        foreach ($allownces as $key => $allownce) {
            $taxable = Dropdown::select('taxable')->where('dropdown_name', $allownce)->first()->taxable;
            if($taxable === 1){
                array_push($allownces_amount, $amounts[$key]);
            }
        }
        // dd($allownces_amount);
        return $allownces_amount;
    }

    function getTax($basic, $id)
    {
        // dd(floatval(getTaxRelief($id)));
        $tax = TaxSSNIT::orderByDesc('id')->first();
        $ssf = $tax->ssf_employee;
        $first = $tax->first_0;
        $next_1 = $tax->next_5;
        $next_2 = $tax->next_10;
        $next_3 = $tax->next_17_5;
        $next_4 = $tax->next_25;
        $exceeding = $tax->exceeding;
        $rate_0 = $tax->rate_0;
        $rate_1 = $tax->rate_1;
        $rate_2 = $tax->rate_2;
        $rate_3 = $tax->rate_3;
        $rate_4 = $tax->rate_4;
        $rate_5 = $tax->rate_5;

        // Allowance
        $allownce = PayrollDependecy::select('incomes', 'amount_incomes')->where('staff_id', $id)->orderByDesc('id')->first();

        $total_allowance = array_sum(getTaxableAllowancesAmount($allownce->incomes ?? [0], $allownce->amount_incomes ?? [0]));
        // dd($total_allowance);

        $result = floatval($basic + $total_allowance) - (floatval($first + ($basic * ($ssf/100))) + floatval(getTaxRelief($id)) + floatval(getTierThree($id, $basic)));

        if($result > 0){

            if($result > $next_1) {
                $next_1_result = $result - $next_1;
            } else {
                return floatval($result * ($rate_1/100));
            }
            
            if($next_1_result >= 1){

                if($next_1_result > $next_2) {
                    $next_2_result = $next_1_result - $next_2;
                } else {
                    return floatval($next_1 * ($rate_1/100)) + floatval($next_1_result * ($rate_2/100));
                }

                if($next_2_result >= 1){

                    if($next_2_result > $next_3) {
                        $next_3_result = $next_2_result - $next_3;
                    } else {
                        return floatval($next_1 * ($rate_1/100)) + floatval($next_2 * ($rate_2/100)) + floatval($next_2_result * ($rate_3/100));
                    }
                    
                    if($next_3_result >= 1){

                        if($next_3_result > $next_4) {
                            $next_4_result = $next_3_result - $next_4;
                        } else {
                            return floatval($next_1 * ($rate_1/100)) + floatval($next_2 * ($rate_2/100)) + floatval($next_3 * ($rate_3/100)) + floatval($next_3_result * ($rate_4/100)); 
                        }

                        if($next_4_result >= 1){

                            $exceeding_result = $next_4_result;
                            
                            return floatval($next_1 * ($rate_1/100)) + floatval($next_2 * ($rate_2/100)) + floatval($next_3 * ($rate_3/100)) + floatval($next_4 * ($rate_4/100)) + floatval($exceeding_result * ($rate_5/100));
                            
                        } 

                    } 

                } 

            } 
        } else {

            return floatval($first * ($rate_0/100));

        }
        // return floatval($basic * ($rate_4/100));
    }