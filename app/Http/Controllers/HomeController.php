<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\PayrollDependecy;
use App\Models\Staff;
use App\Models\User;
use App\Models\VWStaff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $staff = VWStaff::orderBy('staff_number')->get();
        $t_staff = Staff::count();
        $m = Date('mY', strtotime(date('d-m-Y') . " last month"));
        // dd($m);
        $t_gra = PayrollDependecy::whereRaw("CONCAT(MONTH(updated_at), YEAR(updated_at)) = $m")->sum('tax');
        $t_ssf1 = PayrollDependecy::whereRaw("CONCAT(MONTH(updated_at), YEAR(updated_at)) = $m")->sum('employee_ssf');
        $t_ssf2 = PayrollDependecy::whereRaw("CONCAT(MONTH(updated_at), YEAR(updated_at)) = $m")->sum('employer_ssf');
        $t_salary = Payroll::whereRaw("CONCAT(MONTH(updated_at), YEAR(updated_at)) = $m")->sum('net_income');

        $result = [
            't_staff' => $t_staff,
            't_gra' => $t_gra,
            't_ssf' => $t_ssf1 + $t_ssf2,
            't_salary' => $t_salary,
        ];
        return view('home', ['staff' => $staff, 'results' => $result]);
    }

    public function users()
    {
        $users = User::orderByDesc('id')->get();
        return view('users', ['users' => $users]);
    }

    public function resetPassword(Request $request)
    {
        
        User::find($request->token)->update([
            'password' => Hash::make($request['password']),
        ]);

        return redirect('users')->with('success', 'User Password Reseted Successfully!!!!');
    }

    public function destroy($id)
    {
        $user = User::find($id);

        $user->delete();

        return back()->with('success', 'User Deleted Successfully!!!!');
    }
}
