<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Reports\ReportController;


Route::middleware('auth')->group(function () {
    //Assetcount
    Route::get('/Assetcount', [ReportController::class, 'AssetCount'])->name('reports.assetcount');
    Route::get('/Assetscanned', [ReportController::class, 'Assetscanned'])->name('reports.Assetscanned');
    Route::post('/filter/asset_scanned', [ReportController::class, 'filterAssetScanned'])->name('reports.filter.asset_scanned');


    //pdf
    Route::get('/pdf/assetcount/{id}', [ReportController::class, 'AssetCountPdf'])->name('reports.assetcount.pdf');
});