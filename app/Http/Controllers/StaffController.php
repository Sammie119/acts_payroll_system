<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\VWStaff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @response {"status":1,"message":"Response message","data":{}}
     */
    public function index()
    {
        $staff = VWStaff::orderBy('staff_number')->get();
        return view('staff_list', ['staff' => $staff]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @response {"status":1,"message":"Response message","data":{}}
     */
    public function create()
    {
        return view('add_staff');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @response {"status":1,"message":"Response message","data":{}}
     */
    public function store(Request $request)
    {
        request()->validate([
            'staff_number' => 'required|unique:staff,staff_number',
            'firstname' => 'required',
            'othernames' => 'required',
            'date_of_birth' => 'required',
            'phone' => 'required',
            'email' => 'email|unique:staff,email',
            'address' => 'required',
            'level_of_education' => 'required',
            'qualification' => 'nullable',
            'position' => 'required',
            'banker' => 'required',
            'bank_account' => 'required|unique:staff,bank_account',
            'bank_branch' => 'required',
            'ssnit_number' => 'required|unique:staff,ssnit_number',
            'ghana_card' => 'required|unique:staff,ghana_card',
            'insurance_number' => 'required|unique:staff,insurance_number',
            'insurance_expiry' => 'required'
        ]);
        
        $staff = new Staff;

        $staff->staff_number = $request->staff_number;
        $staff->firstname = $request->firstname;
        $staff->othernames = $request->othernames;
        $staff->date_of_birth = $request->date_of_birth;
        $staff->phone = $request->phone;
        $staff->email = $request->email;
        $staff->address = $request->address;
        $staff->level_of_education = $request->level_of_education;
        $staff->qualification = $request->qualification;
        $staff->position = $request->position;
        $staff->banker = $request->banker;
        $staff->bank_account = $request->bank_account;
        $staff->bank_branch = $request->bank_branch;
        $staff->ssnit_number = $request->ssnit_number;
        $staff->ghana_card = $request->ghana_card;
        $staff->insurance_number = $request->insurance_number;
        $staff->insurance_expiry = $request->insurance_expiry;
        $staff->tin_number = $request->tin_number;
        $staff->created_by = Auth()->user()->id;
        $staff->updated_by = Auth()->user()->id;

        $staff->save();

        DB::table('staff_history')->insert([
            'staff_id' => $request->id,
            'staff_number' => $request->staff_number,
            'email' => $request->email,
            'level_of_education' => $request->level_of_education,
            'qualification' => $request->qualification,
            'position' => $request->position,
            'banker' => $request->banker,
            'bank_account' => $request->bank_account,
            'bank_branch' => $request->bank_branch,
            'insurance_expiry' => $request->insurance_expiry,
            'created_by' => Auth()->user()->id,
            'updated_by' => Auth()->user()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Staff Added Successfully!!!!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @response {"status":1,"message":"Response message","data":{}}
     */
    public function edit($id)
    {
        $staff = VWStaff::where('staff_id', $id)->first();
        return view('add_staff', ['staff' => $staff]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @response {"status":1,"message":"Response message","data":{}}
     */
    public function update(Request $request)
    {
        request()->validate([
            'staff_number' => 'required|unique:staff,staff_number,'.$request->id.',staff_id',
            'firstname' => 'required',
            'othernames' => 'required',
            'date_of_birth' => 'required',
            'phone' => 'required',
            'email' => 'email|unique:staff,email,'.$request->id.',staff_id',
            'address' => 'required',
            'level_of_education' => 'required',
            'qualification' => 'nullable',
            'position' => 'required',
            'banker' => 'required',
            'bank_account' => 'required|unique:staff,bank_account,'.$request->id.',staff_id',
            'bank_branch' => 'required',
            'ssnit_number' => 'required|unique:staff,ssnit_number,'.$request->id.',staff_id',
            'ghana_card' => 'required|unique:staff,ghana_card,'.$request->id.',staff_id',
            'insurance_number' => 'required|unique:staff,insurance_number,'.$request->id.',staff_id',
            'insurance_expiry' => 'required'
        ]);
        
        $staff = Staff::find($request->id);

        $staff->staff_number = $request->staff_number;
        $staff->firstname = $request->firstname;
        $staff->othernames = $request->othernames;
        $staff->date_of_birth = $request->date_of_birth;
        $staff->phone = $request->phone;
        $staff->email = $request->email;
        $staff->address = $request->address;
        $staff->level_of_education = $request->level_of_education;
        $staff->qualification = $request->qualification;
        $staff->position = $request->position;
        $staff->banker = $request->banker;
        $staff->bank_account = $request->bank_account;
        $staff->bank_branch = $request->bank_branch;
        $staff->ssnit_number = $request->ssnit_number;
        $staff->ghana_card = $request->ghana_card;
        $staff->insurance_number = $request->insurance_number;
        $staff->insurance_expiry = $request->insurance_expiry;
        $staff->tin_number = $request->tin_number;
        $staff->updated_by = Auth()->user()->id;

        $staff->update();

        DB::table('staff_history')->insert([
            'staff_id' => $request->id,
            'staff_number' => $request->staff_number,
            'email' => $request->email,
            'level_of_education' => $request->level_of_education,
            'qualification' => $request->qualification,
            'position' => $request->position,
            'banker' => $request->banker,
            'bank_account' => $request->bank_account,
            'bank_branch' => $request->bank_branch,
            'insurance_expiry' => $request->insurance_expiry,
            'created_by' => Auth()->user()->id,
            'updated_by' => Auth()->user()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('staff')->with('success', 'Staff Updated Successfully!!!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @response {"status":1,"message":"Response message","data":{}}
     */
    public function destroy($id)
    {
        $staff = Staff::find($id);

        $staff->delete();

        return back()->with('success', 'Staff Deleted Successfully!!!!');
    }
}
