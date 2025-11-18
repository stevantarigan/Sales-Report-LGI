<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\SalesTransaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    // Dashboard Lengkap
    public function dashboard()
    {
        $user = auth()->user();
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $startOfWeek = $now->copy()->startOfWeek();
        $startOfYear = $now->copy()->startOfYear();
        
        // Base query untuk transactions berdasarkan user
        $transactionQuery = SalesTransaction::query();
        $customerQuery = Customer::query();
        
        if ($user->role === 'sales') {
            // Filter transactions berdasarkan user_id jika kolom ada
            if (\Schema::hasColumn('sales_transactions', 'user_id')) {
                $transactionQuery->where('user_id', $user->id);
            }
        }

        // Data utama
        $totalProducts = Product::where('is_active', true)->count();
        $totalCustomers = $customerQuery->count();
        $totalTransactions = $transactionQuery->count();
        
        // Data periodik
        $monthlyTransactions = $transactionQuery->clone()
            ->where('created_at', '>=', $startOfMonth)
            ->count();
            
        $weeklyTransactions = $transactionQuery->clone()
            ->where('created_at', '>=', $startOfWeek)
            ->count();
            
        $yearlyTransactions = $transactionQuery->clone()
            ->where('created_at', '>=', $startOfYear)
            ->count();

        // Revenue
        $totalRevenue = $transactionQuery->clone()->sum('total_price');
        $monthlyRevenue = $transactionQuery->clone()
            ->where('created_at', '>=', $startOfMonth)
            ->sum('total_price');
            
        $weeklyRevenue = $transactionQuery->clone()
            ->where('created_at', '>=', $startOfWeek)
            ->sum('total_price');

        // Data untuk charts dan recent activity
        $recentTransactions = $transactionQuery->clone()
            ->with(['customer', 'product'])
            ->latest()
            ->take(6)
            ->get();

        // Top products - Query yang diperbaiki
        $topProductsQuery = Product::where('is_active', true)
            ->withCount(['salesTransactions as total_sold' => function($query) use ($user) {
                // Jika sales, filter berdasarkan user_id
                if ($user->role === 'sales' && \Schema::hasColumn('sales_transactions', 'user_id')) {
                    $query->where('user_id', $user->id);
                }
            }]);

        $topProducts = $topProductsQuery->orderBy('total_sold', 'desc')
            ->orderBy('name', 'asc')
            ->take(5)
            ->get();

        // Monthly sales data for chart - berdasarkan user
        $monthlySalesQuery = SalesTransaction::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(total_price) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths(6));
            
        if ($user->role === 'sales' && \Schema::hasColumn('sales_transactions', 'user_id')) {
            $monthlySalesQuery->where('user_id', $user->id);
        }
            
        $monthlySales = $monthlySalesQuery->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Transaction status counts - berdasarkan user
        $statusQuery = SalesTransaction::query();
        if ($user->role === 'sales' && \Schema::hasColumn('sales_transactions', 'user_id')) {
            $statusQuery->where('user_id', $user->id);
        }
        
        $completedTransactions = $statusQuery->clone()->where('status', 'completed')->count();
        $pendingTransactions = $statusQuery->clone()->where('status', 'pending')->count();
        $cancelledTransactions = $statusQuery->clone()->where('status', 'cancelled')->count();

        // Payment status counts - berdasarkan user
        $paidTransactions = $statusQuery->clone()->where('payment_status', 'paid')->count();
        $unpaidTransactions = $statusQuery->clone()->where('payment_status', 'unpaid')->count();

        // Low stock products (global, tidak berdasarkan user)
        $lowStockProducts = Product::where('stock_quantity', '<=', DB::raw('min_stock'))
            ->where('stock_quantity', '>', 0)
            ->where('is_active', true)
            ->count();

        $outOfStockProducts = Product::where('stock_quantity', 0)
            ->where('is_active', true)
            ->count();

        // Today's transactions - berdasarkan user
        $todayTransactions = $transactionQuery->clone()
            ->whereDate('created_at', today())
            ->count();
            
        $todayRevenue = $transactionQuery->clone()
            ->whereDate('created_at', today())
            ->sum('total_price');

        return view('sales.dashboard', compact(
            'totalProducts',
            'totalCustomers',
            'totalTransactions',
            'monthlyTransactions',
            'weeklyTransactions',
            'yearlyTransactions',
            'totalRevenue',
            'monthlyRevenue',
            'weeklyRevenue',
            'recentTransactions',
            'topProducts',
            'monthlySales',
            'completedTransactions',
            'pendingTransactions',
            'cancelledTransactions',
            'paidTransactions',
            'unpaidTransactions',
            'lowStockProducts',
            'outOfStockProducts',
            'todayTransactions',
            'todayRevenue'
        ));
    }

    // ... (methods products, customers, transactions, reports tetap sama)
    public function reports()
    {
        $user = auth()->user();
        return redirect()->route('sales.transactions');
    }

    public function products(Request $request)
    {
        $user = auth()->user();
        if (!in_array($user->role, ['superadmin', 'adminsales', 'sales'])) {
            abort(403, 'Unauthorized access.');
        }

        $query = Product::query();

        if ($user->role === 'sales') {
            $query->where('is_active', true);
        }

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('sku', 'like', '%' . $searchTerm . '%')
                    ->orWhere('category', 'like', '%' . $searchTerm . '%')
                    ->orWhere('brand', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        if ($request->has('status') && $request->status != '') {
            switch ($request->status) {
                case 'active':
                    $query->where('is_active', true);
                    break;
                case 'inactive':
                    $query->where('is_active', false);
                    break;
                case 'featured':
                    $query->where('is_featured', true);
                    break;
                case 'low_stock':
                    $query->where('stock_quantity', '<=', \DB::raw('min_stock'))
                        ->where('stock_quantity', '>', 0);
                    break;
                case 'out_of_stock':
                    $query->where('stock_quantity', 0);
                    break;
            }
        }

        $sort = $request->get('sort', 'created_at');
        $sortDirection = 'desc';

        if ($sort == 'name') {
            $sortDirection = 'asc';
        } elseif ($sort == 'price' || $sort == 'stock_quantity') {
            $sortDirection = 'asc';
        }

        $query->orderBy($sort, $sortDirection);

        $products = $query->paginate(10);

        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', true)->count();
        $lowStockProducts = Product::where('stock_quantity', '<=', \DB::raw('min_stock'))
            ->where('stock_quantity', '>', 0)
            ->count();
        $outOfStockProducts = Product::where('stock_quantity', 0)->count();

        $categories = Product::select('category')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category')
            ->toArray();

        return view('sales.products', compact(
            'products',
            'totalProducts',
            'activeProducts',
            'lowStockProducts',
            'outOfStockProducts',
            'categories'
        ));
    }

    public function customers(Request $request)
    {
        $user = auth()->user();
        if (!in_array($user->role, ['superadmin', 'adminsales', 'sales'])) {
            abort(403, 'Unauthorized access.');
        }

        $query = Customer::withCount('transactions');

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $searchTerm . '%')
                    ->orWhere('phone', 'like', '%' . $searchTerm . '%')
                    ->orWhere('city', 'like', '%' . $searchTerm . '%')
                    ->orWhere('company', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->has('status') && $request->status != '') {
            $isActive = $request->status == 'active';
            $query->where('is_active', $isActive);
        }

        if ($request->has('has_phone') && $request->has_phone != '') {
            if ($request->has_phone == 'yes') {
                $query->whereNotNull('phone')->where('phone', '!=', '');
            } elseif ($request->has_phone == 'no') {
                $query->where(function ($q) {
                    $q->whereNull('phone')->orWhere('phone', '');
                });
            }
        }

        $sort = $request->get('sort', 'created_at');
        $sortDirection = 'desc';

        if ($sort == 'name' || $sort == 'city') {
            $sortDirection = 'asc';
        }

        $query->orderBy($sort, $sortDirection);

        $customers = $query->paginate(10);

        $totalCustomers = Customer::count();
        $customersWithPhone = Customer::whereNotNull('phone')->where('phone', '!=', '')->count();
        $customersWithAddress = Customer::whereNotNull('address')->where('address', '!=', '')->count();
        $newCustomersThisMonth = Customer::where('created_at', '>=', now()->startOfMonth())->count();

        return view('sales.customers', compact(
            'customers',
            'totalCustomers',
            'customersWithPhone',
            'customersWithAddress',
            'newCustomersThisMonth'
        ));
    }

    public function transactions(Request $request)
    {
        $user = auth()->user();
        if (!in_array($user->role, ['superadmin', 'adminsales', 'sales'])) {
            abort(403, 'Unauthorized access.');
        }

        $query = SalesTransaction::with(['customer', 'product']);

        if ($user->role === 'sales' && \Schema::hasColumn('sales_transactions', 'user_id')) {
            $query->where('user_id', $user->id);
        }

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->whereHas('customer', function ($customerQuery) use ($searchTerm) {
                    $customerQuery->where('name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('email', 'like', '%' . $searchTerm . '%');
                })
                    ->orWhereHas('product', function ($productQuery) use ($searchTerm) {
                        $productQuery->where('name', 'like', '%' . $searchTerm . '%')
                            ->orWhere('sku', 'like', '%' . $searchTerm . '%');
                    })
                    ->orWhere('id', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('payment_status') && $request->payment_status != '') {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $sort = $request->get('sort', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sort, $sortDirection);

        $perPage = $request->get('per_page', 10);
        $transactions = $query->paginate($perPage);

        if ($user->role === 'sales' && \Schema::hasColumn('sales_transactions', 'user_id')) {
            $totalTransactions = SalesTransaction::where('user_id', $user->id)->count();
            $completedTransactions = SalesTransaction::where('user_id', $user->id)->where('status', 'completed')->count();
            $pendingTransactions = SalesTransaction::where('user_id', $user->id)->where('status', 'pending')->count();
            $cancelledTransactions = SalesTransaction::where('user_id', $user->id)->where('status', 'cancelled')->count();
            $totalRevenue = SalesTransaction::where('user_id', $user->id)->sum('total_price');
        } else {
            $totalTransactions = SalesTransaction::count();
            $completedTransactions = SalesTransaction::where('status', 'completed')->count();
            $pendingTransactions = SalesTransaction::where('status', 'pending')->count();
            $cancelledTransactions = SalesTransaction::where('status', 'cancelled')->count();
            $totalRevenue = SalesTransaction::sum('total_price');
        }

        return view('sales.transactions', compact(
            'transactions',
            'totalTransactions',
            'completedTransactions',
            'pendingTransactions',
            'cancelledTransactions',
            'totalRevenue'
        ));
    }
}