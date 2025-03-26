<?php

namespace App\Http\Controllers\Gatepass;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetIssuance; 
use App\Models\GatepassData;
use App\Models\Company;
use Carbon\Carbon;
use App\Models\Location;
use App\Models\ApproversStatus;
use Illuminate\Support\Str;
use App\Models\ApproversMatrix;
use Illuminate\Support\Facades\Auth;
use App\Mail\ReleaseGatePass;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Writer\ValidationException;


class GatePassController extends Controller
{
    public function view()
    {
        $data_gatepass = GatepassData::where('isRequest', true)->get();

        return view('Gatepass.view',[
            'data' => $data_gatepass
        ]);
    }

    public function gatepass_view($id)
    {
        $data = GatepassData::find($id);
        $companies = Company::all();
        // if($data->module_from == "issuance") {
        //     $data_show = AssetIssuance::with(['details', 'getEmployee', 'getLocation'])->find($data->data_id);
        // }

        switch ($data->module_from) {
            case 'issuance':
                $data_show = AssetIssuance::with(['details', 'getEmployee', 'getLocation', 'assetDetails'])->find($data->data_id);
                $from_location = Location::with(['company','department'])->find($data->from_location);
                $to_location = Location::with(['company','department'])->find($data->to_location);
                $gatepasss_status = ApproversStatus::with(['user'])->where('data_id', $id)->where('pages_id', 14)->get();
                $gatepasss_status_each = ApproversStatus::with(['user'])->where('data_id', $id)->where('pages_id', 14)->where('user_id', Auth::user()->id)->first();

                // echo "<pre>";
                // print_r($data);
                // exit;
                return view('Gatepass.gatepass_issuance', [
                    'data_gatepass' => $data,
                    'data_issuance' => $data_show,
                    'companies' => $companies,
                    'from_location' => $from_location,
                    'to_location' => $to_location,
                    'gatepasss_status' => $gatepasss_status,
                    'status' => "P",
                    'gatepasss_status_each' => $gatepasss_status_each,
                ]);
            break;
            
            default:
                $data = GatepassData::find($id);
            break;
        }
        
        // echo "<pre>";
        // print_r($data_show);
        // exit;
        // return view('Gatepass.gatepass', [
        //     'data' => $data
        // ]);
    }

