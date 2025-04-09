<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Department;
use App\Models\Company;
use App\Models\Location_name;

class LocationController extends Controller
{
    public function view()
    {
        $company = Company::all();
        $location = Location::with(['company', 'department', 'location_data'])->get();
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
                // 'descrisption' => 'required',
                'company_id' => 'required',
                'dep_id_edit' => 'required',
            ]);

            // echo "<pre>";
            // print_r($request->all());
            // exit;

            if($request->is_exist_val){
                $location = new Location();
                $location->location_id = $request->name;
                $location->description = $request->description;
                $location->comp_id = $request->company_id;
                $location->department_id = $request->dep_id_edit;
                $location->save();
            }else {
                $location_name = new Location_name();
                $location_name->name = $request->name;
                $location_name->createdby = session('user_email');
                $location_name->created_at = now();
                $location_name->save();

                $location = new Location();
                $location->location_id = $location_name->id;
                $location->comp_id = $request->company_id;
                $location->department_id = $request->dep_id_edit;
                $location->save();
            }
            

            return response()->json([
                'status' => 'success',
                'message' => $location->id . ' Location Add Successfully'
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

    public function getCompany(Request $request)
    {
        $department = Company::all();
        return response()->json($department);
    }


    public function getDepartment(Request $request)
    {
        $company_id = $request->company_id;
        $department = Department::where('company_id', $company_id)->orderBy('name', 'asc')->get();
        return response()->json($department);
    }

    public function getLocation(Request $request){
        $company_id = $request->company_id;
        $department_id = $request->department_id;
        $department = Location::where('comp_id', $company_id)->where('department_id', $department_id)->orderBy('name', 'asc')->get();
        return response()->json($department);
    }


    function getLocation_name(){
        try {
            $location_name = Location_name::all();
            return response()->json($location_name);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }
}
