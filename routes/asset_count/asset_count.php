<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Asset_Count\AssetCountController;

Route::middleware('auth')->group(function () {
    Route::get('/view', [AssetCountController::class, 'view'])->name('AssetCount.view');
    Route::get('/add', [AssetCountController::class, 'add'])->name('AssetCount.add');
    Route::post('/add', [AssetCountController::class, 'store']);
    Route::post('/getLocationScope', [AssetCountController::class, 'getLocationScope']);
    Route::get('/for_finalize/{id}', [AssetCountController::class, 'list_asset'])->name('AssetCount.list_asset');
});