<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Roles;
use App\Models\Company;

class UserController extends Controller
{
    public function view()
    {
        // $users = User::all();
        $users = User::with('role')->get();
        return view('Users.view', [
            'users' => $users,
        ]);
    }


    public function create()
    {
        $roles = Roles::all();
        $company = Company::all();
        return view('Users.add', [
            'roles' => $roles,
            'company' => $company,
        ]);
    }


    function create_user(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());
        // exit;
        

        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'pass_data' => 'required',
                'roles' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
    
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = bcrypt($request->input('pass_data'));
            $user->roles_id = $request->input('roles');
            $user->active_status = $request->input('active_status');
            $selectedItems = implode('~', $request->company);
            $user->company = $selectedItems;
            $user->type_asset = $request->type_of_asset;
            if ($request->pass_adta) {
                $user->password = bcrypt($request->input('pass_data'));
            }
            
            $user->save();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = $image->getClientOriginalName();
                $path = "public/{$imageName}";
                $image->storeAs("public/", $imageName);
                $user->image_path = "{$imageName}";
            }
            $user->save();
    
            return redirect()->route('users')->with('success', 'User created successfully');
        } catch (\Exception $e) {

            // return $e->getMessage();
            return redirect()->back()->with('error', $e->getMessage());
        }
        
    }


    public function edit_view($id)
    {
        $user = User::find($id);
        $roles = Roles::all();
        $company = Company::all();
        return view('Users.edit', [
            'user' => $user,
            'roles' => $roles,
            'company' => $company,
        ]);
    }


    public function Edit_User(Request $request, $id){
        try {
            // echo "<pre>";

            // 
            // print_r($request->type_of_asset); 
            // exit;
            $request->validate([
                'name_edit' => 'required',
                'email_edit' => 'required',
                'roles' => 'required',
                'active_status' => 'required',
                // 'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $selectedItems = implode('~', $request->company);
            $user = User::find($id);
            $user->name = $request->input('name_edit');
            $user->email = $request->input('email_edit');
            $user->roles_id = $request->input('roles');
            $user->active_status = $request->input('active_status');
            $user->company = $selectedItems;
            $user->type_asset = $request->type_of_asset;
            if ($request->input('pass_adta')) {
                $user->password = bcrypt($request->input('pass_data'));
            }
            // if (request('image')) {
            //     $image = request('image');
            //     $imageName = $image->getClientOriginalName();
            //     $path = "public/{$user->id}/{$imageName}";
            //     $image->storeAs("public/{$user->id}", $imageName);
            //     $user->image_path = "{$user->id}/{$imageName}";
            // }
            $user->save();
    
            return redirect()->route('users')->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
