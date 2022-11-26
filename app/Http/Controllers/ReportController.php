<?php

namespace App\Http\Controllers;

use App\Models\VWStaff;
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
                $header = 'SALARIES FOR '. $request->report_month. ', '. $request->report_year;
                $data = VWStaff::orderBy('banker')->get();
                break;

            case 'tier_1':
                dd('Tier 1');
                break;

            case 'tier_2':
                dd('Tier 2');
                break;

            case 'contribute':
                dd('Welfare');
                break;

            case 'credit_union':
                dd('Credit Union');
                break;

            // case 'value':
            //     # code...
            //     break;
            
            default:
                return "No Report Selected";
                break;
        }

        return view('print_report', ['data' => $data, 'report' => $report, 'header' => $header, 'date' => $date]);
    }
}
