<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Gatepass\GatePassController;

Route::middleware('auth')->group(function () {
    Route::get('/view', [GatePassController::class, 'view'])->name('Gatepass.view');    
    Route::get('/data/{id}', [GatePassController::class, 'gatepass_view'])->name('Gatepass.add');
    Route::post('/data/{id}', [GatePassController::class, 'gatepass_add']);
    Route::post('/finalize', [GatePassController::class, 'to_finalize']);
    Route::post('/approvers', [GatePassController::class, 'to_approvers']);
    Route::get('/view_rev/{id}/{page_id}/{user_id}', [GatePassController::class, 'view_rev']);
    Route::get('/view_rev_approvers/{id}/{status}/{page_id}/{user_id}', [GatePassController::class, 'view_rev_approvers']);
});