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
}
