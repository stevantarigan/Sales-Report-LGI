<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminSalesController;

// =============================================
// PUBLIC ROUTES
// =============================================
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =============================================
// PROTECTED ROUTES - AUTHENTICATED USERS
// =============================================
Route::middleware(['auth'])->group(function () {

    // =============================================
    // SHARED ROUTES FOR SUPERADMIN & ADMINSALES
    // =============================================
    Route::middleware(['role:superadmin,adminsales'])->group(function () {

        // ADMIN ROUTES - menggunakan SuperAdminController untuk kedua role
        Route::prefix('admin')->name('admin.')->group(function () {

            // User Management Routes
            Route::prefix('users')->name('users.')->group(function () {
                Route::get('/', [SuperAdminController::class, 'users'])->name('index');
                Route::get('/create', [SuperAdminController::class, 'createUser'])->name('create');
                Route::post('/', [SuperAdminController::class, 'storeUser'])->name('store');
                Route::get('/{user}/edit', [SuperAdminController::class, 'editUser'])->name('edit');
                Route::put('/{user}', [SuperAdminController::class, 'updateUser'])->name('update');
                Route::post('/reset-password', [SuperAdminController::class, 'resetPassword'])->name('reset-password');
                Route::post('/toggle-status', [SuperAdminController::class, 'toggleStatus'])->name('toggle-status');
                Route::delete('/{user}', [SuperAdminController::class, 'destroyUser'])->name('destroy');
                Route::post('/bulk-action', [SuperAdminController::class, 'bulkAction'])->name('bulk-action');
                Route::post('/bulk-delete', [SuperAdminController::class, 'bulkDelete'])->name('bulk-delete');
            });

            // Customers Management Routes
            Route::prefix('customers')->name('customers.')->group(function () {
                Route::get('/', [SuperAdminController::class, 'customers'])->name('index');
                Route::get('/create', [SuperAdminController::class, 'createCustomer'])->name('create');
                Route::post('/', [SuperAdminController::class, 'storeCustomer'])->name('store');
                Route::get('/{customer}', [SuperAdminController::class, 'showCustomer'])->name('show');
                Route::get('/{customer}/edit', [SuperAdminController::class, 'editCustomer'])->name('edit');
                Route::put('/{customer}', [SuperAdminController::class, 'updateCustomer'])->name('update');
                Route::delete('/{customer}', [SuperAdminController::class, 'destroyCustomer'])->name('destroy');
                Route::post('/bulk-delete', [SuperAdminController::class, 'bulkDeleteCustomers'])->name('bulk-delete');
            });

            // Transaction Management Routes
            Route::prefix('transactions')->name('transactions.')->group(function () {
                Route::get('/', [SuperAdminController::class, 'transactions'])->name('index');
                Route::get('/create', [SuperAdminController::class, 'createTransaction'])->name('create');
                Route::post('/', [SuperAdminController::class, 'storeTransaction'])->name('store');
                Route::get('/{transaction}', [SuperAdminController::class, 'showTransaction'])->name('show');
                Route::get('/{transaction}/edit', [SuperAdminController::class, 'editTransaction'])->name('edit');
                Route::put('/{transaction}', [SuperAdminController::class, 'updateTransaction'])->name('update');
                Route::delete('/{transaction}', [SuperAdminController::class, 'destroyTransaction'])->name('destroy');
            });

            // Reports Routes
            Route::prefix('reports')->name('reports.')->group(function () {
                Route::get('/sales', [SuperAdminController::class, 'salesReport'])->name('sales');
                Route::get('/customers', [SuperAdminController::class, 'customersReport'])->name('customers');
            });

            // Dashboard untuk SuperAdmin
            Route::get('/dashboard', [SuperAdminController::class, 'welcome'])->name('dashboard');
        });

        // ADMINSALES ROUTES - juga menggunakan SuperAdminController
        Route::prefix('adminsales')->name('adminsales.')->group(function () {

            // Dashboard khusus untuk AdminSales
            Route::get('/dashboard', [AdminSalesController::class, 'welcome'])->name('dashboard');
            Route::get('/welcome', [AdminSalesController::class, 'welcome'])->name('welcome');

            // Route lainnya menggunakan SuperAdminController sama seperti di admin
            Route::prefix('customers')->name('customers.')->group(function () {
                Route::get('/', [SuperAdminController::class, 'customers'])->name('index');
                Route::get('/create', [SuperAdminController::class, 'createCustomer'])->name('create');
                Route::post('/', [SuperAdminController::class, 'storeCustomer'])->name('store');
                Route::get('/{customer}', [SuperAdminController::class, 'showCustomer'])->name('show');
                Route::get('/{customer}/edit', [SuperAdminController::class, 'editCustomer'])->name('edit');
                Route::put('/{customer}', [SuperAdminController::class, 'updateCustomer'])->name('update');
                Route::delete('/{customer}', [SuperAdminController::class, 'destroyCustomer'])->name('destroy');
                Route::post('/bulk-delete', [SuperAdminController::class, 'bulkDeleteCustomers'])->name('bulk-delete');
            });

            Route::prefix('transactions')->name('transactions.')->group(function () {
                Route::get('/', [SuperAdminController::class, 'transactions'])->name('index');
                Route::get('/create', [SuperAdminController::class, 'createTransaction'])->name('create');
                Route::post('/', [SuperAdminController::class, 'storeTransaction'])->name('store');
                Route::get('/{transaction}', [SuperAdminController::class, 'showTransaction'])->name('show');
                Route::get('/{transaction}/edit', [SuperAdminController::class, 'editTransaction'])->name('edit');
                Route::put('/{transaction}', [SuperAdminController::class, 'updateTransaction'])->name('update');
                Route::delete('/{transaction}', [SuperAdminController::class, 'destroyTransaction'])->name('destroy');
            });

            Route::prefix('reports')->name('reports.')->group(function () {
                Route::get('/sales', [SuperAdminController::class, 'salesReport'])->name('sales');
                Route::get('/customers', [SuperAdminController::class, 'customersReport'])->name('customers');
            });
        });

        // PRODUCT MANAGEMENT ROUTES (Shared: SuperAdmin & AdminSales)
        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');
            Route::get('/create', [ProductController::class, 'create'])->name('create');
            Route::post('/', [ProductController::class, 'store'])->name('store');
            Route::get('/{product}', [ProductController::class, 'show'])->name('show');
            Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
            Route::put('/{product}', [ProductController::class, 'update'])->name('update');
            Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
            Route::post('/bulk-action', [ProductController::class, 'bulkAction'])->name('bulk-action');
            Route::post('/{product}/update-stock', [ProductController::class, 'updateStock'])->name('update-stock');
        });
    });

    // =============================================
    // SALES ROUTES (Only for Sales)
    // =============================================
    Route::middleware(['role:sales'])->prefix('sales')->name('sales.')->group(function () {
        Route::get('/dashboard', function () {
            return view('sales.dashboard');
        })->name('dashboard');

        Route::get('/welcome', function () {
            return view('sales.dashboard');
        })->name('welcome');
    });

    // =============================================
    // WELCOME PAGES
    // =============================================
    Route::get('/welcome', [SuperAdminController::class, 'welcome'])->name('superadmin.welcome');


    Route::get('/welcome2', function () {
        $userRole = auth()->user()->role;
        if (!in_array($userRole, ['superadmin', 'adminsales'])) {
            abort(403, 'Unauthorized access. Your role: ' . $userRole);
        }
        return view('adminsales.dashboard');
    })->name('adminsales.welcome');

    Route::get('/welcome3', function () {
        if (auth()->user()->role !== 'sales') {
            abort(403, 'Unauthorized access. Your role: ' . auth()->user()->role);
        }
        return view('sales.dashboard');
    })->name('sales.welcome');

    // =============================================
    // GENERAL DASHBOARD ROUTE (Auto-redirect based on role)
    // =============================================
    Route::get('/dashboard', function () {
        $user = auth()->user();

        switch ($user->role) {
            case 'superadmin':
                return redirect()->route('superadmin.welcome');
            case 'adminsales':
                return redirect()->route('adminsales.welcome');
            case 'sales':
                return redirect()->route('sales.welcome');
            default:
                abort(403, 'Unknown user role.');
        }
    })->name('dashboard');
});

// =============================================
// FALLBACK ROUTE
// =============================================
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});