@extends('layouts.app')

@section('title', 'Dashboard Admin Sales | Sales Management')
@section('page-title', 'Dashboard Overview')
@section('page-description', 'Selamat datang kembali, ' . auth()->user()->name . '. Monitor kinerja sales dan
    transaksi.')

    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
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
                box-shadow: 0 6px 20px rgba(79, 70, 229, 0.3);
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
                background: rgba(79, 70, 229, 0.05);
                border-bottom: 2px solid rgba(79, 70, 229, 0.1);
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
                background: rgba(79, 70, 229, 0.03);
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
                background: rgba(79, 70, 229, 0.1);
                color: var(--primary-color);
                border: 1px solid rgba(79, 70, 229, 0.2);
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

    <!-- Quick Actions -->
    <div class="quick-actions">
        <a href="{{ route('admin.users.create') }}" class="action-card" data-aos="fade-up" data-aos-delay="100">
            <div class="action-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <div class="action-title">Tambah Sales</div>
            <div class="action-description">Tambah sales person baru</div>
        </a>

        <a href="{{ route('admin.users.index') }}" class="action-card" data-aos="fade-up" data-aos-delay="200">
            <div class="action-icon">
                <i class="fas fa-users-cog"></i>
            </div>
            <div class="action-title">Kelola Sales</div>
            <div class="action-description">Kelola semua tim sales</div>
        </a>

        <a href="{{ route('admin.transactions.create') }}" class="action-card" data-aos="fade-up" data-aos-delay="300">
            <div class="action-icon">
                <i class="fas fa-plus-circle"></i>
            </div>
            <div class="action-title">Tambah Transaksi</div>
            <div class="action-description">Input transaksi baru</div>
        </a>

        <a href="{{ route('admin.transactions.index') }}" class="action-card" data-aos="fade-up" data-aos-delay="400">
            <div class="action-icon">
                <i class="fas fa-list"></i>
            </div>
            <div class="action-title">Semua Transaksi</div>
            <div class="action-description">Lihat semua transaksi</div>
        </a>
    </div>

    <!-- Metrics Grid -->
    <div class="metrics-grid">
        <div class="metric-card" data-aos="fade-up" data-aos-delay="100">
            <div class="metric-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="metric-info">
                <div class="metric-title">Total Sales Team</div>
                <div class="metric-value">{{ $totalSalesUsers ?? 0 }}</div>
                <div class="metric-trend trend-up">
                    <i class="fas fa-arrow-up"></i>
                    Active: {{ $activeSalesUsers ?? 0 }}
                </div>
            </div>
        </div>

        <div class="metric-card" data-aos="fade-up" data-aos-delay="200">
            <div class="metric-icon" style="background: var(--gradient-success);">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="metric-info">
                <div class="metric-title">Total Penjualan Bulan Ini</div>
                <div class="metric-value">Rp {{ number_format(($currentMonthRevenue ?? 0) / 1000000, 1) }}JT</div>
                <div class="metric-trend trend-up">
                    <i class="fas fa-arrow-up"></i>
                    {{ round((($currentMonthRevenue ?? 0) / max($lastMonthRevenue ?? 1, 1) - 1) * 100) }}% vs last month
                </div>
            </div>
        </div>

        <div class="metric-card" data-aos="fade-up" data-aos-delay="300">
            <div class="metric-icon" style="background: var(--gradient-warning);">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="metric-info">
                <div class="metric-title">Transaksi Bulan Ini</div>
                <div class="metric-value">{{ $currentMonthTransactions ?? 0 }}</div>
                <div class="metric-trend trend-up">
                    <i class="fas fa-arrow-up"></i>
                    {{ round((($currentMonthTransactions ?? 0) / max($lastMonthTransactions ?? 1, 1) - 1) * 100) }}%
                    growth
                </div>
            </div>
        </div>

        <div class="metric-card" data-aos="fade-up" data-aos-delay="400">
            <div class="metric-icon" style="background: var(--gradient-danger);">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="metric-info">
                <div class="metric-title">Avg. Sales per Person</div>
                <div class="metric-value">Rp {{ number_format(($averageSalesPerPerson ?? 0) / 1000000, 1) }}JT</div>
                <div class="metric-trend trend-up">
                    <i class="fas fa-arrow-up"></i>
                    Top performer: Rp {{ number_format(($topPerformerRevenue ?? 0) / 1000000, 1) }}JT
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

        <div class="sales-grid">
            @forelse(($salesPerformance ?? []) as $sales)
                <div class="sales-card">
                    <div class="sales-header">
                        <div class="sales-avatar">
                            {{ strtoupper(substr($sales->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="sales-info">
                            <div class="sales-name">{{ $sales->name ?? 'Unknown User' }}</div>
                            <div class="sales-role">{{ $sales->role ?? 'Sales' }}</div>
                            <div class="text-muted small">
                                <i class="fas fa-envelope me-1"></i>{{ $sales->email ?? 'No email' }}
                            </div>
                        </div>
                    </div>

                    <div class="sales-stats">
                        <div class="stat-item">
                            <span class="stat-value">{{ $sales->transactions_count ?? 0 }}</span>
                            <span class="stat-label">Transaksi</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value">Rp
                                {{ number_format(($sales->total_revenue ?? 0) / 1000000, 1) }}JT</span>
                            <span class="stat-label">Revenue</span>
                        </div>
                    </div>

                    <div class="mt-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small>Target Achievement</small>
                            <small>{{ round((($sales->total_revenue ?? 0) / max($sales->target_revenue ?? 1, 1)) * 100) }}%</small>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-success"
                                style="width: {{ min((($sales->total_revenue ?? 0) / max($sales->target_revenue ?? 1, 1)) * 100, 100) }}%">
                            </div>
                        </div>
                    </div>

                    <div class="mt-2">
                        <span
                            class="badge badge-{{ ($sales->performance_status ?? 'met') === 'exceeded' ? 'success' : (($sales->performance_status ?? 'met') === 'met' ? 'primary' : 'warning') }}">
                            {{ ($sales->performance_status ?? 'met') === 'exceeded' ? 'Exceeded Target' : (($sales->performance_status ?? 'met') === 'met' ? 'Met Target' : 'Below Target') }}
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

    <!-- Transactions by Sales Section -->
    <div class="transactions-section" data-aos="fade-up" data-aos-delay="600">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-receipt"></i>
                Transaksi per Sales
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
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse (($recentTransactions ?? []) as $transaction)
                        <tr data-sales-id="{{ $transaction->user_id ?? '' }}">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="sales-avatar me-2" style="width: 35px; height: 35px; font-size: 0.8rem;">
                                        {{ strtoupper(substr($transaction->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; font-size: 0.9rem;">
                                            {{ $transaction->user->name ?? 'Unknown' }}
                                        </div>
                                        <small class="text-muted">{{ $transaction->user->role ?? 'Sales' }}</small>
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
                                <div style="font-weight: 600;">{{ $transaction->product->name ?? '-' }}</div>
                                @if ($transaction->product->sku ?? false)
                                    <small class="text-muted">SKU: {{ $transaction->product->sku }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-primary">{{ $transaction->quantity ?? 0 }} pcs</span>
                            </td>
                            <td>
                                <strong>Rp {{ number_format($transaction->total_price ?? 0, 0, ',', '.') }}</strong>
                            </td>
                            <td>
                                <span
                                    class="badge badge-{{ ($transaction->status ?? 'pending') === 'completed' ? 'success' : (($transaction->status ?? 'pending') === 'pending' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($transaction->status ?? 'pending') }}
                                </span>
                            </td>
                            <td>
                                {{ ($transaction->created_at ?? now())->format('d M Y') }}
                                <br>
                                <small class="text-muted">{{ ($transaction->created_at ?? now())->format('H:i') }}</small>
                            </td>
                            <td>
                                <a href="{{ route('admin.transactions.show', $transaction->id ?? '#') }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
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

        // Filter transactions by sales
        function filterTransactionsBySales(salesId) {
            const rows = document.querySelectorAll('#transactionsTable tbody tr');

            rows.forEach(row => {
                if (!salesId || row.getAttribute('data-sales-id') === salesId) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Filter transactions by date (simulated)
        function filterTransactionsByDate(range) {
            // In a real implementation, this would make an API call
            console.log('Filtering by date range:', range);

            // Show loading state
            const tableBody = document.querySelector('#transactionsTable tbody');
            tableBody.innerHTML = `
                <tr>
                    <td colspan="8" class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Memuat data...</p>
                    </td>
                </tr>
            `;

            // Simulate API call
            setTimeout(() => {
                // This would be replaced with actual data from server
                alert(`Filter transaksi untuk ${range} akan diimplementasi dengan API call`);
                location.reload(); // Temporary reload for demo
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
            // Show loading state
            const salesGrid = document.querySelector('.sales-grid');
            const originalContent = salesGrid.innerHTML;

            salesGrid.innerHTML = `
                <div class="col-12 text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Memperbarui data performance...</p>
                </div>
            `;

            // Simulate API call
            setTimeout(() => {
                // This would be replaced with actual data from server
                alert(`Filter performance: ${timeRange} - ${metric} akan diimplementasi dengan API call`);
                salesGrid.innerHTML = originalContent; // Restore for demo
            }, 1500);
        }

        // Add hover effects
        document.querySelectorAll('.sales-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Auto-refresh data every 2 minutes
        setInterval(() => {
            console.log('Auto-refreshing dashboard data...');
            // In production, this would fetch new data via AJAX
        }, 120000);
    </script>
@endpush
