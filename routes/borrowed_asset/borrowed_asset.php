<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Borrowed_Asset\BorrowedAssetController;

Route::middleware('auth')->group(function () {
    Route::get('/view', [BorrowedAssetController::class, 'view'])->name('BorrowedAsset.view');
    Route::get('/add', [BorrowedAssetController::class, 'add'])->name('BorrowedAsset.add');
    Route::post('/add', [BorrowedAssetController::class, 'store']);
    Route::get('/for_finalize/{id}', [BorrowedAssetController::class, 'for_finalize'])->name('BorrowedAsset.for_finalize');
    Route::post('/add_detl', [BorrowedAssetController::class, 'store_detl']);
    Route::post('/saveOtherDetl', [BorrowedAssetController::class, 'store_otherdetl']);
    Route::post('/saveOtherDetlReturn', [BorrowedAssetController::class, 'store_otherdetl_return']);
    Route::post('/getData_detl', [BorrowedAssetController::class, 'get_data_detl']);
    Route::delete('/getDeleteDetl', [BorrowedAssetController::class, 'delete_detl']);
    Route::post('/finalized', [BorrowedAssetController::class, 'finalized']);
    Route::post('/approvers', [BorrowedAssetController::class, 'to_approvers']);
    Route::get('/gate_passchecker/{id}', [BorrowedAssetController::class, 'gate_passchecker']);
    Route::get('/pdf_report/{id}', [BorrowedAssetController::class, 'borrowed_pdf']);
    Route::get('/approve/{id}/{status}/{page_id}/{user_id}', [BorrowedAssetController::class, 'auto_approved']);
});

