<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User_pages_permission;
use App\Models\AssetScanned;
use App\Models\Asset;
use Carbon\Carbon;
use Exception;

class AssetAssignScannedController extends Controller
{
    public function checkingpages(){
        $role_id = session('role_id');
        $current_page = session('current_page');

        $permissions = User_pages_permission::where('pages_id', $role_id)
                                                ->where('roles_id', $role_id)
                                                ->first();
            
        return $permissions; 
    }


    public function view()
    {
        $permissions = $this->checkingpages();
        if($permissions->isView){
            // $asset_data = Asset::with(['unit_data', 'category_data', 'supplier_data', 'employee_data', 'asset_status_data', 'company_data', 'department_data', 'location_data'])->where('isDelete',false)->where('type_of_asset', session('type_asset'))->get();
            // $asset_scanned_data = AssetScanned::with('getAsset')->all();
            // $asset_scanned_data = AssetScanned::with('getAsset')->where('type_of_asset', session('type_asset'))->get();
            $asset_scanned_data = AssetScanned::with('getAsset')
                ->whereHas('getAsset', function ($query) {
                    $query->where('type_of_asset', session('type_asset'));
                })
                ->orderBy('scanned_date', 'desc')
                ->limit(10) 
                ->get();

            
            // echo "<pre>";
            // print_r($asset_scanned_data->all()[0]->scanned_date);
            // exit;
            return view('AssetScanned.view', [
                'asset_scanned' => $asset_scanned_data,
                
            ]);
        }else {
            return redirect('/dashboard')->with('error', 'Sorry you dont have right on this module.');
        }
        
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
                        'status' => 'error',
                        'message' => "Already Scanned"
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
}
