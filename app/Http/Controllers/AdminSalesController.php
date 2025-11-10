<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Customer;
use App\Models\SalesTransaction;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AdminSalesController extends Controller
{
    public function welcome()
    {
        if (auth()->user()->role !== 'adminsales') {
            abort(403, 'Unauthorized access.');
        }

        // Basic stats - focus on sales team performance
        $totalUsers = User::count();
        $totalProducts = Product::where('is_active', true)->count();
        $totalCustomers = Customer::count();
        $totalRevenue = SalesTransaction::sum('total_price');

        // Sales team stats
        $salesTeam = User::where('role', 'sales')->where('is_active', true)->get();
        $totalSalesUsers = $salesTeam->count();
        $activeSalesUsers = $salesTeam->count(); // All are active

        // Monthly performance for sales team
        $currentMonthRevenue = SalesTransaction::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_price');

        $lastMonthRevenue = SalesTransaction::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('total_price');

        $currentMonthTransactions = SalesTransaction::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $lastMonthTransactions = SalesTransaction::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        // Sales performance data - focus on sales team only
        $salesPerformance = User::where('role', 'sales')
            ->where('is_active', true)
            ->withCount([
                'transactions' => function ($query) {
                    $query->whereMonth('created_at', now()->month);
                }
            ])
            ->withSum([
                'transactions' => function ($query) {
                    $query->whereMonth('created_at', now()->month);
                }
            ], 'total_price')
            ->get()
            ->map(function ($user) {
                $targetRevenue = 50000000; // 50 juta target per sales
                $achievedRevenue = $user->transactions_sum_total_price ?? 0;
                $performancePercentage = $targetRevenue > 0 ? ($achievedRevenue / $targetRevenue) * 100 : 0;

                return (object) [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'transactions_count' => $user->transactions_count,
                    'total_revenue' => $achievedRevenue,
                    'target_revenue' => $targetRevenue,
                    'performance_status' => $performancePercentage >= 100 ? 'exceeded' :
                        ($performancePercentage >= 80 ? 'met' : 'below'),
                    'performance_percentage' => $performancePercentage
                ];
            });

        // Average sales per person
        $averageSalesPerPerson = $totalSalesUsers > 0 ? $currentMonthRevenue / $totalSalesUsers : 0;
        $topPerformerRevenue = $salesPerformance->max('total_revenue') ?? 0;

        // Sales users for filter
        $salesUsers = User::where('role', 'sales')
            ->where('is_active', true)
            ->get(['id', 'name', 'email']);

        // Recent transactions from sales team
        $recentTransactions = SalesTransaction::with(['user', 'customer', 'product'])
            ->whereHas('user', function ($query) {
                $query->where('role', 'sales');
            })
            ->latest()
            ->limit(20)
            ->get();

        // Recent activities
        $recentActivities = ActivityLog::latest()->limit(10)->get();

        // Sales chart data
        $salesChartRaw = SalesTransaction::whereHas('user', function ($query) {
            $query->where('role', 'sales');
        })
            ->selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $months = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'May',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Aug',
            9 => 'Sep',
            10 => 'Oct',
            11 => 'Nov',
            12 => 'Dec'
        ];

        $salesChart = [];
        foreach ($months as $num => $name) {
            $salesChart[$name] = $salesChartRaw[$num] ?? 0;
        }

        return view('adminsales.dashboard', compact(
            'totalUsers',
            'totalProducts',
            'totalCustomers',
            'totalRevenue',
            'totalSalesUsers',
            'activeSalesUsers',
            'currentMonthRevenue',
            'lastMonthRevenue',
            'currentMonthTransactions',
            'lastMonthTransactions',
            'salesPerformance',
            'averageSalesPerPerson',
            'topPerformerRevenue',
            'salesUsers',
            'recentTransactions',
            'recentActivities',
            'salesChart',
            'salesTeam'
        ));
    }

    // =============================================
    // CUSTOMERS MANAGEMENT METHODS
    // =============================================

    public function customers(Request $request)
    {
        if (auth()->user()->role !== 'adminsales') {
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

        // Sorting
        $sort = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        if ($sort == 'name' || $sort == 'city') {
            $sortDirection = 'asc';
        }

        $query->orderBy($sort, $sortDirection);

        $customers = $query->paginate(10);

        // Stats untuk dashboard
        $totalCustomers = $customers->total();
        $activeCustomers = Customer::where('is_active', true)->count();
        $newCustomersThisMonth = Customer::where('created_at', '>=', now()->startOfMonth())->count();

        return view('adminsales.customers.index', compact(
            'customers',
            'totalCustomers',
            'activeCustomers',
            'newCustomersThisMonth'
        ));
    }

    public function createCustomer()
    {
        if (auth()->user()->role !== 'adminsales') {
            abort(403, 'Unauthorized access.');
        }

        return view('adminsales.customers.create');
    }

    public function storeCustomer(Request $request)
    {
        if (auth()->user()->role !== 'adminsales') {
            abort(403, 'Unauthorized access.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'company' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'company' => $request->company,
            'notes' => $request->notes,
            'is_active' => true,
        ]);

        return redirect()->route('adminsales.customers.index')
            ->with('success', 'Customer created successfully.');
    }

    public function showCustomer(Customer $customer)
    {
        if (auth()->user()->role !== 'adminsales') {
            abort(403, 'Unauthorized access.');
        }

        // Load customer transactions with sales user info
        $transactions = SalesTransaction::with(['user', 'product'])
            ->where('customer_id', $customer->id)
            ->whereHas('user', function ($query) {
                $query->where('role', 'sales');
            })
            ->latest()
            ->paginate(10);

        return view('adminsales.customers.show', compact('customer', 'transactions'));
    }

    public function editCustomer(Customer $customer)
    {
        if (auth()->user()->role !== 'adminsales') {
            abort(403, 'Unauthorized access.');
        }

        return view('adminsales.customers.edit', compact('customer'));
    }

    public function updateCustomer(Request $request, Customer $customer)
    {
        if (auth()->user()->role !== 'adminsales') {
            abort(403, 'Unauthorized access.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'company' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'company' => $request->company,
            'notes' => $request->notes,
        ]);

        return redirect()->route('adminsales.customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    // =============================================
    // SALES MANAGEMENT METHODS
    // =============================================

    public function sales(Request $request)
    {
        if (auth()->user()->role !== 'adminsales') {
            abort(403, 'Unauthorized access.');
        }

        $salesTeam = User::where('role', 'sales')->where('is_active', true)->get();

        $query = SalesTransaction::with(['user', 'customer', 'product'])
            ->whereIn('user_id', $salesTeam->pluck('id'));

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->whereHas('customer', function ($customerQuery) use ($searchTerm) {
                    $customerQuery->where('name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('email', 'like', '%' . $searchTerm . '%');
                })
                    ->orWhereHas('product', function ($productQuery) use ($searchTerm) {
                        $productQuery->where('name', 'like', '%' . $searchTerm . '%');
                    })
                    ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                        $userQuery->where('name', 'like', '%' . $searchTerm . '%');
                    });
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

        // Filter by sales person
        if ($request->has('user_id') && $request->user_id != '') {
            $query->where('user_id', $request->user_id);
        }

        // Sorting
        $sort = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        $query->orderBy($sort, $sortDirection);

        $transactions = $query->paginate(15);

        // Stats
        $totalSales = $transactions->total();
        $completedSales = SalesTransaction::whereIn('user_id', $salesTeam->pluck('id'))
            ->where('status', 'completed')
            ->count();
        $pendingSales = SalesTransaction::whereIn('user_id', $salesTeam->pluck('id'))
            ->where('status', 'pending')
            ->count();
        $totalRevenue = SalesTransaction::whereIn('user_id', $salesTeam->pluck('id'))
            ->where('status', 'completed')
            ->sum('total_price');

        return view('adminsales.sales.index', compact(
            'transactions',
            'salesTeam',
            'totalSales',
            'completedSales',
            'pendingSales',
            'totalRevenue'
        ));
    }

    public function createSale()
    {
        if (auth()->user()->role !== 'adminsales') {
            abort(403, 'Unauthorized access.');
        }

        $salesTeam = User::where('role', 'sales')->where('is_active', true)->get();
        $customers = Customer::where('is_active', true)->get();
        $products = Product::where('is_active', true)->get();

        return view('adminsales.sales.create', compact('salesTeam', 'customers', 'products'));
    }

    public function storeSale(Request $request)
    {
        if (auth()->user()->role !== 'adminsales') {
            abort(403, 'Unauthorized access.');
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'payment_status' => 'required|in:pending,paid,cancelled',
            'status' => 'required|in:pending,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Calculate total price
        $totalPrice = $request->quantity * $request->price;

        try {
            SalesTransaction::create([
                'user_id' => $request->user_id,
                'customer_id' => $request->customer_id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'total_price' => $totalPrice,
                'payment_status' => $request->payment_status,
                'status' => $request->status,
                'notes' => $request->notes,
            ]);

            return redirect()->route('adminsales.sales.index')
                ->with('success', 'Sales order created successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create sales order: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function showSale(SalesTransaction $sale)
    {
        if (auth()->user()->role !== 'adminsales') {
            abort(403, 'Unauthorized access.');
        }

        // Verify that the sale belongs to sales team
        $salesTeam = User::where('role', 'sales')->pluck('id');
        if (!$salesTeam->contains($sale->user_id)) {
            abort(403, 'Unauthorized access to this sales record.');
        }

        $sale->load(['user', 'customer', 'product']);

        return view('adminsales.sales.show', compact('sale'));
    }

    // =============================================
    // PRODUCT CATALOG METHODS
    // =============================================

    public function products(Request $request)
    {
        if (auth()->user()->role !== 'adminsales') {
            abort(403, 'Unauthorized access.');
        }

        $query = Product::where('is_active', true)
            ->withCount('transactions')
            ->withSum('transactions', 'quantity');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('sku', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // Filter by stock availability
        if ($request->has('stock') && $request->stock != '') {
            if ($request->stock == 'available') {
                $query->where('stock', '>', 0);
            } elseif ($request->stock == 'out_of_stock') {
                $query->where('stock', '<=', 0);
            }
        }

        // Sorting
        $sort = $request->get('sort', 'name');
        $sortDirection = $request->get('direction', 'asc');

        $query->orderBy($sort, $sortDirection);

        $products = $query->paginate(12);

        // Get unique categories for filter
        $categories = Product::where('is_active', true)
            ->distinct()
            ->pluck('category')
            ->filter()
            ->values();

        return view('adminsales.products.index', compact('products', 'categories'));
    }

    public function showProduct(Product $product)
    {
        if (auth()->user()->role !== 'adminsales') {
            abort(403, 'Unauthorized access.');
        }

        if (!$product->is_active) {
            abort(404, 'Product not found.');
        }

        // Get recent transactions for this product from sales team
        $recentTransactions = SalesTransaction::with(['user', 'customer'])
            ->where('product_id', $product->id)
            ->whereHas('user', function ($query) {
                $query->where('role', 'sales');
            })
            ->latest()
            ->limit(10)
            ->get();

        return view('adminsales.products.show', compact('product', 'recentTransactions'));
    }

    // =============================================
    // REPORTS METHODS
    // =============================================

    public function salesReport(Request $request)
    {
        if (auth()->user()->role !== 'adminsales') {
            abort(403, 'Unauthorized access.');
        }

        $salesTeam = User::where('role', 'sales')->where('is_active', true)->get();

        $query = SalesTransaction::with(['user', 'customer', 'product'])
            ->whereIn('user_id', $salesTeam->pluck('id'))
            ->where('status', 'completed');

        // Date range filter
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));

        $query->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59']);

        // Filter by sales person
        if ($request->has('user_id') && $request->user_id != '') {
            $query->where('user_id', $request->user_id);
        }

        $transactions = $query->get();

        // Summary statistics
        $totalRevenue = $transactions->sum('total_price');
        $totalTransactions = $transactions->count();
        $averageTransaction = $totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0;

        // Sales performance by user
        $salesPerformance = $transactions->groupBy('user_id')->map(function ($userTransactions) {
            $user = $userTransactions->first()->user;
            return [
                'user' => $user,
                'transaction_count' => $userTransactions->count(),
                'total_revenue' => $userTransactions->sum('total_price'),
                'average_revenue' => $userTransactions->avg('total_price')
            ];
        })->sortByDesc('total_revenue');

        return view('adminsales.reports.sales', compact(
            'transactions',
            'salesTeam',
            'totalRevenue',
            'totalTransactions',
            'averageTransaction',
            'salesPerformance',
            'dateFrom',
            'dateTo'
        ));
    }

    public function customersReport(Request $request)
    {
        if (auth()->user()->role !== 'adminsales') {
            abort(403, 'Unauthorized access.');
        }

        $salesTeam = User::where('role', 'sales')->where('is_active', true)->pluck('id');

        $query = Customer::withCount([
            'transactions' => function ($q) use ($salesTeam) {
                $q->whereIn('user_id', $salesTeam);
            }
        ])->withSum([
                    'transactions' => function ($q) use ($salesTeam) {
                        $q->whereIn('user_id', $salesTeam);
                    }
                ], 'total_price');

        // Date range filter
        $dateFrom = $request->get('date_from', now()->subMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));

        // Filter customers who have transactions in the date range
        $customerIds = SalesTransaction::whereIn('user_id', $salesTeam)
            ->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->pluck('customer_id')
            ->unique();

        $query->whereIn('id', $customerIds);

        $customers = $query->orderBy('transactions_sum_total_price', 'desc')
            ->paginate(15);

        return view('adminsales.reports.customers', compact(
            'customers',
            'dateFrom',
            'dateTo'
        ));
    }
}