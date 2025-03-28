<?php

namespace App\Http\Controllers\AssetTransfer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetIssuance;
use App\Models\Employee;
use App\Models\AssetIssuanceDetl;
use App\Models\Asset;
use App\Models\AssetTransfer;
use App\Models\AssetTransferDetl;
use Illuminate\Support\Facades\Auth;
use App\Models\ApproversStatus;
use Illuminate\Support\Str;
use App\Mail\ApprovedTransferIssuance;
use Illuminate\Support\Facades\Mail;
use App\Models\ApproversMatrix;

class AssetTransferController extends Controller
{
    public function view(){
        try {

            $data = AssetTransfer::all();
            return view('AssetTransfer.view', [
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'success',
                'data' => $th->getMessage()
            ], 400);
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
            return response()->json([
                'status' => 'success',
                'data' => $th->getMessage()
            ], 400);
        }
    }

    public function store(Request $request){
        try {
            //code...
            $request->validate([
                'issuance_id_show' => 'required',
                'selected_transfer' => 'required'
            ]);
            // echo "<pre>";
            // print_r($request->all());
            // exit;

            $data_issuance = AssetIssuance::with(['details'])->find($request->issuance_id_show);
            $trf_save = new AssetTransfer();
            $trf_save->emp_id = $request->from_employee_id;
            $trf_save->from_issuance = $request->from_issuance_no;
            $trf_save->from_assign = $request->from_employee_id;
            $trf_save->to_assign = $request->to_emp_id;
            $trf_save->date_requested = $request->date_requested;
            $trf_save->date_needed = $request->date_need;
            $trf_save->duration_from = $request->duration_from;
            $trf_save->duration_to = $request->duration_to;
            $trf_save->deployment_type = $request->deployment_type;
            $trf_save->location_id = $request->location_id;
            $trf_save->report_to = $request->report_to;
            $trf_save->status = "P";
            $trf_save->approved_status = "P";
            $trf_save->ref_rss = $request->rev_rss;
            $trf_save->requested_by = session('user_email');
            $trf_save->apprver_references = 3;
            $trf_save->save();

            
            $data_selected = explode("~", $request->selected_transfer);
            foreach ($data_selected as $key => $value) {
                $asset_data = Asset::where('asset_id', $value)->first();
                $issuance_detl = AssetIssuanceDetl::with(['asset_details'])->where('issuance_main_id', $data_issuance->id)->where('asset_id', $asset_data->id)->where('isDelete', false)->orderBy('created_at', 'asc')->first();
                $issuance_detl->issuance_no_transfer = $trf_save->id;
                $issuance_detl->status = "TRF";
                $issuance_detl->save();

                $tranfer_detl = new  AssetTransferDetl();
                $tranfer_detl->asset_transfer_main_id = $trf_save->id;
                $tranfer_detl->asset_id = $asset_data->id;
                $tranfer_detl->save();
                
            }

            return redirect('/AssetTransfer/finalize/'.$trf_save->id)->with('success', 'Transfer Add Successfully');

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function to_finalize_view($id){
        try {
            //code...
            $data_view = AssetTransfer::with(['details', 'assetDetails', 'getLocation_to'])->find($id);
            $issuance_status = ApproversStatus::with(['user'])->where('data_id', $data_view->id)->where('pages_id', 10)->get();
            // echo "<pre>";
            // print_r($data_view->assetDetails[0]->category_data);
            // exit;
            return view('AssetTransfer.view_detl', [
                'data_view' => $data_view,
                'issuance_status' => $issuance_status
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }


    public function to_finalize(Request $request){
        try {
            $request->validate([
                'transfer_id' => 'required'
            ]);

            $data = AssetTransfer::find($request->transfer_id);
            $data->is_finalized = 1;
            $data->finalizedby = session('user_email');
            // $data->is_finalized = 1;
            $data->finalize_at = now();
            $data->save();

            $approver = approvalAssetTransfer($request->transfer_id, 3, 10, "P");


            // echo "<pre>";
            // print_r($request->transfer_id);
            // exit;
            return response()->json([
                'status' => 'success',
                'message' => 'Finalize Successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'success',
                'data' => $th->getMessage()
            ], 400);
        }
    }


    public function for_approved($transfer_id, $status, $page_id, $user_id){
        try {
            // if(Auth::user()->id == $user_id){
                $data_view = AssetTransfer::with(['details', 'assetDetails'])->find($transfer_id);
                $issuance_status = ApproversStatus::with(['user'])->where('data_id', $transfer_id)->where('pages_id', 10)->get();
                // print_r($issuance_status );
                // exit;
                return view('AssetTransfer.view_detl', [
                    'data_view' => $data_view,
                    'issuance_status' => $issuance_status
                ]);
            // }else{
            //     $data_view = AssetTransfer::with(['details', 'assetDetails'])->find($transfer_id);
            //     $issuance_status = ApproversStatus::with(['user'])->where('data_id', $transfer_id)->where('pages_id', 10)->get();
            //     // print_r($issuance_status );
            //     // exit;
            //     return view('AssetTransfer.view_detl', [
            //         'data_view' => $data_view,
            //         'issuance_status' => $issuance_status
            //     ]);
            // }
            
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 400);
        }
    }


    function to_approvers(Request $request){
        try {
            //code...

            
            $asset_issuance = AssetTransfer::with(['details', 'assetDetails', 'getEmployee', 'getEmployee_to'])->find($request->asset_iss_id);
            // echo "<pre>";
            // print_r($asset_issuance);
            // exit;
            if ($request->status == "A") {
                $approval = ApproversStatus::find($request->appr_id);
                $approval->status = $request->status;
                $approval->uid = Str::uuid(); //generate uuid
                $approval->save();

                // foreach ($asset_issuance->details as $key => $value) {
                //     $status_assset = asset_assign_changes($value->asset_id, $asset_issuance->getEmployee->id, "TRUE", false);
                //     if(!empty($status_assset)){
                //         $asset_data_transfer = Asset::find($status_assset->asset_id);
                //         $asset_data_transfer->asset_status_id = "16";
                //         $asset_data_transfer->save();
                //     }
                //     // print_r($status_assset);
                // }

                
                // exit;

                // $approver = approvalIssuance($asset_issuance->id, 3, 8, $asset_issuance->rev_num, $asset_issuance->issued_by, $employee->first_name.' '.$employee->last_name, $asset_issuance->date_requested, $asset_issuance->date_needed, $asset_issuance->approved_status);
                $approver = approvalAssetTransfer($asset_issuance->id, 3, 10, $asset_issuance->approved_status);
                $data_of_approvers = ApproversMatrix::where('user_id', $approval->user_id)->where('type_of_process', 3)->first();

                if($data_of_approvers->increment_num == "FA"){
                    $asset_issuance->approved_status = "A";
                    $asset_issuance->approved_by = session('user_email');
                    $asset_issuance->approved_at = now();
                    $asset_issuance->approved_uid = $approval->uid;
                    $asset_issuance->save();


                    $ref = generateRefNumber();
                    $asset_main = new AssetIssuance();
                    $asset_main->emp_id = $asset_issuance->to_assign;
                    $asset_main->date_requested = $asset_issuance->date_requested;
                    $asset_main->date_needed = $asset_issuance->date_needed;
                    $asset_main->issued_by = $asset_issuance->requested_by;

                    $asset_main->location_id = $asset_issuance->location_id;
                    $asset_main->deployment_type = $asset_issuance->deployment_type;
                    $asset_main->deployment_duration_from = $asset_issuance->duration_from;
                    $asset_main->deployment_duration_to = $asset_issuance->duration_to;
                    $asset_main->reports_to = $asset_issuance->report_to;

                    $asset_main->apprver_references = 3;
                    $asset_main->ref_rss = $asset_issuance->ref_rss;
                    $asset_main->rev_num = $ref;
                    $asset_main->createdby = session('user_email');
                    $asset_main->created_at = now();
                    $asset_main->save();

                    
                    foreach ($asset_issuance->details as $key => $value) {
                        $asset_issuance_detl  = new AssetIssuanceDetl();
                        $asset_issuance_detl->issuance_main_id = $asset_main->id;
                        $asset_issuance_detl->asset_id = $value->asset_id;
                        $asset_issuance_detl->createdby = session('user_email');
                        $asset_issuance_detl->created_at = now();
                        $asset_issuance_detl->save();
                    }

                    
                    Mail::to($asset_issuance->requested_by)->send(new ApprovedTransferIssuance($asset_issuance->id, $asset_main->id));
                    
                    
                    // $gatepass = new GatepassData();
                    // $gatepass->uid = Str::uuid();
                    // $gatepass->data_id = $asset_issuance->id;
                    // $gatepass->module_from = "issuance";
                    // $gatepass->from_location = "2801";
                    // $gatepass->to_location = $asset_issuance->location_id;
                    // $gatepass->createdby = session('user_email');
                    // $gatepass->created_at = now();
                    // $gatepass->save();
                    // Mail::to($asset_issuance->issued_by)->send(new Approvedissuance_Notif($asset_issuance->id, $gatepass->id));

                    
                    // print_r($asset_issuance);
                    // exit;
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Issuanace Approved Successfully the Issuance Requestor will be notify to create gatepass'
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
                            Mail::to($asset_issuance->issued_by)->send(new Revisedissuance_Notif($asset_issuance->id, $approval->id));
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
                            Mail::to($asset_issuance->issued_by)->send(new Revisedissuance_Notif($asset_issuance->id, $approval->id));
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
                        }

                }
                
            }
            // // $approver = approvalIssuance($asset_issuance->id, 3, session('current_page'), $asset_issuance->rev_num, $asset_issuance->issued_by, $employee->first_name.' '.$employee->last_name, $asset_issuance->date_requested, $asset_issuance->date_needed);
            // //
            // return response()->json([
            //     'status' => 'success',
            //     'message' => 'Send to Approver Successfully'
            // ], 200);
        } catch (\Throwable $th) {
            // return response()->json([
            //     'status' => 'error',
            //     'message' => $th->getMessage()
            // ], 400);
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 400);
            
        }

    }


    function get_emp_details(Request $request){
        try {
            //code...
            $request->validate([
                'to_empid' => 'required'
            ]);


            $emp_data = Employee::find($request->to_empid);
            return response()->json([
                'status' => 'success',
                'data' => $emp_data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'success',
                'data' => $th->getMessage()
            ], 400);
        }
    }
    
}
