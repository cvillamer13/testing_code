<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Asset\AssetCategoryController;

Route::middleware('auth')->group(function () {
    Route::get('/view', [AssetCategoryController::class, 'view'])->name('AssetCategory.view');
    Route::post('/edit/{id}', [AssetCategoryController::class, 'edit_category']);
    Route::post('/add', [AssetCategoryController::class, 'add_category']);
});