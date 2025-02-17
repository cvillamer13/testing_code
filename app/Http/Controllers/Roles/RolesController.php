<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Roles;

class RolesController extends Controller
{
    public function view()
    {
        $roles = Roles::all();
        return view('Roles.view', ['roles' => $roles]);
    }

    public function Create_Roles(Request $request)
    {

        try {
            // echo "<pre>";
            // print_r($request->all());
            // exit;
            // return json_encode($request->all())->with('success', 'Role Add Successfully');
            // throw new \Exception("Something went wrong");

            $request->validate([
                'name' => 'required',
                'description' => 'required',
            ]);

            $roles = new Roles();
            $roles->name = $request->input('name');
            $roles->description = $request->input('description');
            $roles->save();
            return response()->json([
                'status' => 'success',
                'message' => $roles->name . ' Role Add Successfully'
            ], 200); 
            // return redirect()->route('roles')->with('success', 'Role Add Successfully');
        } catch (\Throwable $th) {
            // return redirect()->back()->with('error', $th->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400); // HTTP 400 Bad Request
        }
        return view('roles.add');
    }

    public function Edit_Roles(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'description' => 'required',
            ]);

            $roles = Roles::find($id);
            $roles->name = $request->input('name');
            $roles->description = $request->input('description');
            $roles->save();
            return response()->json([
                'status' => 'success',
                'message' => $roles->name . ' Role Updated Successfully'
            ], 200); 
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400); 
        }
    }
}
