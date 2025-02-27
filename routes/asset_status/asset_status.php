<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Asset\AssetStatusController;

Route::middleware('auth')->group(function () {
    Route::get('/view', [AssetStatusController::class, 'view'])->name('AssetStatus.view');
    Route::post('/edit/{id}', [AssetStatusController::class, 'edit_category']);
    Route::post('/add', [AssetStatusController::class, 'add_category']);
});