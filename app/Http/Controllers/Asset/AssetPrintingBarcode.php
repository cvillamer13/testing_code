<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User_pages_permission;
use App\Models\Asset;
use App\Models\Company;
class AssetPrintingBarcode extends Controller
{

    public function checkingpages(){
        $role_id = session('role_id');
        $current_page = session('current_page');
        $permissions = User_pages_permission::where('pages_id', $role_id)->where('roles_id', $role_id)->first();
        return $permissions; 
    }


    public function view(){
        $permissions = $this->checkingpages();
        if($permissions->isView){
            $asset_data = Asset::with(['unit_data', 'category_data', 'supplier_data', 'employee_data', 'asset_status_data', 'company_data', 'department_data', 'location_data'])->where('isDelete',false)->where('type_of_asset', session('type_asset'))->get();
            $company_data = Company::orderBy('name', 'asc')->get();
            return view('AssetPrint.view', [
                'asset' => $asset_data,
                'company' => $company_data
            ]);
        }else{
            return redirect('/dashboard')->with('error', 'Sorry you dont have right on this module.');
        }
    }


    public function getFilter(Request $request){
        try {
            $company_data = $request->company_id;
            $department_data = $request->department_id;
            $location_data = $request->location_id;
            if ($company_data == "all") {
                $asset_data = Asset::with(['unit_data', 'category_data', 'supplier_data', 'employee_data', 'asset_status_data', 'company_data', 'department_data', 'location_data'])->where('isDelete',false)->where('type_of_asset', session('type_asset'))->get();
            }else{
                if ($department_data == "all") {
                    $asset_data = Asset::with(['unit_data', 'category_data', 'supplier_data', 'employee_data', 'asset_status_data', 'company_data', 'department_data', 'location_data'])->where('isDelete',false)->where('type_of_asset', session('type_asset'))->where('company_id',$company_data)->get();
                }else{
                    if ($location_data == "all") {
                        $asset_data = Asset::with(['unit_data', 'category_data', 'supplier_data', 'employee_data', 'asset_status_data', 'company_data', 'department_data', 'location_data'])->where('isDelete',false)->where('type_of_asset', session('type_asset'))->where('company_id',$company_data)->where('department_id',$department_data)->get();
                    }else{
                        $asset_data = Asset::with(['unit_data', 'category_data', 'supplier_data', 'employee_data', 'asset_status_data', 'company_data', 'department_data', 'location_data'])->where('isDelete',false)->where('type_of_asset', session('type_asset'))->where('company_id',$company_data)->where('department_id',$department_data)->where('location_id',$location_data)->get();
                    }
                    
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => $asset_data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }
}
