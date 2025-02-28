<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetAssigns;

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
}
