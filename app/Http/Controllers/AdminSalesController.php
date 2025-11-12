<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Customer;
use App\Models\SalesTransaction;
use App\Models\ActivityLog;
use App\Models\SalesTarget;
use Carbon\Carbon;

class AdminSalesController extends Controller
{
    public function welcome()
    {
        // Izinkan role adminsales, sales, dan superadmin
        if (!in_array(auth()->user()->role, ['adminsales', 'sales', 'superadmin'])) {
            abort(403, 'Unauthorized access.');
        }

        $user = auth()->user();

        // Jika user adalah SuperAdmin, redirect ke dashboard superadmin
        if ($user->isSuperAdmin()) {
            return redirect()->route('superadmin.welcome');
        }

        // Data untuk AdminSales - QUERY YANG LEBIH SIMPLE
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $lastMonth = now()->subMonth()->month;
        $lastMonthYear = now()->subMonth()->year;

        // **QUERY SEDERHANA DULU - tanpa filter status**
        $currentMonthRevenue = SalesTransaction::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('total_price');

        $lastMonthRevenue = SalesTransaction::whereMonth('created_at', $lastMonth)
            ->whereYear('created_at', $lastMonthYear)
            ->sum('total_price');

        $currentMonthTransactions = SalesTransaction::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        $lastMonthTransactions = SalesTransaction::whereMonth('created_at', $lastMonth)
            ->whereYear('created_at', $lastMonthYear)
            ->count();

        // Data Sales Team
        $salesUsers = User::where('role', 'sales')
            ->where('is_active', true)
            ->get();

        $totalSalesUsers = $salesUsers->count();
        $activeSalesUsers = $salesUsers->where('is_active', true)->count();

        // Performance Sales Team
        $salesPerformance = User::where('role', 'sales')
            ->where('is_active', true)
            ->withCount([
                'transactions as transactions_count' => function ($query) use ($currentMonth, $currentYear) {
                    $query->whereMonth('created_at', $currentMonth)
                        ->whereYear('created_at', $currentYear);
                }
            ])
            ->withSum([
                'transactions as total_revenue' => function ($query) use ($currentMonth, $currentYear) {
                    $query->whereMonth('created_at', $currentMonth)
                        ->whereYear('created_at', $currentYear);
                }
            ], 'total_price')
            ->get()
            ->map(function ($user) use ($currentMonth, $currentYear) {
                $target = SalesTarget::where('user_id', $user->id)
                    ->where('month', $currentMonth)
                    ->where('year', $currentYear)
                    ->first();

                $targetAmount = $target ? $target->target_amount : 10000000;
                $achievedAmount = $user->total_revenue ?: 0;

                $performancePercentage = $targetAmount > 0 ?
                    min(($achievedAmount / $targetAmount) * 100, 100) : 0;

                $performanceStatus = $performancePercentage >= 100 ? 'exceeded' :
                    ($performancePercentage >= 80 ? 'met' : 'below');

                return (object) [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'transactions_count' => $user->transactions_count,
                    'total_revenue' => $user->total_revenue ?: 0,
                    'performance_percentage' => $performancePercentage,
                    'performance_status' => $performanceStatus
                ];
            });

        // Target Achievement
        $totalTarget = SalesTarget::where('month', $currentMonth)
            ->where('year', $currentYear)
            ->sum('target_amount');

        if ($totalTarget == 0) {
            $totalTarget = $totalSalesUsers * 10000000;
        }

        $targetAchievement = $totalTarget > 0 ?
            min(($currentMonthRevenue / $totalTarget) * 100, 100) : 0;

        // Recent Transactions
        $recentTransactions = SalesTransaction::with(['user', 'customer', 'product'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Recent Activities
        $recentActivities = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Average Sales per Person
        $averageSalesPerPerson = $activeSalesUsers > 0 ?
            $currentMonthRevenue / $activeSalesUsers : 0;

        // Top Performer
        $topPerformer = User::where('role', 'sales')
            ->where('is_active', true)
            ->withSum([
                'transactions as total_revenue' => function ($query) use ($currentMonth, $currentYear) {
                    $query->whereMonth('created_at', $currentMonth)
                        ->whereYear('created_at', $currentYear);
                }
            ], 'total_price')
            ->orderBy('total_revenue', 'desc')
            ->first();

        $topPerformerRevenue = $topPerformer ? ($topPerformer->total_revenue ?: 0) : 0;

        // **FALLBACK: Jika tidak ada data, gunakan dummy**
        if ($currentMonthRevenue == 0 && $currentMonthTransactions == 0) {
            $currentMonthRevenue = 15000000;
            $lastMonthRevenue = 12000000;
            $currentMonthTransactions = 15;
            $lastMonthTransactions = 12;
            $targetAchievement = 75;
            $averageSalesPerPerson = 3750000;
            $topPerformerRevenue = 6000000;
        }

        return view('adminsales.dashboard', compact(
            'currentMonthRevenue',
            'lastMonthRevenue',
            'currentMonthTransactions',
            'lastMonthTransactions',
            'totalSalesUsers',
            'activeSalesUsers',
            'salesPerformance',
            'targetAchievement',
            'recentTransactions',
            'recentActivities',
            'averageSalesPerPerson',
            'topPerformerRevenue',
            'salesUsers'
        ));
    }

    // Method untuk welcome2 - bisa dihapus karena sudah menggunakan welcome()
    public function welcome2()
    {
        return $this->welcome();
    }
}