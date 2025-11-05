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

class SuperAdminController extends Controller
{
    public function welcome()
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized access.');
        }

        // Basic stats
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalCustomers = Customer::count();
        $totalRevenue = SalesTransaction::sum('total_price');

        // Sales-specific stats
        $totalSalesUsers = User::whereIn('role', ['sales', 'adminsales'])->count();
        $activeSalesUsers = User::whereIn('role', ['sales', 'adminsales'])->where('is_active', true)->count();

        // Monthly performance
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

        // Sales performance data
        $salesPerformance = User::whereIn('role', ['sales', 'adminsales'])
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
                $targetRevenue = 100000000; // 100 juta target per sales
                $performancePercentage = ($user->transactions_sum_total_price / $targetRevenue) * 100;

                return (object) [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'transactions_count' => $user->transactions_count,
                    'total_revenue' => $user->transactions_sum_total_price,
                    'target_revenue' => $targetRevenue,
                    'performance_status' => $performancePercentage >= 100 ? 'exceeded' :
                        ($performancePercentage >= 80 ? 'met' : 'below'),
                    'performance_percentage' => $performancePercentage
                ];
            });

        // Average sales per person
        $averageSalesPerPerson = $currentMonthRevenue / max($activeSalesUsers, 1);
        $topPerformerRevenue = $salesPerformance->max('total_revenue');

        // Sales users for filter
        $salesUsers = User::whereIn('role', ['sales', 'adminsales'])
            ->where('is_active', true)
            ->get(['id', 'name', 'email']);

        // Recent transactions with sales info
        $recentTransactions = SalesTransaction::with(['user', 'customer', 'product'])
            ->latest()
            ->limit(20)
            ->get();

        // Recent activities
        $recentActivities = ActivityLog::latest()->limit(10)->get();

        // Sales chart data (for future use)
        $salesChartRaw = SalesTransaction::selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
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

        return view('superadmin.dashboard', compact(
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
            'salesChart'
        ));
    }

    // User Management Methods
    public function users(Request $request)
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized access.');
        }

        $query = User::query();

        // Filter berdasarkan role
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $isActive = $request->status == 'active';
            $query->where('is_active', $isActive);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = 'desc';

        if ($sortField == 'name' || $sortField == 'email') {
            $sortDirection = 'asc';
        }

        $users = $query->orderBy($sortField, $sortDirection)->paginate(10);

        return view('superadmin.user.index', compact('users'));
    }

    public function createUser()
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized access.');
        }

        return view('superadmin.user.create'); // DIUBAH: superadmin.user.create
    }

    public function storeUser(Request $request)
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized access.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:superadmin,adminsales,sales',
            'password' => 'required|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function editUser(User $user)
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized access.');
        }

        // For AJAX requests, return JSON
        if (request()->ajax()) {
            return response()->json([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $user->role,
                'is_active' => $user->is_active,
                'last_login_at' => $user->last_login_at,
                'created_at' => $user->created_at,
            ]);
        }

        return view('superadmin.user.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized access.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:superadmin,adminsales,sales',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            // Untuk AJAX request, return JSON errors
            if ($request->ajax()) {
                return response()->json([
                    'errors' => $validator->errors(),
                    'message' => 'Validation failed'
                ], 422);
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone' => $request->phone,
            'is_active' => $request->boolean('is_active'), // Gunakan boolean() untuk konsistensi
        ]);

        // Untuk AJAX request, return JSON success
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'User updated successfully!',
                'user' => $user
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }
    public function resetPassword(Request $request)
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['success' => true, 'message' => 'Password reset successfully.']);
    }

    public function toggleStatus(Request $request)
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->update([
            'is_active' => !$user->is_active,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User status updated.',
            'new_status' => $user->is_active ? 'active' : 'inactive'
        ]);
    }

    public function destroyUser(User $user)
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized access.');
        }

        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return redirect()->back()
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
    // Di SuperAdminController - ganti method transactions() dengan ini:
    public function transactions(Request $request)
    {
        if (auth()->user()->role !== 'superadmin') {
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

        // Filter by date range
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sorting
        $sort = $request->get('sort', 'created_at');
        $sortDirection = 'desc';

        $query->orderBy($sort, $sortDirection);

        $transactions = $query->paginate(10);

        // Stats untuk dashboard
        $totalTransactions = $transactions->total();
        $completedTransactions = SalesTransaction::where('status', 'completed')->count();
        $pendingTransactions = SalesTransaction::where('status', 'pending')->count();
        $cancelledTransactions = SalesTransaction::where('status', 'cancelled')->count();

        return view('superadmin.transactions.index', compact(
            'transactions',
            'totalTransactions',
            'completedTransactions',
            'pendingTransactions',
            'cancelledTransactions'
        ));
    }

    public function createTransaction()
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized access.');
        }

        $users = User::where('is_active', true)->get();
        $customers = Customer::all();
        $products = Product::all();

        return view('superadmin.transactions.create', compact('users', 'customers', 'products'));
    }

    public function storeTransaction(Request $request)
    {
        if (auth()->user()->role !== 'superadmin') {
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
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // TAMBAH VALIDASI FOTO
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Calculate total price
        $totalPrice = $request->quantity * $request->price;

        // Generate map link if coordinates exist - INI YANG DITAMBAH
        $mapLink = null;
        if (!empty($request->latitude) && !empty($request->longitude)) {
            $mapLink = "https://maps.google.com/?q={$request->latitude},{$request->longitude}";
        }

        // Handle photo upload - INI YANG DITAMBAH
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('transaction-photos', 'public');
        }

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
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'map_link' => $mapLink, // SIMPAN MAP LINK
                'photo' => $photoPath, // SIMPAN PATH FOTO
            ]);

            return redirect()->route('admin.transactions.index')
                ->with('success', 'Transaction created successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create transaction: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function showTransaction(SalesTransaction $transaction)
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized access.');
        }

        // Load relationships to avoid N+1 queries
        $transaction->load(['user', 'customer', 'product']);

        return view('superadmin.transactions.show', compact('transaction'));
    }

    public function editTransaction(SalesTransaction $transaction)
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized access.');
        }

        $users = User::where('is_active', true)->get();
        $customers = Customer::all();
        $products = Product::all();

        return view('superadmin.transactions.edit', compact('transaction', 'users', 'customers', 'products'));
    }

    public function updateTransaction(Request $request, SalesTransaction $transaction)
    {
        if (auth()->user()->role !== 'superadmin') {
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
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // TAMBAH VALIDASI FOTO
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Calculate total price
        $totalPrice = $request->quantity * $request->price;

        // Generate map link if coordinates exist - INI YANG DITAMBAH
        $mapLink = $transaction->map_link; // keep existing if no new coordinates
        if (!empty($request->latitude) && !empty($request->longitude)) {
            $mapLink = "https://maps.google.com/?q={$request->latitude},{$request->longitude}";
        }

        // Handle photo upload - INI YANG DITAMBAH
        $photoPath = $transaction->photo; // keep existing photo
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($transaction->photo && Storage::disk('public')->exists($transaction->photo)) {
                Storage::disk('public')->delete($transaction->photo);
            }
            $photoPath = $request->file('photo')->store('transaction-photos', 'public');
        }

        try {
            $transaction->update([
                'user_id' => $request->user_id,
                'customer_id' => $request->customer_id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'total_price' => $totalPrice,
                'payment_status' => $request->payment_status,
                'status' => $request->status,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'map_link' => $mapLink, // UPDATE MAP LINK
                'photo' => $photoPath, // UPDATE PATH FOTO
            ]);

            return redirect()->route('admin.transactions.index')
                ->with('success', 'Transaction updated successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update transaction: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroyTransaction(SalesTransaction $transaction)
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized access.');
        }

        $transaction->delete();

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaction deleted successfully.');
    }
    // Customers Management Methods
    // Di SuperAdminController - ganti method customers() dengan ini:
    // Di SuperAdminController
    public function customers(Request $request)
    {
        if (auth()->user()->role !== 'superadmin') {
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

        return view('superadmin.customers.index', compact(
            'customers',
            'totalCustomers',
            'customersWithPhone',
            'customersWithAddress',
            'newCustomersThisMonth'
        ));
    }

    public function createCustomer()
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized access.');
        }

        return view('superadmin.customers.create');
    }

    public function storeCustomer(Request $request)
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized access.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'company' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Customer::create($request->all());

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer created successfully.');
    }

    public function showCustomer(Customer $customer)
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized access.');
        }

        return view('superadmin.customers.show', compact('customer'));
    }

    public function editCustomer(Customer $customer)
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized access.');
        }

        return view('superadmin.customers.edit', compact('customer'));
    }

    public function updateCustomer(Request $request, Customer $customer)
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized access.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'company' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $customer->update($request->all());

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    public function destroyCustomer(Customer $customer)
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized access.');
        }

        $customer->delete();

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
    public function index(Request $request)
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized access.');
        }

        $query = User::query();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter by role
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $isActive = $request->status == 'active';
            $query->where('is_active', $isActive);
        }

        // Sorting
        $sort = $request->get('sort', 'created_at');
        $sortDirection = 'desc';

        if ($sort == 'name' || $sort == 'email') {
            $sortDirection = 'asc';
        }

        $query->orderBy($sort, $sortDirection);

        $users = $query->paginate(10);

        return view('superadmin.user.index', compact('users'));
    }

    // Method untuk export (opsional)
    private function exportUsers($users)
    {
        // Implementasi export ke Excel atau PDF
        // Contoh menggunakan Laravel Excel
        return Excel::download(new UsersExport($users), 'users-' . date('Y-m-d') . '.xlsx');
    }
}