<?php

namespace App\Http\Controllers\AssetReturn;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetReturn;
use App\Models\Employee;
use App\Models\AssetAssigns;
use App\Models\AssetReturnDetl;
use Illuminate\Support\Facades\Mail;
use App\Mail\AssetReturnToChecker;
use Illuminate\Support\Str;
use App\Mail\AssetReturnToRequestor;

class AssetReturnController extends Controller
{
    function view(){
        try {
            $status = AssetReturn::where('is_finalized', '1')->get();
            return view('AssetReturn.view', [
                'status' => $status
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    function view_emplyee(){
        try {
            $status = AssetReturn::where('createdby', session('user_email'))->get();
            return view('AssetReturn.view_emp', [
                'status' => $status
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    function add_emplyee(){
        try {
            // $emp = Employee::all()->orderby('first_name', 'asc');
            $emp = Employee::where('isDelete', '0')->orderBy('first_name', 'asc')->get();
            return view('AssetReturn.add_emp', [
                'emp_data' => $emp,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    function store_employee(Request $request){
        try {
            

            $request->validate([
                'selected_id' => 'required',
                'emp_id' => 'required',
                'date_sep' => 'required',
            ], [
                'selected_id.required' => 'The selected ID is required.',
                'emp_id.required' => 'The employee ID is required.',
                'date_sep.required' => 'The date of separation is required.',
            ]);



            $getassign_asset = AssetAssigns::with(['getAsset_data'])->where('employee_id', $request->selected_id)->where('status', 'TRUE')->get();
            $count = $getassign_asset->count();
            if ($count == 0) {
                return redirect()->back()->with('error', 'No asset assigned to this employee.');
            }
            
            $ref = generateAssetReturnsNumber();
            $asset_main = new AssetReturn();
            $asset_main->emp_id = $request->selected_id;
            $asset_main->separate_date = $request->date_sep;
            $asset_main->ref = $ref;
            $asset_main->createdby = session('user_email');
            $asset_main->created_at = now();
            $asset_main->save();


            foreach ($getassign_asset as $key => $value) {
                if(!empty($value->getAsset_data)){
                    // echo $value->getAsset_data->id . "</br>";
                    $asset_detl = new AssetReturnDetl();
                    $asset_detl->asset_return_id = $asset_main->id;
                    $asset_detl->asset_id = $value->getAsset_data->id;
                    $asset_detl->save();
                }
            }

    


            return redirect('/AssetReturn/view_data_emp/'.$asset_main->id)->with('success', $asset_main->ref . ' Add Successfully');
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    function view_data_emp($id){
        try {
            $status = AssetReturn::with(['employee_data'])->find($id);
            $detl_data = AssetReturnDetl::with(['asset_detls'])->where('asset_return_id', $status->id)->get();
            return view('AssetReturn.view_data_emp', [
                'status' => $status,
                'detl_data' => $detl_data
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }


    function to_finalize(Request $request){
        try {
            $request->validate([
                'id_return_main' => 'required'
            ]);


            $asset_ret = AssetReturn::with(['details', 'employee_data'])->find($request->id_return_main);
            $asset_ret->is_finalized = 1;
            $asset_ret->finalizedby = session('user_email');
            $asset_ret->finalize_at = now();
            $asset_ret->save();
            
            if($asset_ret->is_finalized == 1){
                $email_notif = "christian.villamer@jakagroup.com";
                Mail::to($email_notif)->send(new AssetReturnToChecker($asset_ret->id, $email_notif));
                return response()->json([
                    'status' => 'success',
                    'message' => 'Finalize Successfully'
                ], 200);
            }

            // print_r($asset_ret->details);
            // exit;
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 400);
        }
    }

    function checker_to($id){
        try {
            try {
                $status = AssetReturn::with(['employee_data'])->find($id);
                $detl_data = AssetReturnDetl::with(['asset_detls'])->where('asset_return_id', $status->id)->get();
                return view('AssetReturn.view_data_check', [
                    'status' => $status,
                    'detl_data' => $detl_data
                ]);
            } catch (\Throwable $th) {
                //throw $th;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    function confirmed_req(Request $request){
        try {
            $request->validate([
                'id_return_main' => 'required'
            ]);
            $data = AssetReturn::find($request->id_return_main);
            $data->confirmed_by = session('user_email');
            $data->confirmed_at = now();
            $data->confirmed_uid = Str::uuid();
            $data->status = "A";
            $data->save();

            if($data->status == "A"){
                Mail::to($data->finalizedby)->send(new AssetReturnToRequestor($data->id));
            }

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    function store_detl(Request $request){
        try {
            // print_r($request->all());
            // exit;
            $data_detl = AssetReturnDetl::find($request->id_detl);
            $data_detl->isClear = $request->is_clear == "C" ?  1 : 0;
            $data_detl->is_not_applicable = $request->is_na == "NA" ?  1 : 0;
            $data_detl->remarks = $request->remarks;
            $data_detl->updatedby = session('user_email');
            $data_detl->updated_at = now();
            $data_detl->save();


            return response()->json([
                'status' => 'success',
                'message' => 'saved Successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 400);
        }
    }
}
