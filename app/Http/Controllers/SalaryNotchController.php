<?php

namespace App\Http\Controllers;

use App\Models\SalaryGrade;
use App\Models\SalaryNotch;
use Illuminate\Http\Request;

class SalaryNotchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index($grade_id)
    {
        $data['grade'] = SalaryGrade::find($grade_id)->name;
        $data['notches'] = SalaryNotch::where('salary_grade_id', $grade_id)->get();
        return view('salary_grades.salary_notches', $data);
        // Get all notches for a salary grade
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SalaryNotch  $notch
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($notch)
    {
        $data['notch'] = SalaryNotch::find($notch);
        return view('salary_grades.add_notch', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        request()->validate([
//            'notch_level' => 'required',
            'description' => 'required',
            'amount' => 'nullable|numeric|min:1',
        ]);

        SalaryNotch::find($request['id'])->update([
//            'notch_level' => $request['notch_level'],
            'description' => $request['description'],
            'amount' => $request['amount'],
            'updated_by' => Auth()->user()->id
        ]);

        return redirect('/notches/'.$request['salary_grade_id'])->with('success', 'Notch Updated Successfully!!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SalaryNotch  $notch
     * @return \Illuminate\Http\Response
     */
    public function destroy($notch)
    {
        $notch = SalaryNotch::find($notch);
        $salaryGradeId = $notch->salary_grade_id;
        if($notch){
            $notch->delete();
        }

        return redirect('/notches/'.$salaryGradeId)->with('success', 'Grades Deleted Successfully!!!');
    }
}