    public function view_rev($id, $page_id, $user_id){
        try {
            // print_r($user_id);
            // exit;
            if (Auth::user()->id == $user_id) {
                # code...
                
                $data = GatepassData::find($id);
                $companies = Company::all();

                switch ($data->module_from) {
                    case 'issuance':
                        $data_show = AssetIssuance::with(['details', 'getEmployee', 'getLocation', 'assetDetails'])->find($data->data_id);
                        $from_location = Location::with(['company','department'])->find($data->from_location);
                        $to_location = Location::with(['company','department'])->find($data->to_location);
                        $gatepasss_status = ApproversStatus::with(['user'])->where('data_id', $id)->where('pages_id', 14)->get();
                        $gatepasss_status_each = ApproversStatus::with(['user'])->where('data_id', $id)->where('pages_id', 14)->where('user_id', $user_id)->first();

                        // echo "<pre>";
                        // print_r($gatepasss_status);
                        // exit;
                        return view('Gatepass.gatepass_issuance', [
                            'data_gatepass' => $data,
                            'data_issuance' => $data_show,
                            'companies' => $companies,
                            'from_location' => $from_location,
                            'to_location' => $to_location,
                            'gatepasss_status' => $gatepasss_status,
                            'status' => "P",
                            'gatepasss_status_each' => $gatepasss_status_each,
                        ]);
                    break;
                    
                    default:
                        $data = GatepassData::find($id);
                    break;
                } 


            }else {
                return redirect('/dashboard')->with('error', 'Sorry you dont have right on this module.');
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }


    public function view_rev_approvers($id, $status, $page_id, $user_id){
        try {
            // print_r($user_id);
            // exit;
            if (Auth::user()->id == $user_id) {
                # code...
                
                $data = GatepassData::find($id);
                $companies = Company::all();

                switch ($data->module_from) {
                    case 'issuance':
                        $data_show = AssetIssuance::with(['details', 'getEmployee', 'getLocation', 'assetDetails'])->find($data->data_id);
                        $from_location = Location::with(['company','department'])->find($data->from_location);
                        $to_location = Location::with(['company','department'])->find($data->to_location);
                        $gatepasss_status = ApproversStatus::with(['user'])->where('data_id', $id)->where('pages_id', 14)->get();
                        $gatepasss_status_each = ApproversStatus::with(['user'])->where('data_id', $id)->where('pages_id', 14)->where('user_id', $user_id)->first();
                        // echo "<pre>";
                        // print_r($gatepasss_status_each);
                        // exit;
                        return view('Gatepass.gatepass_issuance', [
                            'data_gatepass' => $data,
                            'data_issuance' => $data_show,
                            'companies' => $companies,
                            'from_location' => $from_location,
                            'to_location' => $to_location,
                            'gatepasss_status' => $gatepasss_status,
                            'status' => $status,
                            'gatepasss_status_each' => $gatepasss_status_each,
                        ]);
                    break;
                    
                    default:
                        $data = GatepassData::find($id);
                    break;
                } 


            }else {
                return redirect('/dashboard')->with('error', 'Sorry you dont have right on this module.');
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    

    public function gatepass_add(Request $request,$id){
        try {
            $today = now()->toDateString();
            $gatepass = GatepassData::find($id);
            switch ($gatepass->module_from) {
                case 'issuance':
                    $itgp = generateGatepassNumber();
                    $data_show = AssetIssuance::with(['details', 'getEmployee', 'getLocation', 'assetDetails'])->find($gatepass->data_id);
                    $gatepass = GatepassData::find($id);
                    $gatepass->isRequest = 1;
                    $gatepass->gatepass_no = $itgp;
                    $gatepass->purpose = $request->purpose_text;
                    $gatepass->date_issued = $today;
                    $gatepass->approvers_ref = 4;
                    $gatepass->status = "P";
                    $gatepass->updatedby = session('user_email');
                    $gatepass->updated_at = now();
                    $gatepass->save();
                    return redirect('/Gatepass/data/'.$gatepass->id)->with('success', $gatepass->gatepass_no.' Add Successfully');
                break;
                
                default:
                    $data = GatepassData::find($id);
                break;
            }
            
        } catch (\Throwable $th) {
            //throw $th;
        }
    }


    public function to_finalize(Request $request){
        try {
            //code...
            $asset_gatepass = GatepassData::find($request->gatepass_id);
            // echo "<pre>";
            // print_r($asset_gatepass);
            // exit;
            $asset_gatepass->finalizedby = session('user_email');
            $asset_gatepass->finalize_at = now();
            $asset_gatepass->is_finalized = 1;
            $asset_gatepass->save();

            if($asset_gatepass->is_finalized){
                // $approver = approvalIssuance($asset_issuance->id, 3, session('current_page'), $asset_issuance->rev_num, $asset_issuance->issued_by, $employee->first_name.' '.$employee->last_name, $asset_issuance->date_requested, $asset_issuance->date_needed);
                $approver = approvalGatepass($asset_gatepass->id, 4, 14);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Finalize successfully the approvers will notify your request'
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
            $gatepass_data = GatepassData::find($request->gatepass_id);
            if ($request->status == "A") {
                $approval = ApproversStatus::find($request->appr_id);
                $approval->status = $request->status;
                $approval->uid = Str::uuid(); //generate uuid
                $approval->save();

                // $approver = approvalIssuance($asset_issuance->id, 3, session('current_page'), $asset_issuance->rev_num, $asset_issuance->issued_by, $employee->first_name.' '.$employee->last_name, $asset_issuance->date_requested, $asset_issuance->date_needed);
                $approver = approvalGatepass($gatepass_data->id, 4, 14);
                $data_of_approvers = ApproversMatrix::where('user_id', $approval->user_id)->where('type_of_process', 4)->first();

                if($data_of_approvers->increment_num == "FA"){
                    $gatepass_data->approved_status = "A";
                    $gatepass_data->approved_by = session('user_email');
                    $gatepass_data->approved_at = now();
                    $gatepass_data->uid_final_approver = $approval->uid;
                    $gatepass_data->save();
                    // next this
                    Mail::to($gatepass_data->finalizedby)->send(new ReleaseGatePass($gatepass_data->id));

                    

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Gatepasss Approved Successfully!'
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
                    $approval = ApproversStatus::where('data_id', $asset_issuance->id)
                        ->where('pages_id', session('current_page'))
                        ->where('status', 'NA')
                        ->update([
                            'status' => 'CNA',
                            'uid' => Str::uuid()->toString() . "-CNA"
                        ]);
                        if($data_of_approvers->increment_num == "FA"){
                            $gatepass_data->approved_status = "RE";
                            $gatepass_data->approved_by = session('user_email');
                            $gatepass_data->approved_at = now();
                            $gatepass_data->uid_final_approver = $approval->uid;
                            $gatepass_data->save();
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
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }

    }


    function gatepass_pdf($id){
        // $pdf = Pdf::loadView('AssetAssign.issuance_pdf_rep', ['data' => $data]);
        // echo url('images/logos.png'); exit;
        $data = GatepassData::find($id);
        $from_location = Location::with(['company','department'])->find($data->from_location);
        $to_location = Location::with(['company','department'])->find($data->to_location);
       


        switch ($data->module_from) {
            case 'issuance':
                $data_show = AssetIssuance::with(['details', 'getEmployee', 'getLocation', 'assetDetails'])->find($data->data_id);
                $from_location = Location::with(['company','department'])->find($data->from_location);
                $to_location = Location::with(['company','department'])->find($data->to_location);
                $gatepasss_status = ApproversStatus::with(['user'])->where('data_id', $id)->where('pages_id', 14)->get();
                $gatepasss_status_each = ApproversStatus::with(['user'])->where('data_id', $id)->where('pages_id', 14)->where('user_id', Auth::user()->id)->first();
                // $qrCode = base64_encode(QrCode::format('png')->size(200)->generate($data->id));
                $qrCode = QrCode::create($data->id)
                            ->setEncoding(new Encoding('UTF-8'))
                            ->setErrorCorrectionLevel(ErrorCorrectionLevel::High)
                            ->setSize(200)
                            ->setMargin(10);
                $writer = new PngWriter();
                $result = $writer->write($qrCode);
                $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($result->getString());



                // echo "<pre>";
                // print_r($qrCodeBase64);
                // exit;
                $pdf = Pdf::loadView('Gatepass.gatepass_pdf_rep', ['data' => $data, 'from_location' => $from_location, 'to_location' => $to_location, 'data_show' => $data_show, 'gatepasss_status' => $gatepasss_status, 'qrCode' => $qrCodeBase64 ]);
                return $pdf->setPaper('letter', 'landscape')->stream(); 
            break;
            
            default:
                $data = GatepassData::find($id);
            break;
        }
        

    }
}
