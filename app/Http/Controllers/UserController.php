<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
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

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:superadmin,adminsales,sales,user',
            'is_active' => 'boolean'
        ];

        // Only validate password if provided
        if ($request->filled('password')) {
            $rules['password'] = 'required|min:8|confirmed';
        }

        $validated = $request->validate($rules);

        // Update user data
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;
        $user->role = $validated['role'];
        $user->is_active = $request->boolean('is_active');

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        if ($request->ajax()) {
            return response()->json([
                'message' => 'User updated successfully!',
                'user' => $user
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }
}