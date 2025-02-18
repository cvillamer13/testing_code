<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Asset\AssetController;

Route::middleware('auth')->group(function () {
    Route::get('/view', [AssetController::class, 'view'])->name('Asset.view');
});