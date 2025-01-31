<?php

namespace App\Http\Controllers;

use App\Models\VWLoanPayment;
use App\Models\VWSalarySsnit;
use App\Models\VWStaff;
use App\Models\VWTax;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports');
    }

    public function GenerateReport(Request $request)
    {
        request()->validate([
            'report_type' => 'required',
            'report_month' => 'required',
            'report_year' => 'required|numeric',
        ]);

        // dd($request->all());
        $date = [
            'month' => $request->report_month,
            'year' => $request->report_year
        ];

        switch ($request->report_type) {
            case 'bank_doc':
                $report = 'Bankers';
                $header = 'SALARIES FOR '. strtoupper($request->report_month). ', '. $request->report_year;
                $data = VWSalarySsnit::where([
                    ['pay_month', $request->report_month],
                    ['pay_year', $request->report_year]
                ])->orderBy('banker')->get();
                break;

            case 'tier_1':
                $report = 'tier_1';
                $header = 'SSNIT 1ST TIER CONTRIBUTION RETURNS FOR '. strtoupper($request->report_month). ', '. $request->report_year;
                $data = VWSalarySsnit::where([
                    ['pay_month', $request->report_month],
                    ['pay_year', $request->report_year],
                    ['pay_tier1', 1]
                ])->orderBy('staff_number')->get();
                break;

            case 'tier_2':
                $report = 'tier_2';
                $header = '2ND TIER CONTRIBUTION RETURNS FOR '. strtoupper($request->report_month). ', '. $request->report_year;
                $data = VWSalarySsnit::where([
                    ['pay_month', $request->report_month],
                    ['pay_year', $request->report_year],
                    ['pay_tier2', 1]
                ])->orderBy('staff_number')->get();
                break;

            case 'paye_tax':
                $report = 'paye_tax';
                $header = 'STAFF INCOME TAX CONTRIBUTION FOR '. strtoupper($request->report_month). ', '. $request->report_year;
                $data = VWSalarySsnit::where([
                    ['pay_month', $request->report_month],
                    ['pay_year', $request->report_year]
                ])->orderBy('staff_number')->get();
                break;

            case 'welfare':
                $report = 'welfare';
                $header = 'WELFARE DUES '. strtoupper($request->report_month). ', '. $request->report_year;
                $data = VWTax::where([
                    ['pay_year', $request->report_year],
                    ['deductions', '!=', NULL]
                ])->whereRaw("pay_month collate utf8mb4_unicode_ci = '$request->report_month'")->orderBy('staff_number')->get();
                break;

            case 'credit_union':
                $report = 'credit_union';
                $header = 'CREDIT UNION SAVINGS CONTRIBUTIONS FOR '. strtoupper($request->report_month). ', '. $request->report_year;
                $data = VWTax::where([
                    ['pay_year', $request->report_year],
                    ['deductions', '!=', NULL]
                ])->whereRaw("pay_month collate utf8mb4_unicode_ci = '$request->report_month'")->orderBy('staff_number')->get();
                break;

            case 'rent':
                $report = 'rent';
                $header = 'RENT ADVANCE PAYMENT FOR '. strtoupper($request->report_month). ', '. $request->report_year;
                $data = VWLoanPayment::where([
                    ['pay_year', $request->report_year],
                    ['description', 'Rent Advance']
                ])->whereRaw("pay_month collate utf8mb4_unicode_ci = '$request->report_month'")->orderBy('staff_number')->get();
                break;

            case 'loans':
                $report = 'loans';
                $header = 'OTHER LOAN PAYMENT FOR '. strtoupper($request->report_month). ', '. $request->report_year;
                $data = VWLoanPayment::where([
                    ['pay_year', $request->report_year],
                    ['description', '!=', 'Rent Advance']
                ])->whereRaw("pay_month collate utf8mb4_unicode_ci = '$request->report_month'")->orderBy('staff_number')->get();
                break;

            case 'p_fund':
                $report = 'p_fund';
                $header = 'Provident Fund '. strtoupper($request->report_month). ', '. $request->report_year;
                $data = VWSalarySsnit::where([
                    ['pay_year', $request->report_year]
                ])->whereRaw("pay_month collate utf8mb4_unicode_ci = '$request->report_month'")->orderBy('staff_number')->get();

                break;

//            case 'credit_hire':
//                $report = 'credit_hire';
//                $header = 'Credit Union Hire Purchase '. strtoupper($request->report_month). ', '. $request->report_year;
//                $data = VWLoanPayment::where([
//                    ['pay_year', $request->report_year],
//                    ['description', '!=', 'Credit Union Hire Purchase']
//                ])->whereRaw("pay_month collate utf8mb4_unicode_ci = '$request->report_month'")->orderBy('staff_number')->get();
//                break;

            case 'nehemiah':
                $report = 'nehemiah';
                $header = 'Nehemiah Project '. strtoupper($request->report_month). ', '. $request->report_year;
                $data = VWTax::where([
                    ['pay_year', $request->report_year],
                    ['deductions', '!=', NULL]
                ])->whereRaw("pay_month collate utf8mb4_unicode_ci = '$request->report_month'")->orderBy('staff_number')->get();
                break;

            case 'acts_welfare':
                $report = 'acts_welfare';
                $header = 'ACTS Welfare '. strtoupper($request->report_month). ', '. $request->report_year;
                $data = VWSalarySsnit::where([
                    ['pay_month', $request->report_month],
                    ['pay_year', $request->report_year]
                ])->orderBy('staff_number')->get();
                break;

            // case 'value':
            //     # code...
            //     break;

            default:
                return "No Report Selected";
                break;
        }

        return view('print_report', ['data' => $data, 'report' => $report, 'header' => strtoupper($header), 'date' => $date]);
    }
}
