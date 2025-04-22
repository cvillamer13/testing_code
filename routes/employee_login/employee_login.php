<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\EmployeeLoginController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [EmployeeLoginController::class, 'login_index'])->name('login_employee');
    Route::post('/login', [EmployeeLoginController::class, 'store_sys']);
    // 
    
});


Route::middleware(['employee'])->group(function () {
    Route::get('/index', [EmployeeLoginController::class, 'main'])->name('employee.index');
    Route::get('/logout', [EmployeeLoginController::class, 'logout'])->name('logout_employee');
});
