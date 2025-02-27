<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Asset\AssetPrintingBarcode;

Route::middleware('auth')->group(function () {
    Route::get('/view', [AssetPrintingBarcode::class, 'view'])->name('AssetScanned.view');
    Route::post('/getFilter', [AssetPrintingBarcode::class, 'getFilter']);
    Route::post('/getFilterbyOne', [AssetPrintingBarcode::class, 'getFilterbyOne']);
    
});