<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employee\EmployeeController;

Route::middleware('auth')->group(function () {
    Route::get('/View', [EmployeeController::class, 'view'])->name('employee.view');
    Route::get('/add', [EmployeeController::class, 'add'])->name('employee.add');
    Route::post('/add', [EmployeeController::class, 'add_emp']);
    Route::post('/getEmployee', [EmployeeController::class, 'get_employee']);
    Route::get('/edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit');
    Route::post('/edit/{id}', [EmployeeController::class, 'update']);
    Route::post('/delete/{id}', [EmployeeController::class, 'delete_soft']);
});