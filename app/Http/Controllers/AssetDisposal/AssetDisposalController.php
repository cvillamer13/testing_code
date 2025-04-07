<?php

namespace App\Http\Controllers\AssetDisposal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetDisposal;
use App\Models\Asset;
use App\Models\Employee;
use App\Models\AssetDisposalDetl;
use App\Models\ApproversStatus;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Writer\ValidationException;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\AssetDsiposalApproved;
use App\Models\ApproversMatrix;

class AssetDisposalController extends Controller
{
    function view()
    {
        $data = AssetDisposal::with(['details', 'transmitted_emp'])->get();
        return view('Asset_disposal.view',
            [
                'data' => $data,
            ]);
    }

    function add()
    {
        $employees = Employee::with(['gender', 'position', 'company', 'department'])->where('isDelete', 0)->get();
        return view('Asset_disposal.add',
            [
                'employees' => $employees,
            ]);
    }

    function pre_store(Request $request){
        try {

            $request->validate([
                'emp_no' => 'required',
            ]);
            $ref = generateAssetDisposalNumber();
            $data = new AssetDisposal();
            $data->trans_emp_id = $request->emp_no;
            $data->date = date('Y-m-d');
            $data->apprver_references = "3";
            $data->createdby = session('user_email');
            $data->created_at = now();
            $data->ref_num = $ref;
            $data->save();
            return redirect('/AssetDisposal/select_asset/'.$data->id)->with('success', $data->ref_num . ' Add Asset Dsiposal Successfully');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    function select_asset($id){
        try {
            $data = AssetDisposal::with(['details', 'transmitted_emp'])->find($id);
            $disposal_status = ApproversStatus::with(['user'])->where('data_id', $id)->where('pages_id', 12)->get();
            return view('Asset_disposal.select_asset',
                [
                    'data' => $data,
                    'disposal_status' => $disposal_status,
                ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    function select_asset_approvers($id, $status, $pages_id, $user_id){
        try {
            $data = AssetDisposal::with(['details', 'transmitted_emp'])->find($id);
            $disposal_status = ApproversStatus::with(['user'])->where('data_id', $id)->where('pages_id', 12)->get();
            return view('Asset_disposal.select_asset_approvers',
                [
                    'data' => $data,
                    'disposal_status' => $disposal_status,
                    'status' => $status,
                    'pages_id' => $pages_id,
                    'user_id' => $user_id
                ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    

    function pre_store_detl(Request $request){
        try {
            $request->validate([
                'asset_id' => 'required',
                'asset_disposal_id' => 'required',
            ]);
            $data = new AssetDisposalDetl();
            $data->asset_disposal_main_id = $request->asset_disposal_id;
            $data->asset_id = $request->asset_id;
            $data->createdby = session('user_email');
            $data->created_at = now();
            $data->save();
            return response()->json([
                'status' => 'success',
                'data' => $data,
                'message' => 'saving.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }

    function data_selected_asset(Request $request){
        try {
            $request->validate([
                'detl_id' => 'required',
            ]);
            $data = AssetDisposalDetl::with(['asset_details'])->find($request->detl_id);
            return response()->json([
                'status' => 'success',
                'data' => $data,
                'message' => 'saving.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }

    function save_selected_asset(Request $request){
        try {
            $request->validate([
                'detl_id' => 'required',
            ]);
            
            $data = AssetDisposalDetl::find($request->detl_id);
            $data->remarks = $request->text;
            $data->qty = $request->qty;
            $data->unit = $request->unit;
            $data->updatedby = session('user_email');
            $data->updated_at = now();
            $data->save();
            return response()->json([
                'status' => 'success',
                'data' => $data,
                'message' => 'saving.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }


    function finalized(Request $request){
        try {
            $request->validate([
                'asset_disposal_id' => "required"
            ]);
            $other_detl = AssetDisposal::find($request->asset_disposal_id);
            $other_detl->is_finalized = "1";
            $other_detl->finalizedby = session('user_email');
            $other_detl->finalize_at = now();
            $other_detl->save();
            if ($other_detl->is_finalized) {
                $f_approver = approvalAssetDisposalAsset($other_detl->id, 3, 12, $other_detl->approved_status);
                return response()->json([
                    'status' => 'success',
                    'message' => $other_detl->ref_num . ' Finalized! ' . $f_approver . " Notified."
                ], 200);
            }
            
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }

    function to_approvers(Request $request){
        try {
            //code...
            
            $asset_issuance = AssetDisposal::find($request->asset_iss_id);
            // echo "<pre>";
            // print_r($asset_issuance);
            // exit;
            if ($request->status == "A") {
                $approval = ApproversStatus::find($request->appr_id);
                $approval->status = $request->status;
                $approval->uid = Str::uuid(); //generate uuid
                $approval->save();

                $approver = approvalAssetDisposalAsset($asset_issuance->id, 3, 12, $asset_issuance->status);
                $data_of_approvers = ApproversMatrix::where('user_id', $approval->user_id)->where('type_of_process', 3)->first();

                if($data_of_approvers->increment_num == "FA"){
                    $asset_issuance->approved_status = "A";
                    $asset_issuance->status = "A";
                    $asset_issuance->approved_by = session('user_email');
                    $asset_issuance->approved_at = now();
                    $asset_issuance->approved_uid = $approval->uid;
                    $asset_issuance->save();
                    $transmittedto = AssetDisposal::with(['transmitted_emp'])->find($request->asset_iss_id);
                    // Mail::to($transmittedto->transmitted_emp->email)->send(new AssetDsiposalApproved($asset_issuance->id, $transmittedto->transmitted_emp->id));
                    Mail::to('christian.villamer@jakagroup.com')->send(new AssetDsiposalApproved($asset_issuance->id, 12, $transmittedto->transmitted_emp->id));
                    
                    // print_r($asset_issuance);
                    // exit;
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Asset Disposal Approved Successfully the assigned person will be notified.',
                    ], 200);
                }

                return response()->json([
                    'status' => 'success',
                    'message' =>  $approver . ' Send to Approver Successfully'
                ], 200);
            
            }else if($request->status == "R"){
                $approval = ApproversStatus::find($request->appr_id);
                $approval->status = $request->status;
                $approval->uid = Str::uuid(); //generate uuid
                $approval->save();

                if($approval->status == "R"){
                    $approval_2 = ApproversStatus::find($request->appr_id);
                    $data_of_approvers = ApproversMatrix::where('user_id', $approval_2->user_id)->where('type_of_process', 3)->first();
                    
                    // Mail::to($asset_issuance->issued_by)->send(new Revisedissuance_Notif($asset_issuance->id));
                        if($data_of_approvers->increment_num == "FA"){
                            $approval = ApproversStatus::find($request->appr_id);
                            $approval->status = $request->status;
                            $approval->remarks = $request->reason_data;
                            $approval->uid = Str::uuid();
                            $approval->save();
                            Mail::to($asset_issuance->requested_by)->send(new RevisedBorrowed($asset_issuance->id, $approval->id));
                            $approval3 = ApproversStatus::where('data_id', $asset_issuance->id)
                                ->where('pages_id', session('current_page'))
                                ->where('status', 'NA')
                                ->update([
                                    'status' => 'CNA',
                                    'uid' => Str::uuid()->toString() . "-CNA"
                                ]);

                            $asset_issuance->approved_status = "RE";
                            $asset_issuance->is_finalized = 0;
                            $asset_issuance->approved_by = session('user_email');
                            $asset_issuance->approved_at = now();
                            $asset_issuance->uid = $approval->uid;
                            $asset_issuance->save();
                        }else{
                            $approval = ApproversStatus::find($request->appr_id);
                            $approval->status = $request->status;
                            $approval->remarks = $request->reason_data;
                            $approval->uid = Str::uuid();
                            $approval->save();
                            Mail::to($asset_issuance->requested_by)->send(new RevisedBorrowed($asset_issuance->id, $approval->id));
                            $approval3 = ApproversStatus::where('data_id', $asset_issuance->id)
                                ->where('pages_id', 11)
                                ->where('status', 'NA')
                                ->update([
                                    'status' => 'CNA',
                                    'uid' => Str::uuid()->toString() . "-CNA"
                                ]);

                            
                                $asset_issuance->approved_status = "RE";
                                $asset_issuance->is_finalized = 0;
                                $asset_issuance->approved_by = session('user_email');
                                $asset_issuance->approved_at = now();
                                $asset_issuance->uid = $approval->uid;
                                $asset_issuance->save();
                        }

                }
                
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Send to Approver Successfully'
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


    function recieved_by($id, $status, $emp_id){
        try {
            $data = AssetDisposal::with(['details', 'transmitted_emp', 'recieved_by'])->find($id);
            $disposal_status = ApproversStatus::with(['user'])->where('data_id', $id)->where('pages_id', 12)->get();
            return view('Asset_disposal.reciever.select_asset',
                [
                    'data' => $data,
                    'disposal_status' => $disposal_status,
                    'emp_id' => $emp_id
                ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    function recieved_final(Request $request){
        try {
            $request->validate([
                'asset_disposal_id' => 'required',
                'emp_id' => 'required'
            ]);

            $data = AssetDisposal::find($request->asset_disposal_id);
            $data->recieved_emp = $request->emp_id;
            $data->is_recieved = "1";
            $data->recieved_at = now();
            $data->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Asset Disposal Recieved Successfully.',
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


    function generate_report($id){
        try {
            $data = AssetDisposal::with(['details', 'transmitted_emp', 'recieved_by'])->find($id);
            $disposal_status = ApproversStatus::with(['user'])->where('data_id', $id)->where('pages_id', 12)->get();
            $pdf = Pdf::loadView('Asset_disposal.report', [
                'data' => $data,
                'disposal_status' => $disposal_status,
            ]);
            // return $pdf->stream('Asset_Disposal_Report.pdf');
            return $pdf->setPaper('A3', 'portrait')->stream(); 

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
