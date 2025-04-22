<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\EmployeeLoginController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [EmployeeLoginController::class, 'login_index'])->name('login_employee');
});