<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Asset\AssetAssignController;

Route::middleware('auth')->group(function () {
    Route::post('/getAssign', [AssetAssignController::class, 'getAssign']);
    Route::post('/getEmpAssign', [AssetAssignController::class, 'getEmployeeAssign']);
});