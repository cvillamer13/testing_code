<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class EmployeeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // print_r( Auth::guard('employee')->check());
        if (Auth::guard('employee')->check()) {
            $user = Auth::guard('employee')->user();
            $data_images = asset("storage/".$user->image_path) ?? '/images/images.jpg';
            
            Session::put('user_name', $user->first_name . " " . $user->last_name); // Store user name
            Session::put('image_path', $data_images);
            // echo "<pre>";
            // print_r($user);
            // exit;
        }else{
            Auth::guard('employee')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/employee/login'); 
        }
        return $next($request);
    }
}
