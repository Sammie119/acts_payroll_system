<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DownloadPayslip;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class DownloadPayslipController extends Controller
{
    public function index()
    {
        $slips = DownloadPayslip::orderByDesc('id')->get();

        return view('download_salariespdf', ['slips' => $slips]);
    }

    public function downloadPayslips($file_name)
    {
        $file = storage_path(). "/salary_pdf/$file_name";

        $headers = ['Content-Type: text/pdf'];

        return Response::download($file, $file_name, $headers);

    }

    public function deletePayslip($month, $year)
    {
        DB::table('download_payslips')->where([['month', $month, ['year', $year]]])->delete();

        DB::table('payroll_episodes')->where([['pay_month', $month, ['pay_year', $year]]])->delete();

        return back()->with('success', 'Generated Slips Deleted Successfully!!!!');
    }
}
