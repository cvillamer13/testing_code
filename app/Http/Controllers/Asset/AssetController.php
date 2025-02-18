<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User_pages_permission;

class AssetController extends Controller
{

    public function checkingpages(){
        $role_id = session('role_id');
        $current_page = session('current_page');

        $permissions = User_pages_permission::where('pages_id', $role_id)
                                                ->where('roles_id', $role_id)
                                                ->first();
            
            return $permissions; 
    }


    public function view()
    {
        $permissions = $this->checkingpages();
        if($permissions->isView){
            return view('Asset.view');
        }else {
            return redirect('/dashboard')->with('error', 'Sorry you dont have right on this module.');
        }
        
    }
}
