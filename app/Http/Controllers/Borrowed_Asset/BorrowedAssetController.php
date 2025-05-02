<?php

namespace App\Http\Controllers\Borrowed_Asset;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Location;
use App\Models\Company;
use App\Models\AssetBorrowed;
use App\Models\AssetBorrowedDetl;
use App\Models\ApproversStatus;
use Illuminate\Support\Str;
use App\Models\ApproversMatrix;
use App\Models\GatepassData;
use App\Mail\Approvedissuance_Notif;
use App\Mail\RevisedBorrowed;
use Illuminate\Support\Facades\Mail;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Writer\ValidationException;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Category;
use App\Mail\NotifTechnicalMail;

class BorrowedAssetController extends Controller
{
    function view(){
        $data = AssetBorrowed::all();
        return view('Asset_borrowed.view', [
            'data' => $data
        ]);
    }

    function add(){
        try {
            $employee = Employee::where('isDelete', 'false')->get();
            // print_r($employee);
            // exit;

            $mis = Location::with(['company', 'department'])->find('2898');
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
            
            return redirect('/BorrowedAsset/for_finalize/'.$borrowed->id)->with('success', 'Borrowed Add Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', 'An error occurred: ' . $th->getMessage());
        }
    }


    function for_finalize($id){
        $data = AssetBorrowed::with(['getEmployee', 'getLocation_from', 'details'])->find($id);
        $borrowed = AssetBorrowed::with(['getEmployee', 'getLocation_from', 'details'])->find($id);
        $borrowed_status = ApproversStatus::with(['user'])->where('data_id', $id)->where('pages_id', 11)->get();
        // echo "<pre>";
        // print_r($borrowed);
        // exit;
        return view('Asset_borrowed.for_finalized', [
            'data' => $data,
            'borrowed_status' =>  $borrowed_status,
            'borrowed' => $borrowed
        ]);
    }

