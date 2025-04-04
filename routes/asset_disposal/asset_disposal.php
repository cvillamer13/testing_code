<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetDisposal\AssetDisposalController;

Route::middleware('auth')->group(function () {
    Route::get('/view', [AssetDisposalController::class, 'view'])->name('AssetDisposal.view');
    Route::get('/add', [AssetDisposalController::class, 'add'])->name('AssetDisposal.add');
    Route::post('/add', [AssetDisposalController::class, 'pre_store']);
    Route::get('/select_asset/{id}', [AssetDisposalController::class, 'select_asset'])->name('AssetDisposal.select_asset');
    Route::post('/save_selected_asset', [AssetDisposalController::class, 'pre_store_detl']);
    Route::post('/getDataSelected', [AssetDisposalController::class, 'data_selected_asset']);
    Route::post('/save_selected_asset_detl', [AssetDisposalController::class, 'save_selected_asset']);
    Route::post('/finalized', [AssetDisposalController::class, 'finalized']);
    Route::post('/approvers', [AssetDisposalController::class, 'to_approvers']);
    
    
});