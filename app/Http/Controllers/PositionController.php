<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;
class PositionController extends Controller
{
    function view(){
        $postions = Position::all();
        return view('Position.view', compact('postions'));
    }
}
