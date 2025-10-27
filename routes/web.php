<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperAdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes - berdasarkan role
Route::middleware(['auth'])->group(function () {
    // SuperAdmin routes
    Route::get('/welcome', [SuperAdminController::class, 'welcome'])->name('superadmin.welcome');
    Route::post('/admin/users', [SuperAdminController::class, 'storeUser'])->name('admin.users.store');
    Route::post('/admin/users/reset-password', [SuperAdminController::class, 'resetPassword'])->name('admin.users.reset-password');
    Route::post('/admin/users/toggle-status', [SuperAdminController::class, 'toggleStatus'])->name('admin.users.toggle-status');
    Route::delete('/admin/users', [SuperAdminController::class, 'destroyUser'])->name('admin.users.destroy');

    // AdminSales routes
    Route::get('/welcome2', function () {
        // Cek role
        if (auth()->user()->role !== 'adminsales') {
            abort(403, 'Unauthorized access.');
        }
        return view('welcome2');
    })->name('adminsales.welcome');

    // Sales routes
    Route::get('/welcome3', function () {
        // Cek role
        if (auth()->user()->role !== 'sales') {
            abort(403, 'Unauthorized access.');
        }
        return view('welcome3');
    })->name('sales.welcome');

    // Dashboard umum (fallback)
    Route::get('/dashboard', function () {
        $user = auth()->user();

        // Redirect berdasarkan role jika mengakses dashboard umum
        switch ($user->role) {
            case 'superadmin':
                return redirect('/welcome');
            case 'adminsales':
                return redirect('/welcome2');
            case 'sales':
                return redirect('/welcome3');
            default:
                return view('dashboard');
        }
    })->name('dashboard');
});