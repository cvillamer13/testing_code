<?php

namespace App\Http\Controllers\AssetTransfer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetIssuance;
use App\Models\Employee;
use App\Models\AssetIssuanceDetl;
use App\Models\Asset;

class AssetTransferController extends Controller
{
    public function view(){
        try {

            
            return view('AssetTransfer.view', [
               
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function search_issuance(Request $request){
        try {
            //code...
            $asset_issuance = AssetIssuance::with(['getEmployee', 'details', 'assetDetails', 'getLocation'])->find($request->issuance_id);
            return response()->json([
                'status' => 'success',
                'data' => $asset_issuance
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'success',
                'data' => []
            ], 400);
        }
    }

    public function add(){
        try {
            $data_issuance = AssetIssuance::all();
            $employee_data = Employee::with(['gender', 'position', 'company', 'department'])->get();
            // print_r($employee_data);
            // exit;
            return view('AssetTransfer.add', [
                'data_issuance' => $data_issuance,
                'employee_data' => $employee_data
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function store(Request $request){
        try {
            //code...
            $request->validate([
                'issuance_id_show' => 'required',
                'selected_transfer' => 'required'
            ]);

            $data_issuance = AssetIssuance::with(['details'])->find($request->issuance_id_show);
            echo "<pre>";
            // 
            // $asset_data = Asset::where()->first();
            $data_selected = explode("~", $request->selected_transfer);
            foreach ($data_selected as $key => $value) {
                $asset_data = Asset::where('asset_id', $value)->first();
                $issuance_detl = AssetIssuanceDetl::with(['asset_details'])->where('issuance_main_id', $data_issuance->id)->where('asset_id', $asset_data->id)->where('isDelete', false)->orderBy('created_at', 'asc')->first();
                print_r($issuance_detl->asset_details);
                # code...
            }
            echo "<pre>";
            // print_r($data_selected);
            exit;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    
}
