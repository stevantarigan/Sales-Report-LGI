<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

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

    // =============================================
    // SUPER ADMIN ROUTES
    // =============================================
    Route::prefix('admin')->group(function () {
        // User Management Routes
        Route::get('/users', [SuperAdminController::class, 'users'])->name('admin.users.index');
        Route::get('/users/create', [SuperAdminController::class, 'createUser'])->name('admin.users.create');
        Route::post('/users', [SuperAdminController::class, 'storeUser'])->name('admin.users.store');
        Route::get('/users/{user}/edit', [SuperAdminController::class, 'editUser'])->name('admin.users.edit');
        Route::put('/users/{user}', [SuperAdminController::class, 'updateUser'])->name('admin.users.update');
        Route::post('/users/reset-password', [SuperAdminController::class, 'resetPassword'])->name('admin.users.reset-password');
        Route::post('/users/toggle-status', [SuperAdminController::class, 'toggleStatus'])->name('admin.users.toggle-status');
        Route::delete('/users/{user}', [SuperAdminController::class, 'destroyUser'])->name('admin.users.destroy');

        // SuperAdmin Dashboard
        Route::get('/dashboard', [SuperAdminController::class, 'welcome'])->name('superadmin.dashboard');
    });

    // =============================================
    // PRODUCT MANAGEMENT ROUTES
    // =============================================
    Route::prefix('products')->group(function () {
        // CRUD Routes
        Route::get('/', [ProductController::class, 'index'])->name('products.index');
        Route::get('/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/', [ProductController::class, 'store'])->name('products.store');
        Route::get('/{product}', [ProductController::class, 'show'])->name('products.show');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

        // Additional Features
        Route::post('/bulk-action', [ProductController::class, 'bulkAction'])->name('products.bulk-action');
        Route::post('/{product}/update-stock', [ProductController::class, 'updateStock'])->name('products.update-stock');
        Route::post('/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggle-status');
        Route::post('/{product}/toggle-featured', [ProductController::class, 'toggleFeatured'])->name('products.toggle-featured');
    });

    // =============================================
    // ADMIN SALES ROUTES
    // =============================================
    Route::prefix('sales-admin')->group(function () {
        Route::get('/dashboard', function () {
            if (auth()->user()->role !== 'adminsales') {
                abort(403, 'Unauthorized access.');
            }
            return view('adminsales.dashboard');
        })->name('adminsales.dashboard');
    });

    // =============================================
    // SALES ROUTES
    // =============================================
    Route::prefix('sales')->group(function () {
        Route::get('/dashboard', function () {
            if (auth()->user()->role !== 'sales') {
                abort(403, 'Unauthorized access.');
            }
            return view('sales.dashboard');
        })->name('sales.dashboard');
    });

    // =============================================
    // GENERAL DASHBOARD ROUTE (Auto-redirect based on role)
    // =============================================
    Route::get('/dashboard', function () {
        $user = auth()->user();

        switch ($user->role) {
            case 'superadmin':
                return redirect()->route('superadmin.dashboard');
            case 'adminsales':
                return redirect()->route('adminsales.dashboard');
            case 'sales':
                return redirect()->route('sales.dashboard');
            default:
                abort(403, 'Unknown user role.');
        }
    })->name('dashboard');

    // =============================================
    // WELCOME PAGES (Legacy - bisa dihapus jika tidak digunakan)
    // =============================================
    Route::get('/welcome', [SuperAdminController::class, 'welcome'])->name('superadmin.welcome');
    Route::get('/welcome2', function () {
        if (auth()->user()->role !== 'adminsales') {
            abort(403, 'Unauthorized access.');
        }
        return view('adminsales.dashboard');
    })->name('adminsales.welcome');

    Route::get('/welcome3', function () {
        if (auth()->user()->role !== 'sales') {
            abort(403, 'Unauthorized access.');
        }
        return view('sales.dashboard');
    })->name('sales.welcome');

});

// =============================================
// FALLBACK ROUTE
// =============================================
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});