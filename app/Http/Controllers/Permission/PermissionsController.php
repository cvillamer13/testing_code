<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Roles;
use App\Models\User_pages_permission;
use App\Models\Pages;

class PermissionsController extends Controller
{
    public function view()
    {
        $roles = Roles::all();
        return view('Permissions.view', ['roles' => $roles]);
    }

    public function Edit_View(Request $request, $id)
    {
        $roles = Roles::find($id);
        $permissions = User_pages_permission::where('roles_id', $id)->get();
        
        // $pages = Pages::all();
        // $pages = Pages::all()->sortBy('page_code')->groupBy('page_category');
        $pages = Pages::with('page_category_data')->get()->sortBy('page_code')->groupBy('page_category');

        // echo "<pre>";
        // print_r($pages[0]->page_category_data);
        // exit;
        // return $permissions;
        return view('Permissions.edit', ['roles' => $roles, 'permissions' => $permissions, 'pages' => $pages]);
    }


    public function Edit_saved(Request $request, $id)
    {
        // Validate the request (optional but recommended)
        $request->validate([
            'permissions' => 'array',
        ]);

        // Get submitted permissions
        $permissions = $request->input('permissions', []);

        // Delete existing permissions for the role to avoid duplicates
        User_pages_permission::where('roles_id', $id)->delete();
        
        // Loop through submitted permissions and save them
        foreach ($permissions as $page_id => $permission) {
            User_pages_permission::create([
                'roles_id'  => $id,
                'pages_id'  => $page_id,
                'isView'    => isset($permission['view']) ? 1 : 0,
                'isCreate'  => isset($permission['create']) ? 1 : 0,
                'isUpdate'  => isset($permission['update']) ? 1 : 0,
                'isDelete'  => isset($permission['delete']) ? 1 : 0,
                'isProcess' => isset($permission['process']) ? 1 : 0,
            ]);
        }

        return redirect()->back()->with('success', 'Permissions updated successfully!');
    }

}
