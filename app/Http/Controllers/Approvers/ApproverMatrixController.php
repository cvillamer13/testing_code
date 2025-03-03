<?php

namespace App\Http\Controllers\Approvers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User_pages_permission;
use App\Models\User;
use App\Models\Company;
use App\Models\ApproversMatrix;

class ApproverMatrixController extends Controller
{
    public function view(){
        $permissions = checkingpages();
        // $permissions = $this->checkingpages();
        // if($permissions->isView){
            $user = User::all();
            $company = Company::all();
            return view('Approvers.view', [
                'user' => $user,
                'company' => $company
            ]);
        // }else {
        //     return redirect('/dashboard')->with('error', 'Sorry you dont have right on this module.');
        // }
    }


    public function add(Request $request){
        try {
            // echo "<pre>";
            // print_r($request->all());


            for ($i=0; $i <= count($request->user_id)-1 ; $i++) { 

                $app = new ApproversMatrix();
                $app->user_id = $request->user_id[$i];
                $app->increment_num = $request->seq_num[$i];
                $app->company_id = $request->company_id[$i];
                $app->department_id = $request->departmen_id[$i];
                $app->type_of_process = 3;
                $app->createdby = session('user_email');
                $app->updatedby = session('user_email');
                $app->save();
            }

            return redirect()->route('Approvers.view')->with('success', 'IT Asset Approvers Added successfully.');

        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }

    }


    public function getApprovers(Request $request){
        try {
            $data = ApproversMatrix::where('type_of_process', $request->process_id)->get();
            return response()->json([
                'status' => 'success',
                'message' => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }
}
