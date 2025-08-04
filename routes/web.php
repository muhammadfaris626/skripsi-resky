<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiscrepancyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\TargetController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/employees', EmployeeController::class);
    Route::resource('/targets', TargetController::class);
    Route::resource('/sales', SaleController::class);
    Route::get('/performances', [PerformanceController::class, 'index'])->name('performances.index');

    Route::resource('/users', UserController::class);
    Route::resource('/roles', RoleController::class);
    Route::post('/roles/role/{role_id}/permission/{permission_id}', [RoleController::class, 'updateRolePermission'])->name('updateRolePermission');
    Route::resource('/permissions', PermissionController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
