<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User_pages_permission;
use App\Models\Category;

class AssetCategoryController extends Controller
{
    public function checkingpages(){
        $role_id = session('role_id');
        $current_page = session('current_page');
        $permissions = User_pages_permission::where('pages_id', $current_page)->where('roles_id', $role_id)->first();
        return $permissions; 
    }

    public function view(){
        $permissions = $this->checkingpages();
        if($permissions->isView){
            $category = Category::where('isDelete',false)->where('type_of_asset', session('type_asset'))->get();
            return view('AssetCategory.view', [
                'category' => $category
            ]);
        }else{
            return redirect('/dashboard')->with('error', 'Sorry you dont have right on this module.');
        }
    }

    public function add_category(Request $request)
    {

        try {

            $permissions = $this->checkingpages();
            if($permissions->isCreate){
                $request->validate([
                    'name' => 'required',
                ]);
        
                $category = new Category();
                $category->name = $request->name;
                $category->type_of_asset = session('type_asset');
                $category->createdby = session('user_email');
                $category->updatedby = session('user_email');
                $category->save();
        
                return response()->json([
                    'status' => 'success',
                    'message' => $category->name . ' Category Add Successfully'
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

            $permissions = $this->checkingpages();
            if($permissions->isUpdate){
                $request->validate([
                    'name' => 'required',
                ]);
                $category = Category::find($id);
                $category->name = $request->name;
                $category->updatedby = session('user_email');
                $category->updated_at = now();
                $category->save();
                
                return response()->json([
                    'status' => 'success',
                    'message' => $category->name . ' Category Updated Successfully'
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
