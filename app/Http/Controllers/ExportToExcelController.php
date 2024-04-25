<?php

namespace App\Http\Controllers;

use App\Exports\ActsWelfareReportExcelExport;
use App\Exports\BankReportExcelExport;
use App\Exports\CreditUnionSavingReportExcelExport;
use App\Exports\GRAReportExcelExport;
use App\Exports\LoansReportExcelExport;
use App\Exports\NehemiahReportExcelExport;
use App\Exports\ProvidentFundReportExcelExport;
use App\Exports\RentAdvanceReportExcelExport;
use App\Exports\TeirOneReportExcelExport;
use App\Exports\TeirTwoReportExcelExport;
use App\Exports\WelfareDuesReportExcelExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportToExcelController extends Controller
{
    public function exportToBank($report_month, $report_year)
    {
        return Excel::download(new BankReportExcelExport($report_month, $report_year), 'bankfile_'.strtolower($report_month).'_'.$report_year.'.xlsx');
    }

    public function exportToCreditUnionSaving($report_month, $report_year)
    {
        return Excel::download(new CreditUnionSavingReportExcelExport($report_month, $report_year), 'credit_union_savings_'.strtolower($report_month).'_'.$report_year.'.xlsx');
    }

    public function exportToGRA($report_month, $report_year)
    {
        return Excel::download(new GRAReportExcelExport($report_month, $report_year), 'gra_tax_'.strtolower($report_month).'_'.$report_year.'.xlsx');
    }

    public function exportToLoans($report_month, $report_year)
    {
        return Excel::download(new LoansReportExcelExport($report_month, $report_year), 'loans_payments_'.strtolower($report_month).'_'.$report_year.'.xlsx');
    }

    public function exportToRentAdvance($report_month, $report_year)
    {
        return Excel::download(new RentAdvanceReportExcelExport($report_month, $report_year), 'rent_advance_payment_'.strtolower($report_month).'_'.$report_year.'.xlsx');
    }

    public function exportToTeirOne($report_month, $report_year)
    {
        return Excel::download(new TeirOneReportExcelExport($report_month, $report_year), 'teir_one_'.strtolower($report_month).'_'.$report_year.'.xlsx');
    }

    public function exportToTeirTwo($report_month, $report_year)
    {
        return Excel::download(new TeirTwoReportExcelExport($report_month, $report_year), 'teir_two_'.strtolower($report_month).'_'.$report_year.'.xlsx');
    }

    public function exportToWelfareDues($report_month, $report_year)
    {
        return Excel::download(new WelfareDuesReportExcelExport($report_month, $report_year), 'welfare_dues_contribution_'.strtolower($report_month).'_'.$report_year.'.xlsx');
    }

    public function exportToActsWelfare($report_month, $report_year)
    {
        return Excel::download(new ActsWelfareReportExcelExport($report_month, $report_year), 'acts_welfare_'.strtolower($report_month).'_'.$report_year.'.xlsx');
    }

    public function exportToNehemiah($report_month, $report_year)
    {
        return Excel::download(new NehemiahReportExcelExport($report_month, $report_year), 'nehemiah_'.strtolower($report_month).'_'.$report_year.'.xlsx');
    }

    public function exportToPFund($report_month, $report_year)
    {
        return Excel::download(new ProvidentFundReportExcelExport($report_month, $report_year), 'provident_fund_'.strtolower($report_month).'_'.$report_year.'.xlsx');
    }
}
