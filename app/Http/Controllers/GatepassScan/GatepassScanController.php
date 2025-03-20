<?php

namespace App\Http\Controllers\GatepassScan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetIssuance; 
use App\Models\GatepassData;
use App\Models\Company;
use App\Models\Location;

class GatepassScanController extends Controller
{
    public function view(){
        try {

            $data = GatepassData::where('inspected_by', session('user_email'))->get();
            // echo "<pre>";
            // print_r($data);
            // exit;
            return view('GatepassScan.view', [
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function for_scannning(Request $request){
        try {
            //code...
            $data = GatepassData::find($request->id_data);

            switch ($data->module_from) {
                case 'issuance':
                    $data_show = AssetIssuance::with(['details', 'getEmployee', 'getLocation', 'assetDetails'])->find($data->data_id);
                    $from_location = Location::with(['company','department'])->find($data->from_location);
                    $to_location = Location::with(['company','department'])->find($data->to_location);
                    // $gatepasss_status = ApproversStatus::with(['user'])->where('data_id', $id)->where('pages_id', 14)->get();
                    // $gatepasss_status_each = ApproversStatus::with(['user'])->where('data_id', $id)->where('pages_id', 14)->where('user_id', Auth::user()->id)->first();


                    return response()->json([
                        'status' => 'success',
                        'data' => $data_show,
                        'from_location' => $from_location,
                        'to_location' => $to_location,
                        'gatepass_info' => $data,
                        'message' => 'Find Data'
                    ], 200);
                break;
                
                default:
                    $data = GatepassData::find($id);
                break;
            }

           
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }


    public function for_confirmed_data(Request $request){
        try {
            //code...
            $data = GatepassData::find($request->gatepass_id);
            switch ($data->status) {
                case 'ITA':
                    return response()->json([
                        'status' => 'warning',
                        'data' => $data,
                        'message' => $data->gatepass_no . " is already transit and recieved by " . $data->recieved
                    ], 200);
                break;

                case 'P':

                    $data->inspected_by = session('user_email');
                    $data->inspected_date = now();
                    $data->recieved = $request->recived_by;
                    $data->status = "ITA";
                    $data->recieved_date = now();
                    $data->save();

                    return response()->json([
                        'status' => 'success',
                        'data' => $data,
                        'message' => $data->gatepass_no . " is change status to recieved and recieved by " . $data->recieved
                    ], 200);
                break;
                
                default:
                # code...
                break;
            }
            
            
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }
}
