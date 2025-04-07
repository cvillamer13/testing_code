<?php

namespace App\Http\Controllers\Asset_Count;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetCount;

class AssetCountController extends Controller
{
    function view()
    {
        return view('AssetCount.view');
    }
}
