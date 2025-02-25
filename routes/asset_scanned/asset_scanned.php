<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Asset\AssetAssignScannedController;

Route::middleware('auth')->group(function () {
    Route::get('/view', [AssetAssignScannedController::class, 'view'])->name('AssetScanned.view');
    Route::post('/getScanned', [AssetAssignScannedController::class, 'getScanned']);
    Route::post('/scanned_data', [AssetAssignScannedController::class, 'scanned_data']);
});