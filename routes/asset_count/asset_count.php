<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Asset_Count\AssetCountController;

Route::middleware('auth')->group(function () {
    Route::get('/view', [AssetCountController::class, 'view'])->name('AssetCount.view');
});