<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\VWStaff;
use App\Models\LoanPayment;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loans = Loan::orderByDesc('loan_id')->get();
        return view('loans', ['loans' => $loans]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('add_loan');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        request()->validate([
            'staffname' => 'required',
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'amount_per_month' => 'required|numeric',
            'number_of_months' => 'required|numeric|min:1|max:48', // max:48 = 4 years
        ]);

        $loan = new Loan;
        $loan_pay = new LoanPayment; 
        
        $staff_id = VWStaff::select('staff_id')->where('fullname', $request->staffname)->first()->staff_id;
        
        $loan->staff_id = $staff_id;
        $loan->description = $request->description;
        $loan->amount = $request->amount;
        $loan->amount_per_month = $request->amount_per_month;
        $loan->number_of_months = $request->number_of_months;

        $loan->created_by = Auth()->user()->id;
        $loan->updated_by = Auth()->user()->id;
        $loan->save();

        $loan_pay->loan_id = $loan->loan_id;
        $loan_pay->staff_id = $staff_id;
        $loan_pay->amount = $request->amount;
        $loan_pay->amount_paid = 0;
        $loan_pay->months_paid = 0;
        $loan_pay->pay_month = date('F');
        $loan_pay->pay_year = date('Y');
        $loan_pay->created_by = Auth()->user()->id;
        $loan_pay->updated_by = Auth()->user()->id;
        $loan_pay->save();

        return redirect('loans')->with('success', 'Loan Created Successfully!!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $loan = Loan::find($id);
        return view('add_loan', ['loan' => $loan]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $loan = Loan::find($request->id);

        if($loan->status === 0){
            // dd($request->all());
            request()->validate([
                'staffname' => 'required',
                'description' => 'required|string',
                'amount' => 'required|numeric',
                'amount_per_month' => 'required|numeric',
                'number_of_months' => 'required|numeric|min:1|max:48', // max:48 = 4 years
            ]);

            $loan = Loan::find($request->id);  
            
            $staff_id = VWStaff::select('staff_id')->where('fullname', $request->staffname)->first()->staff_id;
            
            $loan->staff_id = $staff_id;
            $loan->description = $request->description;
            $loan->amount = $request->amount;
            $loan->amount_per_month = $request->amount_per_month;
            $loan->number_of_months = $request->number_of_months;

            $loan->updated_by = Auth()->user()->id;
            $loan->update();

            LoanPayment::where('loan_id', $request->id)->update(array(
                'staff_id' => $staff_id, 
                'amount' => $request->amount,
                'pay_month' => date('F'),
                'pay_year' => date('Y'),
                'updated_by' => Auth()->user()->id
            ));

            return redirect('loans')->with('success', 'Loan Updated Successfully!!');
        }
        else {
            return redirect('loans')->with('error', 'Loan Payment has Started or Completed. Cannot Update!!!!');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $loan = Loan::find($id);
        if($loan->status === 0){
            $loan->delete();

            LoanPayment::where('loan_id', $id)->delete();

            return redirect('loans')->with('success', 'Loan Deleted Successfully!!');
        }
        else {
            return back()->with('error', 'Loan Payment has Started or Completed. Cannot Delete!!!!');
        }
    }

    public function viewLoanPayment($id)
    {
        $loan_payment = LoanPayment::where([['loan_id', $id], ['months_paid', '!=', 0]])->get();
        $staff = Loan::find($id)->staff_id;
        return view('view_loans', ['loan' => $loan_payment, 'staff' => $staff]);
    }
}
