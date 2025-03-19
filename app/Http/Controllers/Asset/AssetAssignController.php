<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetAssigns;
use App\Models\AssetIssuance;
use App\Models\AssetIssuanceDetl;
use App\Models\Employee;
use App\Models\Asset;
use App\Models\ApproversStatus;
use App\Models\ApproversMatrix;
use App\Models\GatepassData;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\Approvedissuance_Notif;
use App\Mail\Revisedissuance_Notif;

use Barryvdh\DomPDF\Facade\Pdf;

class AssetAssignController extends Controller
{
    public function getAssign(Request $request){
        try {
            $assign_data = AssetAssigns::with(['getAsset_data', 'getEmployee'])->where('employee_id', $request->id_emp)->get();
            return response()->json([
                'status' => 'success',
                'data' => $assign_data,
                'message' => 'Find Data'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }


    public function getEmployeeAssign(Request $request){
        try {
            $assign_data = AssetAssigns::with(['getAsset_data', 'getEmployee'])->where('asset_id', $request->id_asset)->get();
            return response()->json([
                'status' => 'success',
                'data' => $assign_data,
                'message' => 'Find Data'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }


    public function view()
    {
        $permissions = checkingpages();
        if($permissions->isView){
            // $asset_data = Asset::with(['unit_data', 'category_data', 'supplier_data', 'employee_data', 'asset_status_data', 'company_data', 'department_data', 'location_data'])->where('isDelete',false)->where('type_of_asset', session('type_asset'))->get();
            // $asset_issuance = AssetIssuance::where('createdby', session('user_email'))->get();
            $asset_issuance = AssetIssuance::all();
            return view('AssetAssign.view', [
                'asset_issuance' => $asset_issuance,
            ]);
        }else {
            return redirect('/dashboard')->with('error', 'Sorry you dont have right on this module.');
        }
        
    }


    public function add()
    {
        $permissions = checkingpages();
        if($permissions->isCreate){

            // $ref = generateRefNumber();
            $employee = Employee::all();
            return view('AssetAssign.add', [
                'employee' => $employee
            ]);
        }else {
            return redirect('/dashboard')->with('error', 'Sorry you dont have right on this module.');
        }
        
    }


    public function store(Request $request){
        try {

            $permissions = checkingpages();
            if($permissions->isUpdate){
                // echo "<pre>";
                // print_r($request->all());
                // exit;
                $request->validate([
                    'emp_no' => 'required',
                    'reports_to' => 'required',
                ]);

                $ref = generateRefNumber();
                $asset_main = new AssetIssuance();
                $asset_main->emp_id = $request->emp_no;
                $asset_main->reports_to = $request->reports_to;
                $asset_main->deployment_type = $request->deployment_type;
                $asset_main->deployment_duration_from = $request->duration_from;
                $asset_main->deployment_duration_to = $request->duration_to;
                $asset_main->date_requested = $request->date_requested;
                $asset_main->date_needed = $request->date_need;
                $asset_main->issued_by = session('user_email');
                $asset_main->apprver_references = 3;
                $asset_main->ref_rss = $request->rss_num;
                $asset_main->rev_num = $ref;
                $asset_main->createdby = session('user_email');
                $asset_main->created_at = now();
                $asset_main->save();
                return redirect('/AssetAssign/detl/'.$asset_main->id)->with('success', $asset_main->rev_num.' Add Successfully');
            }else{
                return redirect('/dashboard')->with('error', 'Sorry you dont have right on this module.');
            }
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }


    public function add_detl($id){
        try {
            //code...
            $permissions = checkingpages();
            if($permissions->isUpdate){
                $asset_issuance = AssetIssuance::with(['getLocation'])->find($id);
                $employee_data = Employee::with(['gender', 'position', 'company', 'department'])->find($asset_issuance->emp_id);
                $issuance_detl = AssetIssuanceDetl::with(['asset_details'])->where('issuance_main_id', $id)->where('isDelete', false)->orderBy('created_at', 'asc')->get();
                $issuance_status = ApproversStatus::with(['user'])->where('data_id', $id)->where('pages_id', 8)->get();
                
            return view('AssetAssign.view_detl', [
                'asset_issuance' => $asset_issuance,
                'employee_data' => $employee_data,
                'issuance_detl' => $issuance_detl,
                'issuance_status' => $issuance_status
            ]);
            }else{
                return redirect('/dashboard')->with('error', 'Sorry you dont have right on this module.');
            }
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }



    public function getAsset(Request $request){
        try {
            //code...  $asset_data = Asset::with(['unit_data', 'category_data', 'supplier_data', 'employee_data', 'asset_status_data', 'company_data', 'department_data', 'location_data'])->where('isDelete',false)->where('type_of_asset', session('type_asset'))->get();
            $asset_data = Asset::with(['unit_data', 'category_data', 'supplier_data', 'employee_data', 'asset_status_data', 'company_data', 'department_data', 'location_data'])->where('asset_id',$request->asset_id)->first();
            return response()->json([
                'status' => 'success',
                'data' => $asset_data,
                'message' => 'Find Data'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }

    public function getAssetid(Request $request){
        try {
            //code...  $asset_data = Asset::with(['unit_data', 'category_data', 'supplier_data', 'employee_data', 'asset_status_data', 'company_data', 'department_data', 'location_data'])->where('isDelete',false)->where('type_of_asset', session('type_asset'))->get();
            $asset_data = Asset::with(['unit_data', 'category_data', 'supplier_data', 'employee_data', 'asset_status_data', 'company_data', 'department_data', 'location_data'])->find($request->asset_iddata);
            return response()->json([
                'status' => 'success',
                'data' => $asset_data,
                'message' => 'Find Data'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }

    public function store_detl(Request $request, $id){
        try {
            //code...
            $asset_issuance_detl  = new AssetIssuanceDetl();
            $asset_issuance_detl->issuance_main_id = $id;
            $asset_issuance_detl->asset_id = $request->asset_id;
            $asset_issuance_detl->createdby = session('user_email');
            $asset_issuance_detl->created_at = now();
            $asset_issuance_detl->save();
            
            $data = AssetIssuanceDetl::with(['asset_details'])->find($asset_issuance_detl->id);
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
    
    public function getDelete(Request $request){
        try {
            //code...
            // print($request->detl_id);
            // exit;
            $asset_issuance_detl = AssetIssuanceDetl::find($request->detl_id);
            $asset_issuance_detl->isDelete = true;
            $asset_issuance_detl->deletedby = session('user_email');
            $asset_issuance_detl->deleted_at = now();
            $asset_issuance_detl->save();

            // print($asset_issuance_detl);
            // exit;
            return response()->json([
                'status' => 'success',
                'message' => 'Delete Successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }


    public function getUpdate(Request $request){
        try {
            
            // echo "<pre>";
            // print_r($request->all());
            // exit;
            $request->validate([
                'issuance_detl_id' => 'required',
            ]);
            $asset_issuance_detl = AssetIssuanceDetl::find($request->issuance_detl_id);
            //software
            $asset_issuance_detl->os_patch_ver = $request->os_patch_version;
            $asset_issuance_detl->isMSoffice = $request->is_ms == true ? 1 : 0;
            $asset_issuance_detl->isHCS = $request->is_hcs == true ? 1 : 0;
            $asset_issuance_detl->isNetSuite = $request->is_no == true ? 1 : 0;
            $asset_issuance_detl->isAcrobat_a = $request->is_ada == true ? 1 : 0;
            $asset_issuance_detl->isAcrobat_r = $request->is_acr == true ? 1 : 0;
            $asset_issuance_detl->others = $request->other_text;
            $asset_issuance_detl->peripherals = $request->pheri_1;
            //internet
            $asset_issuance_detl->int_isfull = $request->is_intfull == true ? 1 : 0;
            $asset_issuance_detl->int_islimited = $request->is_intlimited == true ? 1 : 0;
            $asset_issuance_detl->int_limited_detls = $request->intlimited_detl;
            $asset_issuance_detl->int_isNone = $request->is_intnone == true ? 1 : 0;
            $asset_issuance_detl->int_isvoip_ext = $request->is_intvoip == true ? 1 : 0;
            $asset_issuance_detl->int_ispbx_ext = $request->is_intpbx == true ? 1 : 0;
            $asset_issuance_detl->int_isvoip_ext_detls = $request->is_intvoip_detls; // NA design
            $asset_issuance_detl->int_ispbx_ext_detls = $request->is_intpbx_detls;  // NA design

            //network
            $asset_issuance_detl->int_ip_assign = $request->intip_add;
            $asset_issuance_detl->int_mac_address = $request->intmac_add;
            $asset_issuance_detl->int_network_group = $request->intnet_group;
            $asset_issuance_detl->int_wifi_ssid = $request->intwifi_ssid;
            $asset_issuance_detl->int_subnet = $request->intsub_net;
            // $asset_issuance_detl->int_detailsandnote = $request->is_netlimited_det;
            $asset_issuance_detl->int_shared_drives = $request->intshared_drive;
            $asset_issuance_detl->int_shared_printers = $request->intshared_print;

            $asset_issuance_detl->updatedby = session('user_email');
            $asset_issuance_detl->updated_at = now();
            $asset_issuance_detl->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Update Successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);

        }
    }


    public function to_finalize(Request $request){
        try {
            //code...
            $asset_issuance = AssetIssuance::find($request->id_issuance_main);
            // echo "<pre>";
            // print_r($asset_issuance);
            // exit;
            $asset_issuance->finalizedby = session('user_email');
            $asset_issuance->finalize_at = now();
            $asset_issuance->is_finalized = 1;
            $asset_issuance->save();

            if($asset_issuance->is_finalized && $asset_issuance->approved_status == "RE"){
                $employee = Employee::find($asset_issuance->emp_id);
                $approver = approvalIssuance($asset_issuance->id, 3, 8, $asset_issuance->rev_num, $asset_issuance->issued_by, $employee->first_name.' '.$employee->last_name, $asset_issuance->date_requested, $asset_issuance->date_needed, $asset_issuance->approved_status);
                $asset_issuance->approved_status = "P";
                $asset_issuance->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Finalize Successfully'
                ], 200);
            }else{
                $employee = Employee::find($asset_issuance->emp_id);
                $approver = approvalIssuance($asset_issuance->id, 3, 8, $asset_issuance->rev_num, $asset_issuance->issued_by, $employee->first_name.' '.$employee->last_name, $asset_issuance->date_requested, $asset_issuance->date_needed, $asset_issuance->approved_status);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Finalize Successfully'
                ], 200);
            }
            
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }


    function view_rev_approval($rev_, $page_id_data, $user_id){
        $page_id = session('current_page');
        if($page_id == ""){
            $page_id = $page_id_data;
            Session::put('current_page', $page_id);
        }
        $asset_issuance = AssetIssuance::with(['details', 'getEmployee'])->where('rev_num', $rev_)->first();
        $issuance_status = ApproversStatus::with(['user'])->where('data_id', $asset_issuance->id)->where('pages_id', $page_id)->get();
        return view('AssetAssign.view_detl', [
            'asset_issuance' => $asset_issuance,
            'employee_data' => $asset_issuance->getEmployee,
            'issuance_detl' => $asset_issuance->details,
            'issuance_status' => $issuance_status
        ]);
        // echo "<pre>";
        // print_r($asset_issuance->details);
        // exit;
    }


    function to_approvers(Request $request){
        try {
            //code...

            // print_r($request->all());
            // exit;
            $asset_issuance = AssetIssuance::find($request->asset_iss_id);
            
            $employee = Employee::find($asset_issuance->emp_id);
            // print_r($employee->first_name.' '.$employee->last_name);
            // exit;
            if ($request->status == "A") {
                $approval = ApproversStatus::find($request->appr_id);
                $approval->status = $request->status;
                $approval->uid = Str::uuid(); //generate uuid
                $approval->save();

                $approver = approvalIssuance($asset_issuance->id, 3, 8, $asset_issuance->rev_num, $asset_issuance->issued_by, $employee->first_name.' '.$employee->last_name, $asset_issuance->date_requested, $asset_issuance->date_needed, $asset_issuance->approved_status);
                
                $data_of_approvers = ApproversMatrix::where('user_id', $approval->user_id)->where('type_of_process', 3)->first();

                if($data_of_approvers->increment_num == "FA"){
                    $asset_issuance->approved_status = "A";
                    $asset_issuance->approved_by = session('user_email');
                    $asset_issuance->approved_at = now();
                    $asset_issuance->uid = $approval->uid;
                    $asset_issuance->save();

                    $gatepass = new GatepassData();
                    $gatepass->uid = Str::uuid();
                    $gatepass->data_id = $asset_issuance->id;
                    $gatepass->module_from = "issuance";
                    $gatepass->to_location = $asset_issuance->location_id;
                    $gatepass->createdby = session('user_email');
                    $gatepass->created_at = now();
                    $gatepass->save();
                    Mail::to($asset_issuance->issued_by)->send(new Approvedissuance_Notif($asset_issuance->id, $gatepass->id));

                    
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
            // $approver = approvalIssuance($asset_issuance->id, 3, session('current_page'), $asset_issuance->rev_num, $asset_issuance->issued_by, $employee->first_name.' '.$employee->last_name, $asset_issuance->date_requested, $asset_issuance->date_needed);
            //
            return response()->json([
                'status' => 'success',
                'message' => 'Send to Approver Successfully'
            ], 200);
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


    function issuance_pdf($id){
        // $pdf = Pdf::loadView('AssetAssign.issuance_pdf_rep', ['data' => $data]);
        $pdf = Pdf::loadView('AssetAssign.issuance_pdf_rep');
        return $pdf->setPaper('letter', 'portrait')->stream(); 

    }
}
