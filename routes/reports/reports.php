<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Reports\ReportController;


Route::middleware('auth')->group(function () {
    //Assetcount
    Route::get('/Assetcount', [ReportController::class, 'AssetCount'])->name('reports.assetcount');



    //pdf
    Route::get('/pdf/assetcount/{id}', [ReportController::class, 'AssetCountPdf'])->name('reports.assetcount.pdf');
});