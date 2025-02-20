<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Department;
use App\Models\Company;

class LocationController extends Controller
{
    public function view()
    {
        $company = Company::all();
        $location = Location::all();
        return view('Location.view', [
            'company' => $company,
            'location' => $location,
        ]);
    }

    public function Add_Location(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'company_id' => 'required',
                'dep_id_edit' => 'required',
            ]);

            $location = new Location();
            $location->name = $request->name;
            $location->description = $request->description;
            $location->comp_id = $request->company_id;
            $location->department_id = $request->dep_id_edit;
            $location->save();

            return response()->json([
                'status' => 'success',
                'message' => $location->name . ' Location Add Successfully'
            ], 200); 
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }

    public function Edit_Location(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'company_id' => 'required',
                'dep_id_edit' => 'required',
            ]);

            $location = Location::find($id);
            $location->name = $request->name;
            $location->description = $request->description;
            $location->comp_id = $request->company_id;
            $location->department_id = $request->dep_id_edit;
            $location->save();

            return response()->json([
                'status' => 'success',
                'message' => $location->name . ' Location Updated Successfully'
            ], 200); 
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }


    public function getDepartment(Request $request)
    {
        $company_id = $request->company_id;
        $department = Department::where('company_id', $company_id)->get();
        return response()->json($department);
    }

    public function getLocation(Request $request){
        $company_id = $request->company_id;
        $department_id = $request->department_id;
        $department = Location::where('comp_id', $company_id)->where('department_id', $department_id)->get();
        return response()->json($department);
    }
}
