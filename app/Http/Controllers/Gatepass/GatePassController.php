<?php

namespace App\Http\Controllers\Gatepass;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetIssuance; 
use App\Models\GatePassData;
use App\Models\Company;
use Carbon\Carbon;
use App\Models\Location;
use App\Models\ApproversStatus;
use Illuminate\Support\Str;

class GatePassController extends Controller
{
    public function view()
    {
        return view('gatepass.view');
    }

    public function gatepass_view($id)
    {
        $data = GatePassData::find($id);
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
                // echo "<pre>";
                // print_r($gatepasss_status);
                // exit;
                return view('Gatepass.gatepass_issuance', [
                    'data_gatepass' => $data,
                    'data_issuance' => $data_show,
                    'companies' => $companies,
                    'from_location' => $from_location,
                    'to_location' => $to_location,
                    'gatepasss_status' => $gatepasss_status
                ]);
            break;
            
            default:
                $data = GatePassData::find($id);
            break;
        }
        
        // echo "<pre>";
        // print_r($data_show);
        // exit;
        // return view('Gatepass.gatepass', [
        //     'data' => $data
        // ]);
    }

    public function gatepass_add(Request $request,$id){
        try {
            $today = now()->toDateString();
            $gatepass = GatePassData::find($id);
            switch ($gatepass->module_from) {
                case 'issuance':
                    $itgp = generateGatepassNumber();
                    $data_show = AssetIssuance::with(['details', 'getEmployee', 'getLocation', 'assetDetails'])->find($gatepass->data_id);
                    $gatepass = GatePassData::find($id);
                    $gatepass->isRequest = 1;
                    $gatepass->gatepass_no = $itgp;
                    $gatepass->from_location = $request->from_location;
                    $gatepass->purpose = $request->purpose_text;
                    $gatepass->date_issued = $today;
                    $gatepass->approvers_ref = 4;
                    $gatepass->status = "P";
                    $gatepass->updatedby = session('user_email');
                    $gatepass->updated_at = now();
                    $gatepass->save();
                    return redirect('/Gatepass/data/'.$gatepass->id)->with('success', $gatepass->gatepass_no.' Add Successfully');
                    // $gatepass->to_location = 1;
                    // $gatepass->gatepass_no = $itgp;
                    // echo "<pre>";
                    // print_r($data_show->details[0]);
                    // exit;

                    // return view('Gatepass.gatepass_issuance', [
                    //     'data_gatepass' => $data,
                    //     'data_issuance' => $data_show,
                    //     'companies' => $companies
                    // ]);

                    // echo "<pre>";
                    // print_r($gatepass);
                    // exit;
                break;
                
                default:
                    $data = GatePassData::find($id);
                break;
            }
            
        } catch (\Throwable $th) {
            //throw $th;
        }
    }


    public function to_finalize(Request $request){
        try {
            //code...
            $asset_gatepass = GatePassData::find($request->gatepass_id);
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
            $gatepass_data = GatePassData::find($request->asset_iss_id);
            if ($request->status == "A") {
                $approval = ApproversStatus::find($request->appr_id);
                $approval->status = $request->status;
                $approval->uid = Str::uuid(); //generate uuid
                $approval->save();

                // $approver = approvalIssuance($asset_issuance->id, 3, session('current_page'), $asset_issuance->rev_num, $asset_issuance->issued_by, $employee->first_name.' '.$employee->last_name, $asset_issuance->date_requested, $asset_issuance->date_needed);
                $approver = approvalGatepass($gatepass_data->id, 4, 14);
                $data_of_approvers = ApproversMatrix::where('user_id', $approval->user_id)->where('type_of_process', 14)->first();

                if($data_of_approvers->increment_num == "FA"){
                    $gatepass_data->approved_status = "A";
                    $gatepass_data->approved_by = session('user_email');
                    $gatepass_data->approved_at = now();
                    $gatepass_data->uid_final_approver = $approval->uid;
                    $gatepass_data->save();
                    // Mail::to($asset_issuance->issued_by)->send(new Approvedissuance_Notif($asset_issuance->id, $gatepass->id));

                    

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
}
