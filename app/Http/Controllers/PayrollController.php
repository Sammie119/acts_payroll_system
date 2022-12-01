<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Payroll;
use App\Models\VWStaff;
use App\Models\LoanPayment;
use Illuminate\Http\Request;
use App\Models\PayrollDependecy;
use App\Models\SetupSalary;

class PayrollController extends Controller
{
    protected function percentageToAmount($array_amount, $array_rate, $basic_salary)
    {
        $get_arr = [];

        foreach ($array_amount as $i => $amount) {

            if($array_rate[$i] === 'Amount'){
                $value = ($amount / 1) * 1;
            }
            else {
                $value = ($amount / 100) * $basic_salary;
            }
            

            array_push($get_arr, $value);
        }
        
        return $get_arr;
    }

    protected function toAmount($array_rate)
    {
        $get_arr = [];

        foreach ($array_rate as $value) {

            $value = 'Amount';            

            array_push($get_arr, $value);
        }
        
        return $get_arr;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $salary = VWStaff::orderByDesc('staff_id')->get();
        return view('payroll_payment', ['salaries' => $salary]);
    }

    public function salaryInputs($id)
    {
        $salary = SetupSalary::find($id);
        $staff = VWStaff::where('staff_id', $salary->staff_id)->first();
        $pay = PayrollDependecy::where('staff_id', $staff->staff_id)->orderByDesc('id')->first();
        $loans = Loan::where([
                            ['staff_id', '=', $staff->staff_id],
                            ['status', '!=', 2],
                        ])->get();
        return view('salary_inputs', [
                            'salary' => $salary,
                            'staff' => $staff, 
                            'pay' => $pay,
                            'loans' => $loans,
                        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->tax);
        request()->validate([
            'staff_id' => 'required|numeric'
        ]);

        $staff_age = VWStaff::select('age')->where('staff_id', $request->staff_id)->first()->age;
        $pay = new PayrollDependecy;
        
        // dd($request->all());
        if($request->has('loan_id') && $request->has('amount_loan')){
            // dd($request->all());
            $paid_loan_ids = [];
            foreach ($request->loan_id as $i => $loan_id) {

                $payment = LoanPayment::where(['loan_id' => $loan_id, 'staff_id' => $request->staff_id])
                                    ->orderByDesc('loan_pay_id')->first();
                $loan = Loan::find($loan_id);                                     

                if($payment->amount - ($payment->total_amount_paid + $request->amount_loan[$i]) <= 0 ){
                    $status = 2;
                } else {
                    $status = 1;
                }
            
                // Update Loan Payment
                
                $loan->update(array(
                    'status' => $status, 
                    'rate' => $request->rate_loan,
                    'updated_by' => Auth()->user()->id
                ));

                $loan_pay = new LoanPayment;

                $loan_pay->loan_id = $loan_id;
                $loan_pay->staff_id = $request->staff_id;
                $loan_pay->amount = $loan->amount;
                $loan_pay->amount_paid = $request->amount_loan[$i];
                $loan_pay->total_amount_paid = $payment->total_amount_paid + $request->amount_loan[$i];
                $loan_pay->months_paid = $payment->months_paid + 1;
                $loan_pay->status = $status;
                $loan_pay->created_by = Auth()->user()->id;
                $loan_pay->updated_by = Auth()->user()->id;

                $loan_pay->save();
               
                $paid_loan_ids[] = $loan_pay->loan_pay_id;
            }
        }
        
        $pay->staff_id = $request->staff_id;
        $pay->loan_ids = $paid_loan_ids ?? null;
        $pay->incomes = $request->incomes;
        $pay->amount_incomes = (!empty($request->amount_incomes)) ? $this->percentageToAmount($request->amount_incomes, $request->rate_incomes, $request->basic_salary) : null;
        $pay->rate_incomes = (!empty($request->rate_incomes)) ? $this->toAmount($request->rate_incomes) : null;
        $pay->deductions = $request->deductions;
        $pay->amount_deductions = (!empty($request->amount_deductions)) ? $this->percentageToAmount($request->amount_deductions, $request->rate_deductions, $request->basic_salary) : null;
        $pay->rate_deductions = (!empty($request->rate_deductions)) ? $this->toAmount($request->rate_deductions) : null;
        $pay->tax = $request->tax;
        $pay->tax_relief = $request->tax_relief;
        $pay->employer_ssf = $request->employer_ssf;
        $pay->employee_ssf = ($staff_age <= 60) ? $request->employee_ssf : 0;
        $pay->created_by = Auth()->user()->id;
        $pay->updated_by = Auth()->user()->id;
        $pay->save();

        $pay->update(array(
            'tax' => getTax($request->basic_salary, $request->staff_id), 
        ));

        return redirect('payroll')->with('success', 'Payroll Created Successfully!!');
        
    }

    public function viewSalariesPaid($id)
    {
        $staff_id = SetupSalary::find($id)->staff_id;
        $payment = Payroll::where('staff_id', $staff_id)->orderByDesc('pay_id')->get();
        $staff_name = VWStaff::where('staff_id', $staff_id)->first();
        return view('view_paid_salaries', ['payments' => $payment, 'staff_name' => $staff_name]);
    }

    public function viewPayslip($id)
    {
        $pay = Payroll::find($id);
        $staff = VWStaff::where('staff_id', $pay->staff_id)->first();
        return view('view_payslip', ['pay' => $pay,'staff' => $staff]);
    }

    public function generatePayroll(Request $request)
    {
        $staffs = VWStaff::get();
        
        foreach ($staffs as $key => $staff) {
            // dd($staff->staff_id);
            $pay_dep = PayrollDependecy::where('staff_id', $staff->staff_id)->orderByDesc('id')->first();

            $basic_salary = SetupSalary::select('salary')->where('staff_id', $staff->staff_id)->orderByDesc('salary_id')->first()->salary;

            $total_loan_paid = 0;
            $loan_paid_id = null;
            if(!empty($pay_dep->loan_ids)){
                foreach ($pay_dep->loan_ids as $loan_ids) {
                    $loan = LoanPayment::find($loan_ids)->amount_paid;
                    
                    $total_loan_paid += $loan;
                    $loan_paid_id = $loan_ids;
                }
            }
            // dd($request->all(), $pay_dep, $pay_loan, $staff->salary);

            $incomes = floatval(array_sum($pay_dep->amount_incomes ?? [0]));
            $deductions = floatval(array_sum($pay_dep->amount_deductions ?? [0])) + floatval($pay_dep->tax) + floatval($pay_dep->employee_ssf) + floatval($total_loan_paid);

            $gross_income = $basic_salary + $incomes;
            $net_income = $gross_income - $deductions;

            $payroll = new Payroll;
            $payroll->staff_id = $staff->staff_id;
            $payroll->depend_id = $pay_dep->id;
            $payroll->loan_pay_id = $loan_paid_id;
            $payroll->description = $request->description;
            $payroll->positon = $staff->position;
            $payroll->basic = $basic_salary;
            $payroll->gross_income = $gross_income;
            $payroll->net_income = $net_income;
            $payroll->pay_month = $request->salary_month;
            $payroll->pay_year = $request->salary_year;
            $payroll->created_by = Auth()->user()->id;
            $payroll->updated_by = Auth()->user()->id;

            $payroll->save();
        }

        return redirect('payroll')->with('success', 'Payroll Generated Successfully!!');
        
    }

    public function getPaySlip($pay_id)
    {
        $pay = Payroll::find($pay_id);
        $staff = VWStaff::where('staff_id', $pay->staff_id)->first();
        return view('print_payslip', ['pay' => $pay, 'staff' => $staff]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function destroy($room_id)
    {
        $room = Payroll::find($room_id);
        $room->delete();

        return back()->with('success', 'Payroll Deleted Successfully!!');
    }
}
