<?php

namespace App\Http\Controllers;

use App\Jobs\EmployeePayslipJob;
use App\Models\Loan;
use App\Models\Payroll;
use App\Models\VWStaff;
use App\Models\LoanPayment;
use File;
use App\Models\DownloadPayslip;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class DownloadPayslipController extends Controller
{
    public function index()
    {
        $slips = DownloadPayslip::orderByDesc('id')->get();

        return view('download_salariespdf', ['slips' => $slips]);
    }

    static function generatePdfFile($month, $year, $pay, $request = null)
    {
        // dd($pay);
        if(isset($request)){
            $filename = $request.'_'.strtolower($month).'_'.$year.'_payslip';
        } else {
            $filename = 'salaries_for_'.strtolower($month).'_'.$year;
        }

        Pdf::loadView('salary_pdf', ['payment' => $pay, 'request' => $request])->setPaper('a4', 'portrait')->save(storage_path('salary_pdf/'.$filename.'.pdf'));

        return $filename;
    }

    public function downloadPayslips($month, $year)
    {
        File::deleteDirectory(storage_path('salary_pdf', true));
        File::makeDirectory(storage_path('salary_pdf', true));

        $pay = Payroll::where([['pay_month', $month], ['pay_year', $year]])->orderBy('staff_id')->get();

        // Generate PDF file
        $filename = DownloadPayslipController::generatePdfFile($month, $year, $pay);

        $filename = $filename.".pdf";

        $file = storage_path("salary_pdf/$filename");

        $headers = ['Content-Type: application/pdf'];

        return Response::download($file, $filename, $headers);

    }

    public function sendEmails($month, $year)
    {
        $payment = Payroll::where([['pay_month', $month], ['pay_year', $year]])->orderBy('staff_id')->get();

        foreach ($payment as $pay) {
            $staff = VWStaff::where('staff_id', $pay->staff_id)->first();

            if (!empty($staff->email)) {
                $data = [
                    'pay' => $pay,
                    'name' => $staff->fullname,
                    'staff_id' => $staff->staff_number,
                    'month' => $month,
                    'year' => $year
                ];

                $sendData = [
                    'email' => $staff->email,
                    'data' => $data
                ];

                EmployeePayslipJob::dispatch($sendData);
//                Mail::to($staff->email)->send(new EmployeePayslip($data));

                // unlink(storage_path('salary_pdf/'.$staff->staff_number.'_'.strtolower($month).'_'.$year.'_payslip.pdf'));
            }

            // php artisan schedule:run
            // Artisan::call('schedule:run');

        }

        DownloadPayslip::where([['month', $month], ['year', $year]])->update(array(
            'email_status' => 1,
        ));

        return back()->with('success', 'Emails sent Successfully!!!');
    }

    public function deletePayslip($month, $year, $file_name)
    {
        DB::table('download_payslips')->where([['month', $month, ['year', $year]]])->delete();

        unlink(storage_path('salary_pdf/'.strval($file_name)));

        DB::table('payroll_episodes')->where([['pay_month', $month, ['pay_year', $year]]])->delete();

        DB::table('payroll_dependecies')->where([['pay_month', $month, ['pay_year', $year]]])->delete();

        $loan_pay = LoanPayment::select('loan_id', 'status')->where([['pay_month', $month, ['pay_year', $year]]])->where('status', '!=', 0)->get();

        // dd($loan_pay);
        if($loan_pay) {
            foreach ($loan_pay as $loan) {

                $loan = Loan::find($loan->loan_id);

                if($loan->status === 1){
                    $loan->update([
                        'status' => 0
                    ]);
                } elseif($loan->status === 2){
                    $loan->update([
                        'status' => 1
                    ]);
                }
            }

            DB::table('loan_payment_episodes')->where([['pay_month', $month, ['pay_year', $year]]])->where('status', '!=', 0)->delete();
        }

        return back()->with('success', 'Generated Slips Deleted Successfully!!!!');
    }
}
