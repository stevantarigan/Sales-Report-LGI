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

        // Statistik
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalCustomers = Customer::count();
        $totalRevenue = SalesTransaction::sum('total_price');

        // Aktivitas terbaru
        $recentActivities = ActivityLog::latest()->limit(5)->get();

        // Transaksi terbaru
        $recentTransactions = SalesTransaction::with(['customer', 'product'])
            ->latest()->limit(5)->get();

        // Grafik penjualan per bulan
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
            'recentActivities',
            'recentTransactions',
            'salesChart'
        ));
    }

    // User Management Methods
    public function users()
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized access.');
        }

        $users = User::latest()->paginate(10);
        return view('superadmin.user.index', compact('users')); // DIUBAH: superadmin.user.index
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
    public function transactions()
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized access.');
        }

        $transactions = SalesTransaction::with(['user', 'customer', 'product'])
            ->latest()
            ->paginate(10);

        return view('superadmin.transactions.index', compact('transactions'));
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

}