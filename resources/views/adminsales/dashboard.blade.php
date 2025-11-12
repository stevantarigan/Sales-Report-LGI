@extends('layouts.app2')

@section('title', 'Dashboard AdminSales | Sales Management')
@section('page-title', 'Dashboard Overview')
@section('page-description', 'Selamat datang kembali, ' . auth()->user()->name . '. Monitor kinerja dan aktivitas
    sales.')

    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            :root {
                --primary-color: #3b82f6;
                --primary-light: #60a5fa;
                --secondary-color: #6366f1;
                --accent-color: #8b5cf6;
                --light-color: #f8fafc;
                --dark-color: #1e293b;
                --success-color: #10b981;
                --error-color: #ef4444;
                --warning-color: #f59e0b;
                --info-color: #06b6d4;
                --card-bg: rgba(255, 255, 255, 0.95);
                --card-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
                --gradient-primary: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
                --gradient-secondary: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
                --gradient-success: linear-gradient(135deg, #10b981 0%, #059669 100%);
                --gradient-warning: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
                --gradient-danger: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
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

            /* Metrics Grid */
            .metrics-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 1.5rem;
                margin-bottom: 2rem;
            }

            .metric-card {
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

            .metric-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 4px;
                background: var(--gradient-primary);
            }

            .metric-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            }

            .metric-icon {
                width: 80px;
                height: 80px;
                border-radius: 16px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 2rem;
                background: var(--gradient-primary);
                box-shadow: 0 6px 20px rgba(59, 130, 246, 0.3);
                transition: var(--transition);
            }

            .metric-card:hover .metric-icon {
                transform: scale(1.1) rotate(5deg);
            }

            .metric-info {
                flex: 1;
            }

            .metric-title {
                font-size: 0.9rem;
                color: #64748b;
                font-weight: 500;
                margin-bottom: 0.5rem;
            }

            .metric-value {
                font-size: 2.5rem;
                font-weight: 700;
                color: var(--dark-color);
                margin-bottom: 0.5rem;
                line-height: 1;
            }

            .metric-trend {
                font-size: 0.8rem;
                font-weight: 600;
                display: flex;
                align-items: center;
                gap: 0.3rem;
            }

            .trend-up {
                color: var(--success-color);
            }

            .trend-down {
                color: var(--error-color);
            }

            /* Sales Performance Section */
            .sales-performance {
                background: white;
                border-radius: 16px;
                padding: 1.5rem;
                box-shadow: var(--card-shadow);
                margin-bottom: 2rem;
            }

            .performance-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 1.5rem;
                flex-wrap: wrap;
                gap: 1rem;
            }

            .filter-controls {
                display: flex;
                gap: 1rem;
                align-items: center;
                flex-wrap: wrap;
            }

            .form-select {
                border: 1px solid #e2e8f0;
                border-radius: 10px;
                padding: 0.5rem 1rem;
                min-width: 200px;
            }

            /* Sales Grid */
            .sales-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 1.5rem;
                margin-bottom: 2rem;
            }

            .sales-card {
                background: white;
                border: 1px solid #e2e8f0;
                border-radius: 16px;
                padding: 1.5rem;
                transition: var(--transition);
                box-shadow: var(--card-shadow);
            }

            .sales-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            }

            .sales-header {
                display: flex;
                align-items: center;
                gap: 1rem;
                margin-bottom: 1rem;
            }

            .sales-avatar {
                width: 60px;
                height: 60px;
                border-radius: 50%;
                background: var(--gradient-primary);
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 1.5rem;
                font-weight: 600;
            }

            .sales-info {
                flex: 1;
            }

            .sales-name {
                font-weight: 600;
                color: var(--dark-color);
                margin-bottom: 0.25rem;
            }

            .sales-role {
                font-size: 0.8rem;
                color: #64748b;
            }

            .sales-stats {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
                margin-top: 1rem;
            }

            .stat-item {
                text-align: center;
                padding: 0.75rem;
                background: #f8fafc;
                border-radius: 10px;
            }

            .stat-value {
                font-size: 1.5rem;
                font-weight: 700;
                color: var(--primary-color);
                display: block;
            }

            .stat-label {
                font-size: 0.75rem;
                color: #64748b;
            }

            /* Transactions Section */
            .transactions-section {
                background: white;
                border-radius: 16px;
                padding: 1.5rem;
                box-shadow: var(--card-shadow);
                margin-bottom: 2rem;
            }

            .section-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 1.5rem;
                flex-wrap: wrap;
                gap: 1rem;
            }

            .section-title {
                font-size: 1.25rem;
                font-weight: 600;
                color: var(--dark-color);
                margin: 0;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            /* Table Styles */
            .table {
                margin: 0;
                width: 100%;
            }

            .table th {
                background: rgba(59, 130, 246, 0.05);
                border-bottom: 2px solid rgba(59, 130, 246, 0.1);
                padding: 1rem;
                font-weight: 600;
                color: var(--dark-color);
                font-size: 0.85rem;
            }

            .table td {
                padding: 1rem;
                border-bottom: 1px solid rgba(0, 0, 0, 0.04);
                vertical-align: middle;
                transition: var(--transition);
            }

            .table tbody tr {
                transition: var(--transition);
            }

            .table tbody tr:hover {
                background: rgba(59, 130, 246, 0.03);
                transform: translateX(8px);
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

            .badge-primary {
                background: rgba(59, 130, 246, 0.1);
                color: var(--primary-color);
                border: 1px solid rgba(59, 130, 246, 0.2);
            }

            /* Progress Bar */
            .progress {
                height: 8px;
                border-radius: 4px;
                background: #e2e8f0;
                overflow: hidden;
            }

            .progress-bar {
                height: 100%;
                border-radius: 4px;
                transition: width 0.6s ease;
            }

            /* Quick Actions */
            .quick-actions {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1rem;
                margin-bottom: 2rem;
            }

            .action-card {
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
            }

            .action-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
                border-color: var(--primary-color);
                text-decoration: none;
                color: inherit;
            }

            .action-icon {
                width: 50px;
                height: 50px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 1.5rem;
                background: var(--gradient-primary);
                margin: 0 auto 1rem;
            }

            .action-title {
                font-weight: 600;
                color: var(--dark-color);
                margin-bottom: 0.5rem;
            }

            .action-description {
                font-size: 0.85rem;
                color: #64748b;
            }

            /* Activity Feed */
            .activity-feed {
                background: white;
                border-radius: 16px;
                padding: 1.5rem;
                box-shadow: var(--card-shadow);
                margin-bottom: 2rem;
            }

            .activity-item {
                display: flex;
                align-items: flex-start;
                gap: 1rem;
                padding: 1rem 0;
                border-bottom: 1px solid #f1f5f9;
            }

            .activity-item:last-child {
                border-bottom: none;
            }

            .activity-icon {
                width: 40px;
                height: 40px;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 1rem;
                background: var(--gradient-primary);
                flex-shrink: 0;
            }

            .activity-content {
                flex: 1;
            }

            .activity-text {
                margin-bottom: 0.25rem;
                font-size: 0.9rem;
            }

            .activity-time {
                font-size: 0.75rem;
                color: #64748b;
            }

            /* Product Details Popover */
            .product-details-popover .popover {
                max-width: 400px;
            }

            .product-details-popover .popover-header {
                background: var(--primary-color);
                color: white;
                border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            }

            .product-list {
                max-height: 200px;
                overflow-y: auto;
                margin: 0;
                padding-left: 1rem;
            }

            .product-list li {
                margin-bottom: 0.5rem;
                font-size: 0.85rem;
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
                .metrics-grid {
                    grid-template-columns: 1fr;
                    gap: 1rem;
                }

                .metric-card {
                    flex-direction: column;
                    text-align: center;
                    padding: 1.25rem;
                }

                .metric-icon {
                    margin-bottom: 0.75rem;
                }

                .sales-grid {
                    grid-template-columns: 1fr;
                }

                .performance-header {
                    flex-direction: column;
                    align-items: stretch;
                }

                .filter-controls {
                    justify-content: center;
                }

                .section-header {
                    flex-direction: column;
                    align-items: stretch;
                }

                .quick-actions {
                    grid-template-columns: repeat(2, 1fr);
                }
            }

            @media (max-width: 576px) {
                .sales-stats {
                    grid-template-columns: 1fr;
                }

                .quick-actions {
                    grid-template-columns: 1fr;
                }

                .table-responsive {
                    font-size: 0.8rem;
                }
            }

            /* Loading States */
            .loading {
                opacity: 0.7;
                pointer-events: none;
            }

            .spinner {
                border: 3px solid #f3f3f3;
                border-top: 3px solid var(--primary-color);
                border-radius: 50%;
                width: 30px;
                height: 30px;
                animation: spin 1s linear infinite;
                margin: 0 auto;
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }

            /* Debug Info */
            .debug-info {
                background: #f8f9fa;
                border-left: 4px solid var(--primary-color);
                padding: 1rem;
                margin-bottom: 1rem;
                border-radius: 4px;
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

    {{-- <!-- Debug Info (Sementara) -->
    <div class="debug-info">
        <h4>Debug Info:</h4>
        <p>Current Month Revenue: Rp {{ number_format($currentMonthRevenue ?? 0, 0, ',', '.') }}</p>
        <p>Current Month Transactions: {{ $currentMonthTransactions ?? 0 }}</p>
        <p>Total Sales Users: {{ $totalSalesUsers ?? 0 }}</p>
        <p>Recent Transactions Count: {{ $recentTransactions->count() ?? 0 }}</p>
        <p>User Role: {{ auth()->user()->role }}</p>
    </div> --}}

    <!-- Quick Actions -->
    <div class="quick-actions">
        <a href="{{ route('admin.transactions.create') }}" class="action-card" data-aos="fade-up" data-aos-delay="100">
            <div class="action-icon">
                <i class="fas fa-plus-circle"></i>
            </div>
            <div class="action-title">Tambah Transaksi</div>
            <div class="action-description">Input transaksi baru untuk sales</div>
        </a>

        <a href="{{ route('admin.transactions.index') }}" class="action-card" data-aos="fade-up" data-aos-delay="200">
            <div class="action-icon">
                <i class="fas fa-list"></i>
            </div>
            <div class="action-title">Kelola Transaksi</div>
            <div class="action-description">Lihat dan kelola semua transaksi</div>
        </a>

        <a href="{{ route('admin.customers.index') }}" class="action-card" data-aos="fade-up" data-aos-delay="300">
            <div class="action-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="action-title">Data Customer</div>
            <div class="action-description">Kelola data pelanggan</div>
        </a>

        <a href="{{ route('products.index') }}" class="action-card" data-aos="fade-up" data-aos-delay="400">
            <div class="action-icon">
                <i class="fas fa-box"></i>
            </div>
            <div class="action-title">Produk</div>
            <div class="action-description">Lihat katalog produk</div>
        </a>
    </div>

    <!-- Metrics Grid -->
    <div class="metrics-grid">
        <div class="metric-card" data-aos="fade-up" data-aos-delay="100">
            <div class="metric-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="metric-info">
                <div class="metric-title">Total Penjualan Bulan Ini</div>
                <div class="metric-value">Rp
                    {{ isset($currentMonthRevenue) ? number_format($currentMonthRevenue / 1000000, 1) : '0' }}JT</div>
                <div
                    class="metric-trend {{ ($currentMonthRevenue ?? 0) >= ($lastMonthRevenue ?? 0) ? 'trend-up' : 'trend-down' }}">
                    <i
                        class="fas fa-arrow-{{ ($currentMonthRevenue ?? 0) >= ($lastMonthRevenue ?? 0) ? 'up' : 'down' }}"></i>
                    {{ isset($currentMonthRevenue) && isset($lastMonthRevenue) && $lastMonthRevenue > 0
                        ? round((($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100)
                        : 0 }}%
                    vs last month
                </div>
            </div>
        </div>

        <div class="metric-card" data-aos="fade-up" data-aos-delay="200">
            <div class="metric-icon" style="background: var(--gradient-success);">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="metric-info">
                <div class="metric-title">Transaksi Bulan Ini</div>
                <div class="metric-value">{{ $currentMonthTransactions ?? 0 }}</div>
                <div
                    class="metric-trend {{ ($currentMonthTransactions ?? 0) >= ($lastMonthTransactions ?? 0) ? 'trend-up' : 'trend-down' }}">
                    <i
                        class="fas fa-arrow-{{ ($currentMonthTransactions ?? 0) >= ($lastMonthTransactions ?? 0) ? 'up' : 'down' }}"></i>
                    {{ isset($currentMonthTransactions) && isset($lastMonthTransactions) && $lastMonthTransactions > 0
                        ? round((($currentMonthTransactions - $lastMonthTransactions) / $lastMonthTransactions) * 100)
                        : 0 }}%
                    growth
                </div>
            </div>
        </div>

        <div class="metric-card" data-aos="fade-up" data-aos-delay="300">
            <div class="metric-icon" style="background: var(--gradient-warning);">
                <i class="fas fa-users"></i>
            </div>
            <div class="metric-info">
                <div class="metric-title">Total Sales Aktif</div>
                <div class="metric-value">{{ $activeSalesUsers ?? 0 }}</div>
                <div class="metric-trend trend-up">
                    <i class="fas fa-arrow-up"></i>
                    {{ $totalSalesUsers ?? 0 }} total sales
                </div>
            </div>
        </div>

        <div class="metric-card" data-aos="fade-up" data-aos-delay="400">
            <div class="metric-icon" style="background: var(--gradient-danger);">
                <i class="fas fa-percentage"></i>
            </div>
            <div class="metric-info">
                <div class="metric-title">Target Achievement</div>
                <div class="metric-value">{{ isset($targetAchievement) ? round($targetAchievement) : '0' }}%</div>
                <div class="metric-trend {{ ($targetAchievement ?? 0) >= 100 ? 'trend-up' : 'trend-down' }}">
                    <i class="fas fa-arrow-{{ ($targetAchievement ?? 0) >= 100 ? 'up' : 'down' }}"></i>
                    {{ ($targetAchievement ?? 0) >= 100 ? 'Target tercapai' : 'Belum mencapai target' }}
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Performance Section -->
    <div class="sales-performance" data-aos="fade-up" data-aos-delay="500">
        <div class="performance-header">
            <h2 class="section-title">
                <i class="fas fa-trophy"></i>
                Performance Sales Team
            </h2>
            <div class="filter-controls">
                <select class="form-select" id="timeFilter">
                    <option value="month">Bulan Ini</option>
                    <option value="week">Minggu Ini</option>
                    <option value="quarter">Kuartal Ini</option>
                    <option value="year">Tahun Ini</option>
                </select>
                <select class="form-select" id="metricFilter">
                    <option value="revenue">Berdasarkan Revenue</option>
                    <option value="transactions">Berdasarkan Transaksi</option>
                    <option value="customers">Berdasarkan Customer</option>
                </select>
            </div>
        </div>

        <div class="sales-grid" id="salesPerformanceGrid">
            @forelse($salesPerformance ?? [] as $sales)
                <div class="sales-card">
                    <div class="sales-header">
                        <div class="sales-avatar">
                            {{ strtoupper(substr($sales->name, 0, 1)) }}
                        </div>
                        <div class="sales-info">
                            <div class="sales-name">{{ $sales->name }}</div>
                            <div class="sales-role">{{ $sales->role }}</div>
                            <div class="text-muted small">
                                <i class="fas fa-envelope me-1"></i>{{ $sales->email }}
                            </div>
                        </div>
                    </div>

                    <div class="sales-stats">
                        <div class="stat-item">
                            <span class="stat-value">{{ $sales->transactions_count }}</span>
                            <span class="stat-label">Transaksi</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value">Rp {{ number_format($sales->total_revenue / 1000000, 1) }}JT</span>
                            <span class="stat-label">Revenue</span>
                        </div>
                    </div>

                    <div class="mt-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small>Target Achievement</small>
                            <small>{{ round($sales->performance_percentage) }}%</small>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-success"
                                style="width: {{ min($sales->performance_percentage, 100) }}%"></div>
                        </div>
                    </div>

                    <div class="mt-2">
                        <span
                            class="badge badge-{{ $sales->performance_status === 'exceeded' ? 'success' : ($sales->performance_status === 'met' ? 'primary' : 'warning') }}">
                            {{ $sales->performance_status === 'exceeded' ? 'Exceeded Target' : ($sales->performance_status === 'met' ? 'Met Target' : 'Below Target') }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-4">
                    <i class="fas fa-users fa-2x text-muted mb-2"></i>
                    <p class="text-muted">Belum ada data performance sales</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="activity-feed" data-aos="fade-up" data-aos-delay="600">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-history"></i>
                Aktivitas Terbaru
            </h2>
            <a href="#" class="btn btn-outline-primary btn-sm">
                Lihat Semua
            </a>
        </div>

        <div class="activity-list">
            @forelse($recentActivities ?? [] as $activity)
                <div class="activity-item">
                    <div class="activity-icon">
                        @if ($activity->action === 'login')
                            <i class="fas fa-sign-in-alt"></i>
                        @elseif($activity->action === 'create')
                            <i class="fas fa-plus"></i>
                        @elseif($activity->action === 'update')
                            <i class="fas fa-edit"></i>
                        @else
                            <i class="fas fa-info-circle"></i>
                        @endif
                    </div>
                    <div class="activity-content">
                        <div class="activity-text">
                            <strong>{{ $activity->user->name ?? 'System' }}</strong>
                            {{ $activity->description ?? $activity->action . ' ' . $activity->model }}
                        </div>
                        <div class="activity-time">
                            {{ $activity->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-4">
                    <i class="fas fa-history fa-2x text-muted mb-2"></i>
                    <p class="text-muted">Belum ada aktivitas</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Transactions by Sales Section -->
    <div class="transactions-section" data-aos="fade-up" data-aos-delay="700">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-receipt"></i>
                Transaksi Terbaru
            </h2>
            <div class="filter-controls">
                <select class="form-select" id="salesFilter" onchange="filterTransactionsBySales(this.value)">
                    <option value="">Semua Sales</option>
                    @foreach ($salesUsers ?? [] as $sales)
                        <option value="{{ $sales->id }}">{{ $sales->name }}</option>
                    @endforeach
                </select>
                <select class="form-select" id="dateFilter" onchange="filterTransactionsByDate(this.value)">
                    <option value="today">Hari Ini</option>
                    <option value="week">Minggu Ini</option>
                    <option value="month" selected>Bulan Ini</option>
                    <option value="quarter">Kuartal Ini</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover" id="transactionsTable">
                <thead>
                    <tr>
                        <th>Sales</th>
                        <th>Customer</th>
                        <th>Produk</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentTransactions ?? [] as $transaction)
                        @php
                            $allProducts = $transaction->getAllProducts();
                            $totalQuantity = $transaction->total_quantity;
                        @endphp
                        <tr data-sales-id="{{ $transaction->user_id }}">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="sales-avatar me-2" style="width: 35px; height: 35px; font-size: 0.8rem;">
                                        {{ strtoupper(substr($transaction->user->name ?? '?', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; font-size: 0.9rem;">
                                            {{ $transaction->user->name ?? 'N/A' }}
                                        </div>
                                        <small class="text-muted">{{ $transaction->user->role ?? 'N/A' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 600;">{{ $transaction->customer->name ?? '-' }}</div>
                                @if ($transaction->customer->phone ?? false)
                                    <small class="text-muted">{{ $transaction->customer->phone }}</small>
                                @endif
                            </td>
                            <td>
                                @if ($allProducts->count() === 1)
                                    @php
                                        $product = $allProducts->first();
                                        $productName = \App\Models\Product::find($product->product_id)->name ?? 'N/A';
                                    @endphp
                                    <div style="font-weight: 600;">{{ $productName }}</div>
                                    <small class="text-muted">Qty: {{ $product->quantity }}</small>
                                @else
                                    <div style="font-weight: 600;">{{ $allProducts->count() }} Produk</div>
                                    <small class="text-muted">Total Qty: {{ $totalQuantity }}</small>
                                    <!-- Tooltip untuk detail produk -->
                                    <div class="product-details-popover">
                                        <button type="button" class="btn btn-sm btn-outline-info mt-1"
                                            data-bs-toggle="popover" data-bs-html="true" data-bs-title="Detail Produk"
                                            data-bs-content='
                                            <ul class="product-list">
                                                @foreach ($allProducts as $item)
@php
    $productName = \App\Models\Product::find($item->product_id)->name ?? 'N/A';
@endphp
                                                    <li>{{ $productName }} - Qty: {{ $item->quantity }} - Rp {{ number_format($item->price, 0, ',', '.') }}</li>
@endforeach
                                            </ul>
                                        '>
                                            <i class="fas fa-list"></i> Lihat Detail
                                        </button>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</strong>
                                @if ($allProducts->count() > 1)
                                    <br>
                                    <small class="text-muted">
                                        @php
                                            $calculatedTotal = $allProducts->sum(function ($product) {
                                                return $product->quantity * $product->price;
                                            });
                                        @endphp
                                        ({{ $calculatedTotal == $transaction->total_price ? '✓ Match' : 'Calculated: Rp ' . number_format($calculatedTotal, 0, ',', '.') }})
                                    </small>
                                @endif
                            </td>
                            <td>
                                <span
                                    class="badge badge-{{ $transaction->status === 'deal' ? 'success' : ($transaction->status === 'pending' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                                @if ($transaction->payment_status)
                                    <br>
                                    <small
                                        class="badge badge-{{ $transaction->payment_status === 'paid' ? 'success' : 'warning' }} mt-1">
                                        {{ ucfirst($transaction->payment_status) }}
                                    </small>
                                @endif
                            </td>
                            <td>
                                {{ $transaction->created_at->format('d M Y') }}
                                <br>
                                <small class="text-muted">{{ $transaction->created_at->format('H:i') }}</small>
                            </td>
                            <td>
                                <a href="{{ route('admin.transactions.show', $transaction) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-receipt fa-2x text-muted mb-2"></i>
                                <p class="text-muted">Belum ada transaksi</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });

        // Initialize popovers
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Bootstrap popovers
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl, {
                    trigger: 'focus',
                    placement: 'left'
                });
            });

            // Close popovers when clicking outside
            document.addEventListener('click', function(e) {
                popoverList.forEach(function(popover) {
                    if (!popover._element.contains(e.target)) {
                        popover.hide();
                    }
                });
            });
        });

        // Filter transactions by sales
        function filterTransactionsBySales(salesId) {
            const rows = document.querySelectorAll('#transactionsTable tbody tr');
            let visibleCount = 0;

            rows.forEach(row => {
                if (!salesId || row.getAttribute('data-sales-id') === salesId) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Show message if no results
            const tbody = document.querySelector('#transactionsTable tbody');
            if (visibleCount === 0) {
                if (!tbody.querySelector('.no-results')) {
                    const noResults = document.createElement('tr');
                    noResults.className = 'no-results';
                    noResults.innerHTML = `
                    <td colspan="7" class="text-center py-4">
                        <i class="fas fa-search fa-2x text-muted mb-2"></i>
                        <p class="text-muted">Tidak ada transaksi untuk sales yang dipilih</p>
                    </td>
                `;
                    tbody.appendChild(noResults);
                }
            } else {
                const noResults = tbody.querySelector('.no-results');
                if (noResults) {
                    noResults.remove();
                }
            }
        }

        // Filter transactions by date (simulated)
        function filterTransactionsByDate(range) {
            const tableBody = document.querySelector('#transactionsTable tbody');
            const originalContent = tableBody.innerHTML;

            // Show loading state
            tableBody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center py-4">
                    <div class="spinner"></div>
                    <p class="mt-2 text-muted">Memuat data...</p>
                </td>
            </tr>
        `;

            // Simulate API call
            setTimeout(() => {
                // In real implementation, this would fetch data from server
                console.log(`Filtering transactions for: ${range}`);
                tableBody.innerHTML = originalContent;

                // Re-initialize popovers
                var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
                var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
                    return new bootstrap.Popover(popoverTriggerEl, {
                        trigger: 'focus',
                        placement: 'left'
                    });
                });

                // Show success message
                showNotification(`Data transaksi untuk ${range} berhasil dimuat`, 'success');
            }, 1000);
        }

        // Update performance metrics when filters change
        document.getElementById('timeFilter').addEventListener('change', function() {
            updatePerformanceMetrics(this.value, document.getElementById('metricFilter').value);
        });

        document.getElementById('metricFilter').addEventListener('change', function() {
            updatePerformanceMetrics(document.getElementById('timeFilter').value, this.value);
        });

        function updatePerformanceMetrics(timeRange, metric) {
            const salesGrid = document.getElementById('salesPerformanceGrid');
            const originalContent = salesGrid.innerHTML;

            // Show loading state
            salesGrid.innerHTML = `
            <div class="col-12 text-center py-4">
                <div class="spinner"></div>
                <p class="mt-2 text-muted">Memperbarui data performance...</p>
            </div>
        `;

            // Simulate API call
            setTimeout(() => {
                // In real implementation, this would fetch data from server
                console.log(`Updating performance metrics: ${timeRange} - ${metric}`);
                salesGrid.innerHTML = originalContent;

                // Show success message
                showNotification(`Data performance berhasil diperbarui`, 'success');
            }, 1500);
        }

        // Notification function
        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `alert alert-${type} alert-dismissible fade show`;
            notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
        `;
            notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

            document.body.appendChild(notification);

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 5000);
        }

        // Auto-refresh data every 2 minutes
        setInterval(() => {
            console.log('Auto-refreshing dashboard data...');
            // In production, this would fetch new data via AJAX
            showNotification('Dashboard data refreshed', 'info');
        }, 120000);

        // Add hover effects to cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.sales-card, .metric-card, .action-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = this.classList.contains('metric-card') ?
                        'translateY(-8px)' : 'translateY(-5px)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
@endpush
