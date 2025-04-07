<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetReturn\AssetReturnController;

Route::middleware('auth')->group(function () {
    Route::get('/view', [AssetReturnController::class, 'view'])->name('AssetReturn.view');
    Route::get('/view_emp', [AssetReturnController::class, 'view_emplyee'])->name('AssetReturn.view_emp');
    Route::get('/add_emp', [AssetReturnController::class, 'add_emplyee'])->name('AssetReturn.add_emplyee');
    Route::post('/add_emp', [AssetReturnController::class, 'store_employee']);
    Route::get('/view_data_emp/{id}', [AssetReturnController::class, 'view_data_emp']);
    Route::get('/checker_req/{id}', [AssetReturnController::class, 'checker_to']);
    Route::post('/confirmed', [AssetReturnController::class, 'confirmed_req']);
    Route::post('/detl_data', [AssetReturnController::class, 'store_detl']);
    Route::post('/finalize', [AssetReturnController::class, 'to_finalize']);
    
    
    Route::get('/check/{id}/{pages_id}/{user_id}', [AssetReturnController::class, 'checker_to']);
    
});

