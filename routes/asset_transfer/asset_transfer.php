<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetTransfer\AssetTransferController;

Route::middleware('auth')->group(function () {
    Route::get('/view', [AssetTransferController::class, 'view'])->name('AssetTransfer.view');
    Route::get('/add', [AssetTransferController::class, 'add'])->name('AssetTransfer.add');
    Route::post('/search', [AssetTransferController::class, 'search_issuance']);
    Route::post('/add', [AssetTransferController::class, 'store']);
});