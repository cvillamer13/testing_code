<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetScanned;
use App\Models\Asset;
use Carbon\Carbon;
use App\Models\AssetCountPlot;
use App\Models\AssetCount;


use Exception;

class AssetAssignScannedController extends Controller
{


    public function view()
    {
        // $permissions = checkingpages();
        // if($permissions->isView){
            // $asset_data = Asset::with(['unit_data', 'category_data', 'supplier_data', 'employee_data', 'asset_status_data', 'company_data', 'department_data', 'location_data'])->where('isDelete',false)->where('type_of_asset', session('type_asset'))->get();
            // $asset_scanned_data = AssetScanned::with('getAsset')->all();
            // $asset_scanned_data = AssetScanned::with('getAsset')->where('type_of_asset', session('type_asset'))->get();
            // $asset_scanned_data = AssetScanned::with('getAsset')
            //     ->whereHas('getAsset', function ($query) {
            //         $query->where('type_of_asset', session('type_asset'));
            //     })
            //     ->orderBy('scanned_date', 'desc')
            //     ->limit(10) 
            //     ->get();

            
            // echo "<pre>";
            // print_r($asset_scanned_data->all()[0]->scanned_date);
            // exit;


            $asset_scanned_data = AssetCount::with(['location_show', 'asset_count_plot'])->where('is_finalized', 0)->get();
            return view('AssetScanned.view', [
                'asset_scanned' => $asset_scanned_data,
                
            ]);
        // }else {
        //     return redirect('/dashboard')->with('error', 'Sorry you dont have right on this module.');
        // }
        
    }

    public function add(){
        try {

            $company = Company::all();
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
    }


    public function getScanned(Request $request){
        try {
            $request->validate([
                'asset_id' => 'required',
            ]);

            $asset_data = Asset::with(['unit_data', 'category_data', 'supplier_data', 'employee_data', 'asset_status_data', 'company_data', 'department_data', 'location_data'])->where('asset_id', $request->asset_id)->first();
            if(is_null($asset_data)){
                throw new Exception("No data found!");
            }
            return response()->json([
                'status' => 'success',
                'data' => $asset_data,
                
            ], 200);
        } catch (Exception $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }


    public function scanned_data(Request $request){
            try {
                $request->validate([
                    'asset_id' => 'required',
                ]);


                $today = Carbon::today()->toDateString(); // '2025-02-28'
                $now = Carbon::now()->format('H:i:s');
                // echo $today;
                $asset_scanned_data = AssetScanned::where('scanned_date', $today)->where('asset_id',$request->asset_id)->get();

                if(count($asset_scanned_data) > 0){
                    return response()->json([
                        'status' => 'info',
                        'message' => 'Scanned Date : <b>'. $asset_scanned_data[0]->scanned_date.'</b><br> Scanned Time : <b>'. $asset_scanned_data[0]->scanned_time .'</b><br>Scanned By : <b>'.$asset_scanned_data[0]->updatedby.'</b>' ,
                        'titled' => "Already Scanned!",
                    ], 400);
                } else {
                    $asset_detl = new AssetScanned();
                    $asset_detl->scanned_date = $today;
                    $asset_detl->scanned_time = $now;
                    $asset_detl->asset_id = $request->asset_id;
                    $asset_detl->createdby = session('user_email');
                    $asset_detl->updatedby = session('user_email');
                    $asset_detl->created_at = $today . " " . $now;
                    $asset_detl->updated_at = $today . " " . $now;
                    $asset_detl->save();

                    return response()->json([
                        'status' => 'success',
                        'message' => $asset_detl
                    ], 200);
                }
                
    
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => 'error',
                    'message' => $th->getMessage()
                ], 400);
            }
    }


    public function prepared_scanned($id){
        try {
            //code...
            $data_asset = AssetCountPlot::with(['asset'])->where('asset_count_id', $id)->get();


            return view('AssetScanned.show_to_scanned', [
                'asset_scanned' => $data_asset,
                
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }



    public function getScanned_new(Request $request){
        try {
            //code...
            $request->validate([
                'asset_id' => 'required',
            ]);
            // $get_asset = Asset::with(['unit_data', 'category_data', 'supplier_data', 'employee_data', 'asset_status_data', 'company_data', 'department_data', 'location_data'])->where('asset_id', $request->asset_id)->first();
            AssetCountPlot::where('asset_id', $request->asset_id)->update([
                'isScanned' => 1,
                'scannedby' => session('user_email'),
                'scanned_at' => Carbon::now(),
                'updatedby' => session('user_email'),
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Scanned Successfully!'
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
