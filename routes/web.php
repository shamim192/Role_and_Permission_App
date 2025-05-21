<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Admin Routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Users
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');

    // Roles
    Route::get('/roles', [AdminController::class, 'roles'])->name('admin.roles');
    Route::post('/roles', [AdminController::class, 'storeRole'])->name('admin.roles.store');
    Route::put('/roles/{role}', [AdminController::class, 'updateRole'])->name('admin.roles.update');
    Route::delete('/roles/{role}', [AdminController::class, 'deleteRole'])->name('admin.roles.delete');

    // Permissions
    Route::get('/permissions', [AdminController::class, 'permissions'])->name('admin.permissions');
    Route::post('/permissions', [AdminController::class, 'storePermission'])->name('admin.permissions.store');
    Route::put('/permissions/{permission}', [AdminController::class, 'updatePermission'])->name('admin.permissions.update');
    Route::delete('/permissions/{permission}', [AdminController::class, 'deletePermission'])->name('admin.permissions.delete');
});
