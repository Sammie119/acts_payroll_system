<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\VWStaff;
use App\Models\SetupSalary;
use Illuminate\Http\Request;

class SetupSalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staff = Staff::count();
        $salary = SetupSalary::orderByDesc('salary_id')->limit($staff)->get();
        return view('setup_salary', ['salary' => $salary]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $staff = VWStaff::orderBy('staff_number')->get();
        return view('add_salary', ['staff' => $staff]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach ($request->staff_id as $key => $staff_id) {
            $salary = new SetupSalary;

            $salary->staff_id = $staff_id;
            $salary->salary = $request->salary[$key];
            $salary->tax_relief = $request->tax_relief[$key];
            $salary->created_by = Auth()->user()->id;
            $salary->updated_by = Auth()->user()->id;

            $salary->save();
        }

        return redirect('salary')->with('success', 'Salaries Added Successfully!!!');
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SetupSalary  $setupSalary
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $salary = SetupSalary::find($id);
        return view('add_salary', ['salary' => $salary]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SetupSalary  $setupSalary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $salary = SetupSalary::find($request->id);

        $salary->salary = $request->salary;
        $salary->tax_relief = $request->tax_relief;
        $salary->updated_by = Auth()->user()->id;

        $salary->update();

        return redirect('salary')->with('success', 'Salary Updated Successfully!!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SetupSalary  $setupSalary
     * @return \Illuminate\Http\Response
     */
    public function destroy(SetupSalary $setupSalary)
    {
        //
    }
}
