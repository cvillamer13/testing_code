<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User_pages_permission;

class EmployeeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // print_r($user->is_Active);
        // exit;
        if (Auth::guard('employee')->check()) {
            $user = Auth::guard('employee')->user();
            // print_r($user->is_active);
            $data_images = asset("storage/".$user->image_path) ?? '/images/images.jpg';
            Session::put('emp_id', $user->id);
            Session::put('user_name', $user->first_name . " " . $user->last_name); // Store user name
            Session::put('image_path', $data_images);
            Session::put('company_data', $user->company);
            Session::put('user_email', $user->email);

            Session::put('user_role', "Employee");
            Session::put('role_id', 7);

            if($user->is_active == 0){
                Auth::guard('employee')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect('/employee/login')->with('error', 'Your account is inactive. Please contact the administrator.');
            }
        }else{
            Auth::guard('employee')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/employee/login'); 
        }
        return $next($request);
    }
}
