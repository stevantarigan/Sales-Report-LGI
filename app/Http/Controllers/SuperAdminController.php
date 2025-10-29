<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SuperAdminController extends Controller
{
    public function welcome()
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized access.');
        }

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

        // Calculate metrics - SESUAIKAN DENGAN STRUCTURE is_active
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $newUsersThisMonth = User::whereMonth('created_at', now()->month)->count();
        $adminUsers = User::whereIn('role', ['superadmin', 'adminsales'])->count();

        // Calculate growth percentages
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

        return view('superadmin.dashboard', compact(
            'users',
            'totalUsers',
            'activeUsers',
            'newUsersThisMonth',
            'adminUsers',
            'userGrowth',
            'activeGrowth',
            'monthlyGrowth',
            'adminGrowth'
        ));
    }

    // User Management Methods
    public function users()
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized access.');
        }

        $users = User::latest()->paginate(10);
        return view('superadmin.users.index', compact('users'));
    }

    public function createUser()
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized access.');
        }

        return view('superadmin.users.create');
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

        return view('superadmin.users.edit', compact('user'));
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
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone' => $request->phone,
            'is_active' => $request->has('is_active'),
        ]);

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
}