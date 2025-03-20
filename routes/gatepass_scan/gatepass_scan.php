<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GatepassScan\GatepassScanController;


Route::middleware('auth')->group(function () {
    Route::get('/view', [GatepassScanController::class, 'view'])->name('Gatepassscan.view');
    Route::post('/details', [GatepassScanController::class, 'for_scannning']);
    Route::post('/confirmed_data', [GatepassScanController::class, 'for_confirmed_data']);
    

});