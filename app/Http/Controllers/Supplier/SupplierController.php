<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User_pages_permission;
use App\Models\Supplier;

class SupplierController extends Controller
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
            $supplier = Supplier::where('isDelete',false)->where('type_of_asset', session('type_asset'))->get();
            return view('Supplier.view', [
                'supplier' => $supplier
            ]);
        }else{
            return redirect('/dashboard')->with('error', 'Sorry you dont have right on this module.');
        }
    }


    public function add_supplier(Request $request){
        try {

            $permissions = $this->checkingpages();
            if($permissions->isCreate){
                $request->validate([
                    'name' => 'required',
                    'contact_person_data' => 'required',
                    'email_data' => 'required',
                    'phone_data' => 'required',
                    'address_dat' => 'required',
                ]);
        
                $supplier = new Supplier();
                $supplier->name = $request->name;
                $supplier->contact_person = $request->contact_person_data;
                $supplier->email = $request->email_data;
                $supplier->phone = $request->phone_data;
                $supplier->address = $request->address_dat;
                $supplier->type_of_asset = session('type_asset');
                $supplier->createdby = session('user_email');
                $supplier->created_at = now();
                $supplier->save();
        
                return response()->json([
                    'status' => 'success',
                    'message' => $supplier->name . ' Supplier Add Successfully'
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

    public function edit_supplier(Request $request, $id){
            try {

                $permissions = $this->checkingpages();
                if($permissions->isUpdate){
                    $request->validate([
                        'name' => 'required',
                        'contact_person_data' => 'required',
                        'email_data' => 'required',
                        'phone_data' => 'required',
                        'address_dat' => 'required',
                    ]);
                    $supplier = Supplier::find($id);
                    $supplier->name = $request->name;
                    $supplier->contact_person = $request->contact_person_data;
                    $supplier->email = $request->email_data;
                    $supplier->phone = $request->phone_data;
                    $supplier->address = $request->address_dat;
                    $supplier->updatedby = session('user_email');
                    $supplier->updated_at = now();
                    $supplier->save();
                    
                    return response()->json([
                        'status' => 'success',
                        'message' => $supplier->name . ' Supplier Updated Successfully'
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
