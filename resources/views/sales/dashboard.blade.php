@extends('layouts.app3')

@section('title', 'Sales Dashboard')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-light: #818cf8;
            --secondary-color: #7c3aed;
            --accent-color: #8b5cf6;
            --light-color: #f8fafc;
            --dark-color: #1e293b;
            --success-color: #10b981;
            --error-color: #ef4444;
            --warning-color: #f59e0b;
            --info-color: #06b6d4;
            --card-bg: rgba(255, 255, 255, 0.95);
            --card-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-success: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --gradient-warning: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --gradient-danger: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            --gradient-info: linear-gradient(135deg, #a78bfa 0%, #7dd3fc 100%);
            --transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        /* Animated Background */
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.6;
        }

        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            background: var(--primary-light);
            opacity: 0.1;
            animation: float 8s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 10%;
            left: 5%;
            animation-delay: 0s;
            background: var(--primary-light);
        }

        .shape:nth-child(2) {
            width: 100px;
            height: 100px;
            top: 70%;
            left: 85%;
            animation-delay: 1s;
            background: var(--info-color);
        }

        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            top: 40%;
            left: 90%;
            animation-delay: 2s;
            background: var(--success-color);
        }

        .shape:nth-child(4) {
            width: 120px;
            height: 120px;
            top: 80%;
            left: 10%;
            animation-delay: 3s;
            background: var(--warning-color);
        }

        /* Header Section */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .header-title h2 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.25rem;
        }

        .header-title p {
            color: #64748b;
            margin: 0;
        }

        .role-badge {
            background: var(--gradient-primary);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
        }

        /* Quick Actions Section */
        .quick-actions-section {
            margin-bottom: 2rem;
        }

        .section-card {
            background: white;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        .section-header {
            background: var(--gradient-primary);
            color: white;
            padding: 1.25rem 1.5rem;
        }

        .section-header h5 {
            margin: 0;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .quick-actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            padding: 1.5rem;
        }

        .quick-action-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            transition: var(--transition);
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            display: block;
            height: 100%;
        }

        .quick-action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-color: var(--primary-color);
            text-decoration: none;
            color: inherit;
        }

        /* PERBAIKAN: Quick Action Icon - Pastikan semua ikon terlihat */
        .quick-action-icon {
            width: 70px;
            height: 70px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.75rem;
            margin: 0 auto 1rem;
            background: var(--gradient-primary);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.3);
            transition: var(--transition);
        }

        /* Warna khusus untuk setiap quick action */
        .quick-action-card:nth-child(1) .quick-action-icon {
            background: var(--gradient-success);
        }

        .quick-action-card:nth-child(2) .quick-action-icon {
            background: var(--gradient-info);
        }

        .quick-action-card:nth-child(3) .quick-action-icon {
            background: var(--gradient-warning);
        }

        .quick-action-card:hover .quick-action-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .quick-action-title {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
            font-size: 1rem;
        }

        .quick-action-description {
            font-size: 0.85rem;
            color: #64748b;
        }

        /* Statistics Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 1.8rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            transition: var(--transition);
            box-shadow: var(--card-shadow);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--gradient-primary);
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        /* PERBAIKAN: Stat Icon - Pastikan semua ikon statistik terlihat */
        .stat-icon {
            width: 80px;
            height: 80px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            background: var(--gradient-primary);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.3);
            transition: var(--transition);
            flex-shrink: 0;
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .stat-info {
            flex: 1;
        }

        .stat-title {
            font-size: 0.9rem;
            color: #64748b;
            font-weight: 500;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
            line-height: 1;
        }

        .stat-details {
            font-size: 0.8rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        /* Progress Bar */
        .progress {
            height: 8px;
            border-radius: 4px;
            background: #e2e8f0;
            overflow: hidden;
            margin-top: 0.5rem;
        }

        .progress-bar {
            height: 100%;
            border-radius: 4px;
            transition: width 0.6s ease;
            background: var(--gradient-warning);
        }

        /* Badges */
        .badge {
            padding: 0.5rem 0.8rem;
            border-radius: 8px;
            font-size: 0.7rem;
            font-weight: 600;
            transition: var(--transition);
        }

        .badge:hover {
            transform: scale(1.05);
        }

        .badge-success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .badge-warning {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning-color);
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        .badge-danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error-color);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .badge-secondary {
            background: rgba(100, 116, 139, 0.1);
            color: #64748b;
            border: 1px solid rgba(100, 116, 139, 0.2);
        }

        /* Content Sections */
        .content-section {
            margin-bottom: 2rem;
        }

        .content-card {
            background: white;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            border: 1px solid #e2e8f0;
            height: 100%;
            transition: var(--transition);
        }

        .content-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #e3e6f0;
            background: white;
        }

        .content-header h6 {
            margin: 0;
            font-weight: 600;
            color: var(--dark-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
        }

        .btn-primary {
            background: var(--gradient-primary);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.4);
        }

        .btn-success {
            background: var(--gradient-success);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
        }

        /* Table Styles */
        .table {
            margin: 0;
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead th {
            background: rgba(79, 70, 229, 0.05);
            border-bottom: 2px solid rgba(79, 70, 229, 0.1);
            padding: 1rem;
            font-weight: 600;
            color: var(--dark-color);
            font-size: 0.85rem;
        }

        .table tbody td {
            padding: 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
            vertical-align: middle;
            transition: var(--transition);
            font-size: 0.85rem;
        }

        .table tbody tr {
            transition: var(--transition);
        }

        .table tbody tr:hover {
            background: rgba(79, 70, 229, 0.03);
            transform: translateX(8px);
        }

        /* PERBAIKAN: Ikon dalam table */
        .table .fa-box,
        .table .fa-receipt,
        .table .fa-boxes {
            color: var(--primary-color);
            font-size: 1.1rem;
        }

        /* Chart Section */
        .chart-container {
            padding: 1.5rem;
        }

        /* Empty State Icons */
        .empty-state-icon {
            font-size: 3rem;
            color: #94a3b8;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        /* Animations */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .dashboard-header {
                flex-direction: column;
                align-items: stretch;
                gap: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .stat-card {
                flex-direction: column;
                text-align: center;
                padding: 1.25rem;
            }

            .stat-icon {
                margin-bottom: 0.75rem;
            }

            .quick-actions-grid {
                grid-template-columns: 1fr;
            }

            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 576px) {
            .header-title h2 {
                font-size: 1.5rem;
            }

            .role-badge {
                padding: 0.5rem 1rem;
                font-size: 0.8rem;
            }

            .stat-value {
                font-size: 2rem;
            }

            .table-responsive {
                font-size: 0.8rem;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Animated Background -->
    <div class="animated-bg">
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
    </div>

    <div class="container-fluid mt-4">
        <!-- Header -->
        <div class="dashboard-header">
            <div class="header-title">
                <h2>Dashboard Sales</h2>
                <p>Welcome back, {{ auth()->user()->name }}!</p>
            </div>
            <div class="d-flex align-items-center">
                <span class="role-badge">
                    <i class="fas fa-user me-1"></i>{{ auth()->user()->role }}
                </span>
            </div>
        </div>

        <!-- Quick Access Section - SEMUA ICON DIPERBAIKI -->
        <div class="quick-actions-section">
            <div class="section-card">
                <div class="section-header">
                    <h5><i class="fas fa-rocket me-2"></i>Quick Actions</h5>
                </div>
                <div class="quick-actions-grid">
                    <!-- Create Product -->
                    <a href="{{ route('sales.products.create') }}" class="quick-action-card">
                        <div class="quick-action-icon">
                            <i class="fas fa-cube"></i>
                        </div>
                        <div class="quick-action-title">Create Product</div>
                        <div class="quick-action-description">Add new product to catalog</div>
                    </a>

                    <!-- Create Customer -->
                    <a href="{{ route('sales.customers.create') }}" class="quick-action-card">
                        <div class="quick-action-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="quick-action-title">Create Customer</div>
                        <div class="quick-action-description">Register new customer</div>
                    </a>

                    <!-- Create Transaction -->
                    <a href="{{ route('sales.transactions.create') }}" class="quick-action-card">
                        <div class="quick-action-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="quick-action-title">Create Transaction</div>
                        <div class="quick-action-description">Process new sale</div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Statistics Grid - SEMUA ICON DIPERBAIKI -->
        <div class="stats-grid">
            <!-- Today's Performance -->
            <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-icon">
                    <i class="fas fa-sun"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-title">Today's Sales</div>
                    <div class="stat-value">{{ $todayTransactions }}</div>
                    <div class="stat-details text-success">
                        <i class="fas fa-coins me-1"></i>Rp {{ number_format($todayRevenue, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            <!-- Total Revenue -->
            <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-icon" style="background: var(--gradient-success);">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-title">Total Revenue</div>
                    <div class="stat-value">Rp {{ number_format($totalRevenue / 1000000, 1) }}JT</div>
                    <div class="stat-details text-muted">
                        <i class="fas fa-calendar me-1"></i>Rp {{ number_format($monthlyRevenue, 0, ',', '.') }} this month
                    </div>
                </div>
            </div>

            <!-- Total Transactions -->
            <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-icon" style="background: var(--gradient-info);">
                    <i class="fas fa-receipt"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-title">Total Transactions</div>
                    <div class="stat-value">{{ $totalTransactions }}</div>
                    <div class="stat-details">
                        <span class="badge badge-success">{{ $completedTransactions }} Completed</span>
                        <span class="badge badge-warning ms-1">{{ $pendingTransactions }} Pending</span>
                    </div>
                </div>
            </div>

            <!-- Performance Rate -->
            <div class="stat-card" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-icon" style="background: var(--gradient-warning);">
                    <i class="fas fa-trophy"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-title">Completion Rate</div>
                    <div class="stat-value">
                        @php
                            $completionRate =
                                $totalTransactions > 0 ? ($completedTransactions / $totalTransactions) * 100 : 0;
                        @endphp
                        {{ number_format($completionRate, 1) }}%
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: {{ $completionRate }}%"
                            aria-valuenow="{{ $completionRate }}" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Row Statistics - PERBAIKAN: Semua ikon sekarang muncul -->
        <div class="stats-grid">
            <!-- Monthly Transactions -->
            <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-icon" style="background: var(--gradient-primary);">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-title">This Month</div>
                    <div class="stat-value">{{ $monthlyTransactions }}</div>
                    <div class="stat-details text-muted">
                        <i class="fas fa-calendar-week me-1"></i>{{ $weeklyTransactions }} this week
                    </div>
                </div>
            </div>

            <!-- Payment Status -->
            <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-icon" style="background: var(--gradient-success);">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-title">Payment Status</div>
                    <div class="stat-value">{{ $paidTransactions }}</div>
                    <div class="stat-details text-danger">
                        <i class="fas fa-times-circle me-1"></i>{{ $unpaidTransactions }} Unpaid
                    </div>
                </div>
            </div>

            <!-- Products Overview - PERBAIKAN: Ikon sekarang muncul -->
            <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-icon" style="background: var(--gradient-info);">
                    <i class="fas fa-boxes"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-title">Products</div>
                    <div class="stat-value">{{ $totalProducts }}</div>
                    <div class="stat-details">
                        @if ($lowStockProducts > 0)
                            <span class="badge badge-warning me-1">{{ $lowStockProducts }} Low Stock</span>
                        @endif
                        @if ($outOfStockProducts > 0)
                            <span class="badge badge-danger">{{ $outOfStockProducts }} Out of Stock</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Customers -->
            <div class="stat-card" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-icon" style="background: var(--gradient-warning);">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-title">Total Customers</div>
                    <div class="stat-value">{{ $totalCustomers }}</div>
                    <div class="stat-details">
                        <a href="{{ route('sales.customers') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye me-1"></i>View All
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Recent Activity - SEMUA ICON DIPERBAIKI -->
        <div class="row content-section">
            <!-- Recent Transactions -->
            <div class="col-xl-6 col-lg-6 mb-4">
                <div class="content-card">
                    <div class="content-header">
                        <h6><i class="fas fa-history me-2"></i>Recent Transactions</h6>
                        <a href="{{ route('sales.transactions') }}" class="btn btn-primary">
                            <i class="fas fa-eye me-1"></i>View All
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Customer</th>
                                        <th>Product</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentTransactions as $transaction)
                                        <tr>
                                            <td>
                                                <strong>#{{ $transaction->id }}</strong>
                                                <br>
                                                <small
                                                    class="text-muted">{{ $transaction->created_at->format('M d') }}</small>
                                            </td>
                                            <td>
                                                <div>{{ $transaction->customer->name ?? 'N/A' }}</div>
                                                <small
                                                    class="text-muted">{{ $transaction->customer->company ?? '' }}</small>
                                            </td>
                                            <td>
                                                <div><i
                                                        class="fas fa-cube me-1 text-primary"></i>{{ Str::limit($transaction->product->name ?? 'N/A', 15) }}
                                                </div>
                                                <small class="text-muted">{{ $transaction->product->sku ?? '' }}</small>
                                            </td>
                                            <td class="fw-bold text-success">
                                                <i class="fas fa-coins me-1"></i>Rp
                                                {{ number_format($transaction->total_price, 0, ',', '.') }}
                                            </td>
                                            <td>
                                                <span
                                                    class="badge badge-{{ $transaction->status == 'completed' ? 'success' : ($transaction->status == 'pending' ? 'warning' : 'danger') }}">
                                                    <i
                                                        class="fas fa-{{ $transaction->status == 'completed' ? 'check' : ($transaction->status == 'pending' ? 'clock' : 'times') }} me-1"></i>
                                                    {{ ucfirst($transaction->status) }}
                                                </span>
                                                <br>
                                                <small
                                                    class="text-muted">{{ ucfirst($transaction->payment_status) }}</small>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                <i class="fas fa-receipt empty-state-icon"></i>
                                                <p>No recent transactions</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Products -->
            <div class="col-xl-6 col-lg-6 mb-4">
                <div class="content-card">
                    <div class="content-header">
                        <h6><i class="fas fa-star me-2"></i>Top Products</h6>
                        <a href="{{ route('sales.products') }}" class="btn btn-success">
                            <i class="fas fa-eye me-1"></i>View All
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topProducts as $product)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <i class="fas fa-box text-primary"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h6 class="mb-0 fs-6">{{ Str::limit($product->name, 25) }}</h6>
                                                        <small class="text-muted">{{ $product->sku }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="fw-bold">
                                                <i class="fas fa-tag me-1 text-success"></i>Rp
                                                {{ number_format($product->price, 0, ',', '.') }}
                                            </td>
                                            <td>
                                                <span
                                                    class="badge badge-{{ $product->stock_quantity == 0 ? 'danger' : ($product->stock_quantity <= $product->min_stock ? 'warning' : 'success') }}">
                                                    <i
                                                        class="fas fa-{{ $product->stock_quantity == 0 ? 'times' : ($product->stock_quantity <= $product->min_stock ? 'exclamation-triangle' : 'check') }} me-1"></i>
                                                    {{ $product->stock_quantity }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge badge-{{ $product->is_active ? 'success' : 'secondary' }}">
                                                    <i
                                                        class="fas fa-{{ $product->is_active ? 'play' : 'pause' }} me-1"></i>
                                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">
                                                <i class="fas fa-box empty-state-icon"></i>
                                                <p>No products available</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales Chart -->
        <div class="content-section">
            <div class="content-card">
                <div class="content-header">
                    <h6><i class="fas fa-chart-line me-2"></i>Sales Performance (Last 6 Months)</h6>
                </div>
                <div class="chart-container">
                    <canvas id="salesChart" height="80"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Sales Chart
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            const monthlySales = @json($monthlySales);

            const months = [];
            const salesData = [];
            const transactionCounts = [];

            // Prepare data for chart
            monthlySales.forEach(sale => {
                const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct',
                    'Nov', 'Dec'
                ];
                months.push(monthNames[sale.month - 1] + ' ' + sale.year);
                salesData.push(sale.total);
                transactionCounts.push(sale.count);
            });

            const salesChart = new Chart(salesCtx, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [{
                            label: 'Sales Revenue (Rp)',
                            data: salesData,
                            backgroundColor: 'rgba(79, 70, 229, 0.8)',
                            borderColor: 'rgba(79, 70, 229, 1)',
                            borderWidth: 2,
                            borderRadius: 5,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Transaction Count',
                            data: transactionCounts,
                            type: 'line',
                            fill: false,
                            borderColor: 'rgba(16, 185, 129, 1)',
                            backgroundColor: 'rgba(16, 185, 129, 0.2)',
                            borderWidth: 3,
                            tension: 0.4,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Revenue (Rp)'
                            },
                            grid: {
                                drawOnChartArea: true,
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'Transaction Count'
                            },
                            grid: {
                                drawOnChartArea: false,
                            },
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleFont: {
                                size: 14
                            },
                            bodyFont: {
                                size: 13
                            }
                        }
                    }
                }
            });

            // Add hover effects to cards
            const cards = document.querySelectorAll('.stat-card, .quick-action-card, .content-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = this.classList.contains('stat-card') ?
                        'translateY(-8px)' : 'translateY(-5px)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
@endpush
