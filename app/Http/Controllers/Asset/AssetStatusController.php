<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asset_Status;

class AssetStatusController extends Controller
{

    public function view(){
        $permissions = checkingpages();
        if($permissions->isView){
            $status = Asset_Status::where('isDelete',false)->where('type_of_asset', session('type_asset'))->get();
            return view('AssetStatus.view', [
                'status' => $status
            ]);
        }else{
            return redirect('/dashboard')->with('error', 'Sorry you dont have right on this module.');
        }
    }


    public function add_category(Request $request)
    {

        try {

            $permissions = checkingpages();
            if($permissions->isCreate){
                $request->validate([
                    'name' => 'required',
                ]);
        
                $status = new Asset_Status();
                $status->status = $request->name;
                $status->type_of_asset = session('type_asset');
                $status->createdby = session('user_email');
                $status->updatedby = session('user_email');
                $status->save();
        
                return response()->json([
                    'status' => 'success',
                    'message' => $status->status . ' Status Add Successfully'
                ], 200); 
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sorry you dont have right on this module.'
                ], 400);
            }
            
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }


    public function edit_category(Request $request, $id){
        try {

            $permissions = checkingpages();
            if($permissions->isUpdate){
                $request->validate([
                    'name' => 'required',
                ]);
                $status = Asset_Status::find($id);
                $status->status = $request->name;
                $status->updatedby = session('user_email');
                $status->updated_at = now();
                $status->save();
                
                return response()->json([
                    'status' => 'success',
                    'message' => $status->status . ' Status Updated Successfully'
                ], 200);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sorry you dont have right on this module.'
                ], 400);
            }
            

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }
}
