<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User_pages_permission;
use App\Models\Page;


class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            $role = $user->role; // Get user role
            
            if ($role && $user->active_status == 1) { // Check if role exists and user is active
                $permissions = User_pages_permission::where('roles_id', $role->id)
                    ->with('page') // Load related page data
                    ->get();
                    $data_images = asset("storage/".$user->image_path) ?? '/images/images.jpg';
                    // echo "<pre>";
                    // print_r($permissions[0]->page->pages_category);
                    // exit;
                    Session::put('user_name', $user->name); // Store user name
                    Session::put('image_path', $data_images); // Store user 
                    Session::put('user_role', $role->name);
                    Session::put('role_id', $role->id);
                    Session::put('user_id', $user->id);
                    Session::put('type_asset', $user->type_asset);
                    Session::put('company_data', $user->company);
                    Session::put('user_email', $user->email);
                    Session::put('user_permissions', $permissions->map(function ($permission) {
                        return [
                            'page_id' => $permission->page->id,
                            'page' => $permission->page->URL,
                            'page_name' => $permission->page->name,
                            'pages_category' => $permission->page->pages_category,
                            'icon_data' => $permission->page->icon_data,
                            'isView' => $permission->isView,
                            'isCreate' => $permission->isCreate,
                            'isUpdate' => $permission->isUpdate,
                            'isDelete' => $permission->isDelete,
                            'isProcess' => $permission->isProcess,
                        ];
                    }));
            }else{
                Auth::logout();
                Session::flush();
                return redirect()->route('login')->with('error', 'Session expired or user is inactive. Please log in again.');
            }
        }
        return $next($request);
    }
}
