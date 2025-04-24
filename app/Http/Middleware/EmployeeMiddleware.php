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
            
            $permissions = User_pages_permission::where('roles_id', 7) // Assuming 7 is the role ID for employees
                    ->with('page') // Load related page data
                    ->get();
            Session::put('user_name', $user->first_name . " " . $user->last_name); // Store user name
            Session::put('image_path', $data_images);
            Session::put('company_data', $user->company);
            Session::put('user_email', $user->email);
            Session::put('user_permissions', $permissions->map(function ($permission) {
                return [
                    'page_id' => $permission->page->id,
                    'page' => $permission->page->URL,
                    'page_name' => $permission->page->name,
                    'icon_data' => $permission->page->icon_data,
                    'isView' => $permission->isView,
                    'isCreate' => $permission->isCreate,
                    'isUpdate' => $permission->isUpdate,
                    'isDelete' => $permission->isDelete,
                    'isProcess' => $permission->isProcess,
                ];
            }));

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
