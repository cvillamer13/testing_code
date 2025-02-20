<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Roles\RolesController;
use App\Http\Controllers\Permission\PermissionsController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\Department\DepartmentController;
use App\Http\Controllers\Location\LocationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    //Profile of user
    Route::get('/profile/view', [ProfileController::class, 'edit'])->name('profile');
    Route::post('/profile/view', [ProfileController::class, 'update_profile']);
    
    // Create and Edit of User
    Route::get('/User/view', [UserController::class, 'view'])->name('users');
    Route::get('/User/add', [UserController::class, 'Create'])->name('users.add');
    Route::post('/User/add', [UserController::class, 'Create_user']);
    Route::get('/User/edit/{id}', [UserController::class, 'Edit_View'])->name('users.edit');
    Route::post('/User/edit/{id}', [UserController::class, 'Edit_User']);

    // Create and Edit of Roles
    Route::get('/Roles/view', [RolesController::class, 'view'])->name('roles');
    Route::post('/Roles/add', [RolesController::class, 'Create_Roles']);
    Route::post('/Roles/edit/{id}', [RolesController::class, 'Edit_Roles']);

    // Create and Edit of Permissions
    Route::get('/Permissions/view', [PermissionsController::class, 'view'])->name('permissions');
    Route::get('/Permissions/view_edit/{id}', [PermissionsController::class, 'Edit_View'])->name('permissions.edit');
    Route::post('/permissions/update/{id}', [PermissionsController::class, 'Edit_saved'])->name('permissions.update');
    Route::post('/permissions/check', [PermissionsController::class, 'check_page']);

    // Create and Edit of Company
    Route::get('/Company/view', [CompanyController::class, 'view'])->name('company');
    Route::post('/Company/add', [CompanyController::class, 'Add_Company']);
    Route::post('/Company/edit/{id}', [CompanyController::class, 'Edit_Company']);

    // Create and Edit of Department
    Route::get('/Department/view', [DepartmentController::class, 'view'])->name('department');
    Route::post('/Department/add', [DepartmentController::class, 'Add_Department']);
    Route::post('/Department/edit/{id}', [DepartmentController::class, 'Edit_Department']);

    // Create and Edit of Location
    Route::get('/Location/view', [LocationController::class, 'view'])->name('location');
    Route::post('/Location/add', [LocationController::class, 'Add_Location']);
    Route::post('/Location/edit/{id}', [LocationController::class, 'Edit_Location']);
    Route::post('/Location/getDepartment', [LocationController::class, 'getDepartment']);
    Route::post('/Location/getLocation', [LocationController::class, 'getLocation']);
    
});


require __DIR__.'/auth.php';
