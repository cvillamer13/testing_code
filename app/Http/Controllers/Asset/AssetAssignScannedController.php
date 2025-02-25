<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User_pages_permission;
use App\Models\AssetScanned;

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


    public function getALLScanned(Request $request){
        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
