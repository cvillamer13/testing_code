<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Asset\AssetAssignController;

Route::middleware('auth')->group(function () {
    Route::post('/getAssign', [AssetAssignController::class, 'getAssign']);
    Route::post('/getEmpAssign', [AssetAssignController::class, 'getEmployeeAssign']);
    Route::get('/view', [AssetAssignController::class, 'view'])->name('AssetAssign.view');
    Route::get('/add', [AssetAssignController::class, 'add'])->name('AssetAssign.add');
    Route::post('/add', [AssetAssignController::class, 'store']);
    Route::get('/detl/{id}', [AssetAssignController::class, 'add_detl']);
    Route::post('/detl/{id}', [AssetAssignController::class, 'store_detl']);
    Route::post('/getAsset', [AssetAssignController::class, 'getAsset']);
    Route::post('/getAssetById', [AssetAssignController::class, 'getAssetid']);
    
});