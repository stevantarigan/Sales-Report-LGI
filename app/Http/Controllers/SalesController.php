<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\SalesTransaction;
use Illuminate\Http\Request;


class SalesController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $totalProducts = Product::count();
        $totalCustomers = Customer::count();
        $totalTransactions = SalesTransaction::count();

        return view('sales.dashboard', compact('totalProducts', 'totalCustomers', 'totalTransactions'));
    }

    // Products
    public function products(Request $request)
    {
        $userRole = auth()->user()->role;
        if (!in_array($userRole, ['superadmin', 'adminsales', 'sales'])) {
            abort(403, 'Unauthorized access.');
        }

        $query = Product::query();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('sku', 'like', '%' . $searchTerm . '%')
                    ->orWhere('category', 'like', '%' . $searchTerm . '%')
                    ->orWhere('brand', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // Filter by status
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

        // Sorting
        $sort = $request->get('sort', 'created_at');
        $sortDirection = 'desc';

        if ($sort == 'name') {
            $sortDirection = 'asc';
        } elseif ($sort == 'price' || $sort == 'stock_quantity') {
            $sortDirection = 'asc';
        }

        $query->orderBy($sort, $sortDirection);

        $products = $query->paginate(10);

        // Stats untuk dashboard
        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', true)->count();
        $lowStockProducts = Product::where('stock_quantity', '<=', \DB::raw('min_stock'))
            ->where('stock_quantity', '>', 0)
            ->count();
        $outOfStockProducts = Product::where('stock_quantity', 0)->count();

        // Get unique categories for filter dropdown
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
    // Customers
    public function customers(Request $request)
    {
        $userRole = auth()->user()->role;
        if (!in_array($userRole, ['superadmin', 'adminsales', 'sales'])) {
            abort(403, 'Unauthorized access.');
        }

        $query = Customer::withCount('transactions');

        // Search functionality
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

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $isActive = $request->status == 'active';
            $query->where('is_active', $isActive);
        }

        // Filter by phone availability
        if ($request->has('has_phone') && $request->has_phone != '') {
            if ($request->has_phone == 'yes') {
                $query->whereNotNull('phone')->where('phone', '!=', '');
            } elseif ($request->has_phone == 'no') {
                $query->where(function ($q) {
                    $q->whereNull('phone')->orWhere('phone', '');
                });
            }
        }

        // Sorting
        $sort = $request->get('sort', 'created_at');
        $sortDirection = 'desc';

        if ($sort == 'name' || $sort == 'city') {
            $sortDirection = 'asc';
        }

        $query->orderBy($sort, $sortDirection);

        $customers = $query->paginate(10);

        // Stats untuk dashboard
        $totalCustomers = $customers->total();
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
        $userRole = auth()->user()->role;
        if (!in_array($userRole, ['superadmin', 'adminsales', 'sales'])) {
            abort(403, 'Unauthorized access.');
        }

        $query = SalesTransaction::with(['user', 'customer', 'product']);

        // Search functionality
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
                    ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                        $userQuery->where('name', 'like', '%' . $searchTerm . '%');
                    })
                    ->orWhere('id', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->has('payment_status') && $request->payment_status != '') {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sorting
        $sort = $request->get('sort', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sort, $sortDirection);

        // Pagination
        $perPage = $request->get('per_page', 10);
        $transactions = $query->paginate($perPage);

        // Stats untuk dashboard
        $totalTransactions = SalesTransaction::count();
        $completedTransactions = SalesTransaction::where('status', 'completed')->count();
        $pendingTransactions = SalesTransaction::where('status', 'pending')->count();
        $cancelledTransactions = SalesTransaction::where('status', 'cancelled')->count();
        $totalRevenue = SalesTransaction::sum('total_price'); // field sesuai database

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