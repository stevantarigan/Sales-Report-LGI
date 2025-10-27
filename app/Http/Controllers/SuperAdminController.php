<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SuperAdminController extends Controller
{
    public function welcome()
    {
        // Get all users with pagination
        $users = User::query();

        // Search functionality
        if (request('search')) {
            $search = request('search');
            $users->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $users->orderBy('created_at', 'desc')->paginate(10);

        // Calculate metrics
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $newUsersThisMonth = User::whereMonth('created_at', now()->month)->count();
        $adminUsers = User::whereIn('role', ['superadmin', 'adminsales'])->count();

        // Calculate growth percentages (you might want to store these in cache)
        $previousMonthUsers = User::whereMonth('created_at', now()->subMonth()->month)->count();
        $userGrowth = $previousMonthUsers > 0 ? round((($totalUsers - $previousMonthUsers) / $previousMonthUsers) * 100, 1) : 100;

        $previousActiveUsers = User::where('is_active', true)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->count();
        $activeGrowth = $previousActiveUsers > 0 ? round((($activeUsers - $previousActiveUsers) / $previousActiveUsers) * 100, 1) : 100;

        $previousMonthNewUsers = User::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        $monthlyGrowth = $previousMonthNewUsers > 0 ? round((($newUsersThisMonth - $previousMonthNewUsers) / $previousMonthNewUsers) * 100, 1) : 100;

        $previousAdminUsers = User::whereIn('role', ['superadmin', 'adminsales'])
            ->whereMonth('created_at', now()->subMonth()->month)
            ->count();
        $adminGrowth = $previousAdminUsers > 0 ? $adminUsers - $previousAdminUsers : $adminUsers;

        // Get recent activities (you might want to create an activities table)
        $recentActivities = collect([
            (object) [
                'description' => 'New user registered: ' . User::latest()->first()->name,
                'created_at' => User::latest()->first()->created_at
            ],
            (object) [
                'description' => 'System backup completed',
                'created_at' => now()->subHours(1)
            ],
            (object) [
                'description' => 'Monthly user report generated',
                'created_at' => now()->subHours(3)
            ]
        ]);

        return view('welcome', compact(
            'users',
            'totalUsers',
            'activeUsers',
            'newUsersThisMonth',
            'adminUsers',
            'userGrowth',
            'activeGrowth',
            'monthlyGrowth',
            'adminGrowth',
            'recentActivities'
        ));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:superadmin,adminsales,sales',
            'phone' => 'nullable|string'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('superadmin.welcome')->with('success', 'User created successfully.');
    }

    public function resetPassword(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->update([
            'password' => bcrypt('password123') // Default password, you might want to generate a random one
        ]);

        return response()->json(['success' => true]);
    }

    public function toggleStatus(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->update([
            'is_active' => !$user->is_active
        ]);

        return response()->json(['success' => true]);
    }

    public function destroyUser(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Cannot delete your own account.']);
        }

        $user->delete();

        return response()->json(['success' => true]);
    }
    public function updateUser(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:superadmin,adminsales,sales',
            'phone' => 'nullable|string',
            'password' => 'nullable|min:8'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone' => $request->phone,
            'is_active' => $request->has('is_active'),
        ]);

        if ($request->password) {
            $user->update([
                'password' => bcrypt($request->password)
            ]);
        }

        return redirect()->route('superadmin.welcome')->with('success', 'User updated successfully.');
    }
}