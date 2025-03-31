<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Borrowed_Asset\BorrowedAssetController;

Route::middleware('auth')->group(function () {
    Route::get('/view', [BorrowedAssetController::class, 'view'])->name('BorrowedAsset.view');
    Route::get('/add', [BorrowedAssetController::class, 'add'])->name('BorrowedAsset.add');
    Route::post('/add', [BorrowedAssetController::class, 'store']);
    Route::get('/for_finalize/{id}', [BorrowedAssetController::class, 'for_finalize'])->name('BorrowedAsset.for_finalize');
    Route::post('/add_detl', [BorrowedAssetController::class, 'store_detl']);
    
});

