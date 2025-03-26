<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetTransfer\AssetTransferController;

Route::middleware('auth')->group(function () {
    Route::get('/view', [AssetTransferController::class, 'view'])->name('AssetTransfer.view');
    Route::get('/add', [AssetTransferController::class, 'add'])->name('AssetTransfer.add');
    Route::post('/search', [AssetTransferController::class, 'search_issuance']);
    Route::post('/add', [AssetTransferController::class, 'store']);
    Route::get('/finalize/{id}', [AssetTransferController::class, 'to_finalize_view'])->name('AssetTransfer.add');
    Route::post('/finalize', [AssetTransferController::class, 'to_finalize']);

    Route::get('/approver_data/{transfer_id}/{status}/{page_id}/{user_id}', [AssetTransferController::class, 'for_approved']);
    Route::post('/approvers', [AssetTransferController::class, 'to_approvers']);
    Route::post('/emp_data', [AssetTransferController::class, 'get_emp_details']);
    
});