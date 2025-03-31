<?php

namespace App\Http\Controllers\Borrowed_Asset;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Location;
use App\Models\Company;
use App\Models\AssetBorrowed;
use App\Models\AssetBorrowedDetl;

class BorrowedAssetController extends Controller
{
    function view(){
        return view('Asset_borrowed.view', [
        ]);
    }

    function add(){
        try {
            $employee = Employee::where('isDelete', 'false')->get();
            // print_r($employee);
            // exit;

            $mis = Location::with(['company', 'department'])->find('2801');
            $to_company = Company::orderBy('name', 'asc')->get();

            return view('Asset_borrowed.add', [
                'employee' => $employee,
                'mis' => $mis,
                'to_company' => $to_company
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    function store(Request $request){
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
            $borrowed->from_location = "2801";
            $borrowed->to_location = $request->to_location;
            $borrowed->ref_rss = $request->rss_num;
            $borrowed->ref_num = $ref;
            $borrowed->deployed_at = $request->date_need;
            $borrowed->requested_by = session('user_email');
            $borrowed->requested_at = $request->date_requested;
            $borrowed->approvers_ref = "3";
            $borrowed->createdby = now();
            $borrowed->save();
            
            return redirect('/BorrowedAsset/for_finalize/'.$borrowed->id)->with('success', 'Borrowed Add Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', 'An error occurred: ' . $th->getMessage());
        }
    }


    function for_finalize($id){
        $data = AssetBorrowed::with(['getEmployee', 'getLocation_from'])->find($id);
        return view('Asset_borrowed.for_finalized', [
            'data' => $data
        ]);
    }

    function store_detl(Request $request){
        try {
            $request->validate([
                'asset_id' => 'required',
                'borrowed_main_id' => 'required',
            ]);
            $store_data = new AssetBorrowedDetl();
            $store_data->asset_id = $request->asset_id;
            $store_data->qty = "1";
            $store_data->comments = $request->comment;
            $store_data->date = $request->date_to_return;
            $store_data->borrowed_main_id = $request->borrowed_id;
            $store_data->createdby = session('user_email');
            $store_data->created_at = now();
            $store_data->save();

            return response()->json([
                'status' => 'success',
                'data' => $store_data,
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
