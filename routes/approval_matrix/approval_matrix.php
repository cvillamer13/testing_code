<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Approvers\ApproverMatrixController;

Route::middleware('auth')->group(function () {
    // Route::get('/view', [AssetController::class, 'view'])->name('Asset.view');
    Route::get('/view', [ApproverMatrixController::class, 'view'])->name('Approvers.view');
    Route::post('/add', [ApproverMatrixController::class, 'add']);
    Route::post('/getApprovers', [ApproverMatrixController::class, 'getApprovers']);
});