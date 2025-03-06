<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetAssigns;
use App\Models\AssetIssuance;
use App\Models\AssetIssuanceDetl;
use App\Models\Employee;
use App\Models\Asset;

class AssetAssignController extends Controller
{
    public function getAssign(Request $request){
        try {
            $assign_data = AssetAssigns::with(['getAsset_data', 'getEmployee'])->where('employee_id', $request->id_emp)->get();
            return response()->json([
                'status' => 'success',
                'data' => $assign_data,
                'message' => 'Find Data'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }


    public function getEmployeeAssign(Request $request){
        try {
            $assign_data = AssetAssigns::with(['getAsset_data', 'getEmployee'])->where('asset_id', $request->id_asset)->get();
            return response()->json([
                'status' => 'success',
                'data' => $assign_data,
                'message' => 'Find Data'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }


    public function view()
    {
        $permissions = checkingpages();
        if($permissions->isView){
            // $asset_data = Asset::with(['unit_data', 'category_data', 'supplier_data', 'employee_data', 'asset_status_data', 'company_data', 'department_data', 'location_data'])->where('isDelete',false)->where('type_of_asset', session('type_asset'))->get();
            $asset_issuance = AssetIssuance::where('createdby', session('user_email'))->get();
            return view('AssetAssign.view', [
                'asset_issuance' => $asset_issuance,
            ]);
        }else {
            return redirect('/dashboard')->with('error', 'Sorry you dont have right on this module.');
        }
        
    }


    public function add()
    {
        $permissions = checkingpages();
        if($permissions->isCreate){

            // $ref = generateRefNumber();
            $employee = Employee::all();
            return view('AssetAssign.add', [
                'employee' => $employee
            ]);
        }else {
            return redirect('/dashboard')->with('error', 'Sorry you dont have right on this module.');
        }
        
    }


    public function store(Request $request){
        try {

            $permissions = checkingpages();
            if($permissions->isUpdate){
                // echo "<pre>";
                // print_r($request->all());
                // exit;
                $request->validate([
                    'emp_id' => 'required',
                    'reports_to' => 'required',
                ]);

                $ref = generateRefNumber();
                $asset_main = new AssetIssuance();
                $asset_main->emp_id = $request->emp_no;
                $asset_main->reports_to = $request->reports_to;
                $asset_main->deployment_type = $request->deployment_type;
                $asset_main->deployment_duration_from = $request->duration_from;
                $asset_main->deployment_duration_to = $request->duration_to;
                $asset_main->date_requested = $request->date_requested;
                $asset_main->date_needed = $request->date_need;
                $asset_main->issued_by = session('user_email');
                $asset_main->apprver_references = 3;
                $asset_main->ref_rss = $request->rss_num;
                $asset_main->rev_num = $ref;
                $asset_main->createdby = session('user_email');
                $asset_main->created_at = now();
                $asset_main->save();
                return redirect('/AssetAssign/detl/'.$asset_main->id)->with('success', $asset_main->rev_num.' Add Successfully');
            }else{
                return redirect('/dashboard')->with('error', 'Sorry you dont have right on this module.');
            }
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }


    public function add_detl($id){
        try {
            //code...
            $permissions = checkingpages();
            if($permissions->isUpdate){
                $asset_issuance = AssetIssuance::find($id);
                $employee_data = Employee::with(['gender', 'position', 'company', 'department'])->find($asset_issuance->emp_id);
                $issuance_detl = AssetIssuanceDetl::with(['asset_details'])->where('issuance_main_id', $id)->get();
                // echo "<pre>";
                // print_r($issuance_detl);
                // exit;
            return view('AssetAssign.view_detl', [
                'asset_issuance' => $asset_issuance,
                'employee_data' => $employee_data,
                'issuance_detl' => $issuance_detl
            ]);
            }else{
                return redirect('/dashboard')->with('error', 'Sorry you dont have right on this module.');
            }
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }



    public function getAsset(Request $request){
        try {
            //code...  $asset_data = Asset::with(['unit_data', 'category_data', 'supplier_data', 'employee_data', 'asset_status_data', 'company_data', 'department_data', 'location_data'])->where('isDelete',false)->where('type_of_asset', session('type_asset'))->get();
            $asset_data = Asset::with(['unit_data', 'category_data', 'supplier_data', 'employee_data', 'asset_status_data', 'company_data', 'department_data', 'location_data'])->where('asset_id',$request->asset_id)->first();
            return response()->json([
                'status' => 'success',
                'data' => $asset_data,
                'message' => 'Find Data'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }

    public function getAssetid(Request $request){
        try {
            //code...  $asset_data = Asset::with(['unit_data', 'category_data', 'supplier_data', 'employee_data', 'asset_status_data', 'company_data', 'department_data', 'location_data'])->where('isDelete',false)->where('type_of_asset', session('type_asset'))->get();
            $asset_data = Asset::with(['unit_data', 'category_data', 'supplier_data', 'employee_data', 'asset_status_data', 'company_data', 'department_data', 'location_data'])->find($request->asset_iddata);
            return response()->json([
                'status' => 'success',
                'data' => $asset_data,
                'message' => 'Find Data'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }

    public function store_detl(Request $request, $id){
        try {
            //code...
            $asset_issuance_detl  = new AssetIssuanceDetl();
            $asset_issuance_detl->issuance_main_id = $id;
            $asset_issuance_detl->asset_id = $request->asset_id;
            $asset_issuance_detl->createdby = session('user_email');
            $asset_issuance_detl->created_at = now();
            $asset_issuance_detl->save();
            

            return response()->json([
                'status' => 'success',
                'data' => $asset_issuance_detl,
                'message' => 'saving.'
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }
}
