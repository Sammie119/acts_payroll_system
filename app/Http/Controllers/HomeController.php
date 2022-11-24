<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        return view('home');
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
