<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function view()
    {
        $company = Company::all();
        $department = Department::all();
        return view('Department.view', [
            'company' => $company,
            'department' => $department,
        ]);
    }


    public function Add_Department(Request $request)
    {

        try {
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'company_id' => 'required',
            ]);
    
            $department = new Department();
            $department->name = $request->name;
            $department->description = $request->description;
            $department->company_id = $request->company_id;
            $department->save();
    
            return response()->json([
                'status' => 'success',
                'message' => $department->name . ' Department Add Successfully'
            ], 200); 
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }

    public function Edit_Department(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'company_id' => 'required',
            ]);

            $department = Department::find($id);
            $department->name = $request->name;
            $department->description = $request->description;
            $department->company_id = $request->company_id;
            $department->save();

            return response()->json([
                'status' => 'success',
                'message' => $department->name . ' Department Updated Successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }
}
