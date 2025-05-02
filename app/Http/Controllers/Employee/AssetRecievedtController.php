<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetIssuance;
use App\Models\ApproversStatus;
use App\Models\AssetBorrowed;
use App\Models\Location;
use App\Models\Company;
use App\Models\AssetBorrowedDetl;
use App\Models\Employee;

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

            case 'transmittal':
                
                $borrowed_asset = AssetBorrowed::with(['details', 'getEmployee', 'getLocation_from', 'getLocation_to'])->where('emp_id', session('emp_id'))->get();
                return view('Employee_portal.borrowed_asset', [
                    'borrowed_asset' => $borrowed_asset
                ]);
            break;
            case 'borrowed':
            // code...
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


    public function req_transmittal(){
        // event(new \App\Events\MessageSent('Hello from Laravel!'));
        $mis = Location::with(['company', 'department', 'location_data'])->find('2898');
        $to_company = Company::orderBy('name', 'asc')->get();
        $employee_data = Employee::with(['department', 'position'])->find(session('emp_id'));
        return view('Employee_portal.add_trans', [
            'employee_data' => $employee_data,
            'mis' => $mis,
            'to_company' => $to_company,
        ]);
    }


    public function req_trans_save(Request $request){
        try {
            // echo "<pre>";
            // print_r($request->all());
            // exit;

            $request->validate([
                'emp_no' => 'required',
                'to_location' => 'required',

            ]);
            $ref = generate_asset_borrowed_ref();
            $borrowed = new AssetBorrowed();
            $borrowed->emp_id = $request->emp_no;
            $borrowed->from_location = "2898";
            $borrowed->to_location = $request->to_location;
            $borrowed->ref_rss = $request->rss_num;
            $borrowed->ref_num = $ref;
            $borrowed->deployed_at = $request->date_need;
            $borrowed->requested_by = session('user_email');
            $borrowed->requested_at = $request->date_requested;
            $borrowed->approvers_ref = "3";
            $borrowed->createdby = now();
            $borrowed->save();

            return redirect('/employee/BorrowedAsset/for_finalize/'.$borrowed->id)->with('success', 'Borrowed Add Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', 'An error occurred: ' . $th->getMessage());
        }
        
    }
}
