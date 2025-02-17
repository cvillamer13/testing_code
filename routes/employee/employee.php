<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employee\EmployeeController;

Route::middleware('auth')->group(function () {
    Route::get('/View', [EmployeeController::class, 'view'])->name('employee.view');
    Route::get('/add', [EmployeeController::class, 'add'])->name('employee.add');
    Route::post('/add', [EmployeeController::class, 'add_emp']);

});