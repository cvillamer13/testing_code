<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetIssuance;
use App\Models\ApproversStatus;

class AssetRecievedtController extends Controller
{
    public function asset_recieved(Request $request, $type_process)
    {
        switch ($type_process) {
            case 'issuance':

                $asset_issuance = AssetIssuance::with(['details', 'assetDetails', 'getEmployee', 'getLocation'])->where('emp_id', session('emp_id'))->where('approved_status', 'A')->get();
                return view('Employee_portal.asset_recieved', [
                    'asset_issuance' => $asset_issuance
                ]);

                break;
            
            default:
                # code...
                break;
        }
        
    }


    public function to_recieved_emp($id){
        $asset_issuance = AssetIssuance::with(['details', 'getEmployee'])->find($id);
        $issuance_status = ApproversStatus::with(['user'])->where('data_id', $asset_issuance->id)->where('pages_id', 8)->get();
        // print_r( $issuance_status);
        // exit;
        return view('Employee_portal.asset_issuance_recieved', [
            'asset_issuance' => $asset_issuance,
            'employee_data' => $asset_issuance->getEmployee,
            'issuance_detl' => $asset_issuance->details,
            'issuance_status' => $issuance_status,
        ]);
    }
}
