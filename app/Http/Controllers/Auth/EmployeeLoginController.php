<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;


class EmployeeLoginController extends Controller
{
    public function login_index() : View
    {
        return view('auth.login_employee');
    }

    public function store_sys(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember'); // true/false

        if (Auth::guard('employee')->attempt($credentials, $remember)) {
            // Login success, redirect to dashboard
            return redirect()->intended('/employee/index');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email', 'remember'));
    }


    public function main()
    {
        return view('Employee_portal.index');
    }
    public function logout(Request $request)
    {
        Auth::guard('employee')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/employee/login');
    }
}
