<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AssetRequestController extends Controller
{
    function view()
    {
        return view('Employee_portal.asset_request');
    }
}
