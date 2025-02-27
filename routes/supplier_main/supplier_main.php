<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Supplier\SupplierController;

Route::middleware('auth')->group(function () {
    Route::get('/view', [SupplierController::class, 'view'])->name('Supplier.view');
    Route::post('/edit/{id}', [SupplierController::class, 'edit_category']);
    Route::post('/add', [SupplierController::class, 'add_category']);
});