    function store_detl(Request $request){
        try {
            $request->validate([
                'asset_id' => 'required',
                'borrowed_id' => 'required',
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

    function store_detl_emp(Request $request){
        try {
            $request->validate([
                'category_id' => 'required',
                'borrowed_id' => 'required',
            ]);
            $store_data = new AssetBorrowedDetl();
            $store_data->asset_id = 0;
            $store_data->category_id = $request->category_id;
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
    function get_data_detl(Request $request){
        try {
            $request->validate([
                'detl_id' => 'required',
            ]);
            $other_detl = AssetBorrowedDetl::find($request->detl_id);
            return response()->json([
                'status' => 'success',
                'data' => $other_detl,
                'message' => 'fetch data'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }

    function store_otherdetl(Request $request){
        try {
            $request->validate([
                'detl_id' => 'required',
                'date_of_return' => 'required'
            ]);

            $other_detl = AssetBorrowedDetl::find($request->detl_id);
            $other_detl->comments = $request->comment;
            $other_detl->date = $request->date_of_return;
            $other_detl->save();

            return response()->json([
                'status' => 'success',
                'message' => 'saving.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }

    function delete_detl(Request $request){
        try {
            $request->validate([
                'detl_id' => 'required',
            ]);
            $other_detl = AssetBorrowedDetl::find($request->detl_id);
            $other_detl->deletedby = session('user_email');
            $other_detl->isDelete = "1";
            $other_detl->deleted_at = now();
            $other_detl->save();
            return response()->json([
                'status' => 'success',
                'data' => $other_detl,
                'message' => 'saving.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }

    function delete_detl_emp(Request $request){
        try {
            $request->validate([
                'detl_id' => 'required',
            ]);
            $other_detl = AssetBorrowedDetl::find($request->detl_id);
            $other_detl->deletedby = session('user_email');
            $other_detl->isDelete = "1";
            $other_detl->deleted_at = now();
            $other_detl->save();
            return response()->json([
                'status' => 'success',
                'data' => $other_detl,
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
                'borrowed_id' => "required"
            ]);
            $other_detl = AssetBorrowed::find($request->borrowed_id);
            $other_detl->is_finalized = "1";
            $other_detl->finalizedby = session('user_email');
            $other_detl->finalize_at = now();
            $other_detl->save();
            if ($other_detl->is_finalized) {
                $f_approver = approvalBorrowedAsset($other_detl->id, 3, 11, $other_detl->approved_status);
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


    function finalized_emp(Request $request){
        try {
            $request->validate([
                'borrowed_id' => "required"
            ]);
            $other_detl = AssetBorrowed::find($request->borrowed_id);
            $other_detl->is_finalized = "1";
            $other_detl->finalizedby = "emp_".session('user_email');
            $other_detl->finalize_at = now();
            // $other_detl->save();
            if ($other_detl->is_finalized) {
                // $f_approver = approvalBorrowedAsset($other_detl->id, 3, 11, $other_detl->approved_status);
                $recipients = [
                    'christian.villamer@jakagroup.com',
                    'nicole.sevilla@jakagroup.com',
                    'renato.calasicas@jakagroup.com',
                ];
          
                Mail::to($recipients)->send(new NotifTechnicalMail($other_detl->id));

                // notification of asset nick
                return response()->json([
                    'status' => 'success',
                    'message' => $other_detl->ref_num . ' Finalized! ',
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

            // print_r($request->all());
            // exit;
            $asset_issuance = AssetBorrowed::with(['details'])->find($request->asset_iss_id);
            
            $employee = Employee::find($asset_issuance->emp_id);
           
            if ($request->status == "A") {
                $approval = ApproversStatus::find($request->appr_id);
                $approval->status = $request->status;
                $approval->uid = Str::uuid(); //generate uuid
                $approval->save();

                $approver = approvalBorrowedAsset($asset_issuance->id, 3, 11, $asset_issuance->status);
                $data_of_approvers = ApproversMatrix::where('user_id', $approval->user_id)->where('type_of_process', 3)->first();

                if($data_of_approvers->increment_num == "FA"){
                    $asset_issuance->approved_status = "A";
                    $asset_issuance->status = "A";
                    $asset_issuance->approved_by = session('user_email');
                    $asset_issuance->approved_at = now();
                    $asset_issuance->uid = $approval->uid;
                    $asset_issuance->save();

                    $gatepass = new GatepassData();
                    $gatepass->uid = Str::uuid();
                    $gatepass->data_id = $asset_issuance->id;
                    $gatepass->module_from = "borrowed";
                    $gatepass->from_location = "2801";
                    $gatepass->to_location = $asset_issuance->to_location;
                    $gatepass->createdby = session('user_email');
                    $gatepass->created_at = now();
                    $gatepass->save();
                    Mail::to($asset_issuance->finalizedby)->send(new Approvedissuance_Notif($asset_issuance->id, $gatepass->id, "borrowed"));

                    
                    // print_r($asset_issuance);
                    // exit;
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Borrowed Asset Approved Successfully the Requestor will be notify to create gatepass'
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

    function gate_passchecker($id){
        try {
            $data = GatepassData::where('data_id', $id)->where('module_from', 'borrowed')->first();
            return redirect('/Gatepass/gatepass_report/'.$data->id)->with('success', 'Borrowed Add Successfully');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }


    function borrowed_pdf($id){
        $data = AssetBorrowed::with(['getEmployee', 'getLocation_from', 'details', 'getLocation_to'])->find($id);
        $requested = Employee::where('email', $data->requested_by)->first();
        $gatepasss_status = ApproversStatus::with(['user'])->where('data_id', $id)->where('pages_id', 11)->get();
        $qrCode = QrCode::create($data->id)
                            ->setEncoding(new Encoding('UTF-8'))
                            ->setErrorCorrectionLevel(ErrorCorrectionLevel::High)
                            ->setSize(200)
                            ->setMargin(10);
                $writer = new PngWriter();
                $result = $writer->write($qrCode);
                $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($result->getString());
        $pdf = Pdf::loadView('Asset_borrowed.borrowed_pdf_rep', [ 'data_show' => $data, 'gatepasss_status' => $gatepasss_status, 'qrCode' => $qrCodeBase64, 'requested' => $requested ]);
        return $pdf->setPaper('A3', 'landscape')->stream(); 
    }

    function auto_approved($id, $status, $page_id, $user_id){
        try {
            $data = AssetBorrowed::with(['getEmployee', 'getLocation_from', 'details'])->find($id);
            $borrowed = AssetBorrowed::with(['getEmployee', 'getLocation_from', 'details'])->find($id);
            $borrowed_status = ApproversStatus::with(['user'])->where('data_id', $id)->where('pages_id', 11)->get();
            // echo "<pre>";
            // print_r($borrowed);
            // exit;
            return view('Asset_borrowed.for_finalized_email', [
                'data' => $data,
                'borrowed_status' =>  $borrowed_status,
                'borrowed' => $borrowed,
                'status' =>  $status
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }


    function for_finalize_emp($id){
        $data = AssetBorrowed::with(['getEmployee', 'getLocation_from', 'details'])->find($id);
        $borrowed = AssetBorrowed::with(['getEmployee', 'getLocation_from', 'details'])->find($id);
        $borrowed_status = ApproversStatus::with(['user'])->where('data_id', $id)->where('pages_id', 11)->get();
        $category = Category::all();
        // echo "<pre>";
        // print_r($data->details[0]->category_details->name);
        // exit;
        return view('Employee_portal.for_finalized_emp', [
            'data' => $data,
            'borrowed_status' =>  $borrowed_status,
            'borrowed' => $borrowed,
            'category' => $category
        ]);
    }
}
