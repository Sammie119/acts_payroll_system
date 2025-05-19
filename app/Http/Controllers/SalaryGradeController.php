<?php

namespace App\Http\Controllers;

use App\Models\SalaryGrade;
use App\Models\SalaryNotch;
use Illuminate\Http\Request;

class SalaryGradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data['grades'] = SalaryGrade::all();
        return view('salary_grades.salary_grades', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('salary_grades.add_grade');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'description' => 'required',
            'trans_amount' => 'nullable|numeric|min:1',
            'base_salary' => 'required|numeric|min:1',
            'notch_number' => 'required|numeric|min:1|max:25',
            'notch_percentage' => 'required|numeric|min:1|max:100',
        ]);

        $grade = SalaryGrade::firstOrCreate([
                'name' => $request['name'],
            ],
            [
                'description' => $request['description'],
                'trans_amount' => $request['trans_amount'],
                'base_salary' => $request['base_salary'],
                'notch_percentage' => $request['notch_percentage'],
                'created_by' => Auth()->user()->id,
                'updated_by' => Auth()->user()->id
        ]);

        // Add a notch to a grade
        $amount = $request['base_salary'];
        $next_amount = 0;
        for ($x = 0; $x <= $request['notch_number'] - 1; $x++) {

            $cal_amount = ($x === 0) ? $amount : $next_amount + ($next_amount * ($request['notch_percentage'] / 100));

            $grade->notches()->create([
                'notch_level' => $x + 1,
                'amount' => $cal_amount,
                'description' => 'Notch for '. $grade->name,
                'created_by' => Auth()->user()->id,
                'updated_by' => Auth()->user()->id
            ]);

            $next_amount = $cal_amount;
        }

        return redirect('/grades')->with('success', 'Grades Added Successfully!!!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SalaryGrade  $grade
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($grade)
    {
        $data['grade'] = SalaryGrade::find($grade);
        return view('salary_grades.add_grade', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SalaryGrade  $grade
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'description' => 'required',
            'trans_amount' => 'nullable|numeric|min:1',
            'base_salary' => 'required|numeric|min:1',
            'notch_percentage' => 'required|numeric|min:1|max:100',
        ]);

        $grade = SalaryGrade::find($request['id']);
        $grade->update([
            'name' => $request['name'],
            'description' => $request['description'],
            'trans_amount' => $request['trans_amount'],
            'base_salary' => $request['base_salary'],
            'notch_percentage' => $request['notch_percentage'],
            'updated_by' => Auth()->user()->id
        ]);

        $notches = SalaryNotch::select('id')->where('salary_grade_id', $request['id'])
            ->orderBy('id', 'asc')
            ->get();

        // Add a notch to a grade
        $amount = $request['base_salary'];
        $next_amount = 0;
        foreach ($notches as $key => $notch) {

            $cal_amount = ($key === 0) ? $amount : $next_amount + ($next_amount * ($request['notch_percentage'] / 100));

            SalaryNotch::find($notch->id)->update([
                'amount' => $cal_amount,
                'description' => 'Notch for '. $grade->name,
                'updated_by' => Auth()->user()->id
            ]);

            $next_amount = $cal_amount;
        }

        return redirect('/grades')->with('success', 'Grades Updated Successfully!!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SalaryGrade  $grade
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($grade)
    {
        $grade = SalaryGrade::find($grade);
        if($grade){
            SalaryNotch::where('salary_grade_id', $grade->id)->delete();
            $grade->delete();
        }

        return redirect('/grades')->with('success', 'Grades Deleted Successfully!!!');
    }
}
