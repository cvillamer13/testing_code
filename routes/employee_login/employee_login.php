<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\EmployeeLoginController;
use App\Http\Controllers\Permission\PermissionsController;
use App\Http\Controllers\Employee\AssetRequestController;
use App\Http\Controllers\Employee\AssetRecievedtController;
use App\Http\Controllers\Asset\AssetAssignController;
use App\Http\Controllers\Borrowed_Asset\BorrowedAssetController;
use App\Http\Controllers\Location\LocationController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [EmployeeLoginController::class, 'login_index'])->name('login_employee');
    Route::post('/login', [EmployeeLoginController::class, 'store_sys']);
    // 
    
});


Route::middleware(['employee'])->group(function () {
    Route::get('/index', [EmployeeLoginController::class, 'main'])->name('employee.index');
    Route::get('/logout', [EmployeeLoginController::class, 'logout'])->name('logout_employee');
    Route::post('/permissions/check', [PermissionsController::class, 'check_page']);
    Route::get('/asset_request', [AssetRequestController::class, 'view'])->name('employee.asset_request');
    Route::get('/asset_recieved/{type_process}', [AssetRecievedtController::class, 'asset_recieved'])->name('employee.asset_recieved.view');
    Route::get('/asset_recieved/issuance_pdf/{id}', [AssetAssignController::class, 'issuance_pdf']);
    Route::get('/asset_recieved/issuance/{id}', [AssetRecievedtController::class, 'to_recieved_emp']);
    Route::get('/trans_add', [AssetRecievedtController::class, 'req_transmittal'])->name('employee.transmittal.add');
    Route::post('/trans_add', [AssetRecievedtController::class, 'req_trans_save']);
    Route::post('/Location/getDepartment', [LocationController::class, 'getDepartment']);
    Route::post('/Location/getLocation', [LocationController::class, 'getLocation']);
    Route::get('/borrowed_asset/for_finalize/{id}', [BorrowedAssetController::class, 'for_finalize_emp'])->name('BorrowedAssetEMP.for_finalize');
    Route::post('/BorrowedAsset/add_detl', [BorrowedAssetController::class, 'store_detl_emp']);
    Route::post('/BorrowedAsset/finalized', [BorrowedAssetController::class, 'finalized_emp']);
    // Route::get('/transmittal', [BorrowedAssetController::class, 'view'])->name('employee.transmittal');
    
});
