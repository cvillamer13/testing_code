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
    Route::delete('/getDelete', [AssetAssignController::class, 'getDelete']);
    Route::post('/update_detl', [AssetAssignController::class, 'getUpdate']);
    Route::post('/finalize', [AssetAssignController::class, 'to_finalize']);
    Route::get('/view_rev/{rev_num}/{status}/{page_id}/{user_id}', [AssetAssignController::class, 'view_rev_approval']);
    Route::post('/approvers', [AssetAssignController::class, 'to_approvers']);
    Route::get('/issuance_pdf/{id}', [AssetAssignController::class, 'issuance_pdf']);
    Route::get('/gate_pass_rep/{id}', [AssetAssignController::class, 'gatepass_pdf']);
});