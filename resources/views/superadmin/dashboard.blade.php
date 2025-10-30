@extends('layouts.app')

@section('title', 'Dashboard SuperAdmin | Sales Management')
@section('page-title', 'Dashboard Overview')
@section('page-description', 'Selamat datang kembali, ' . auth()->user()->name . '. Berikut ringkasan performa sistem
    hari ini.')

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

            /* Charts Container */
            .charts-container {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
                gap: 1.5rem;
                margin-bottom: 2rem;
            }

            .chart-card {
                background: white;
                border: 1px solid #e2e8f0;
                border-radius: 16px;
                padding: 1.5rem;
                box-shadow: var(--card-shadow);
                transition: var(--transition);
            }

            .chart-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            }

            .chart-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 1rem;
            }

            .chart-title {
                font-size: 1.1rem;
                font-weight: 600;
                color: var(--dark-color);
                margin: 0;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .chart-body {
                position: relative;
                height: 300px;
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
                align-items: center;
                padding: 1rem;
                border-bottom: 1px solid rgba(0, 0, 0, 0.05);
                transition: var(--transition);
            }

            .activity-item:last-child {
                border-bottom: none;
            }

            .activity-item:hover {
                background: rgba(79, 70, 229, 0.02);
                transform: translateX(5px);
            }

            .activity-icon {
                width: 40px;
                height: 40px;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-right: 1rem;
                flex-shrink: 0;
                background: var(--gradient-primary);
                color: white;
            }

            .activity-content {
                flex: 1;
            }

            .activity-title {
                font-weight: 600;
                color: var(--dark-color);
                margin-bottom: 0.25rem;
            }

            .activity-time {
                font-size: 0.8rem;
                color: #64748b;
            }

            /* Card Styles */
            .card {
                background: white;
                border: 1px solid #e2e8f0;
                border-radius: 16px;
                box-shadow: var(--card-shadow);
                margin-bottom: 2rem;
                overflow: hidden;
                transition: var(--transition);
            }

            .card:hover {
                box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
                transform: translateY(-5px);
            }

            .card-header {
                background: #f8fafc;
                border-bottom: 1px solid #e2e8f0;
                padding: 1.25rem 1.5rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .card-title {
                font-size: 1.1rem;
                font-weight: 600;
                color: var(--dark-color);
                margin: 0;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .card-body {
                padding: 1.5rem;
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

            /* User Avatar */
            .user-avatar {
                width: 32px;
                height: 32px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-weight: 600;
                font-size: 0.8rem;
                flex-shrink: 0;
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

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Responsive */
            @media (max-width: 1200px) {
                .charts-container {
                    grid-template-columns: 1fr;
                }
            }

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

                .charts-container {
                    grid-template-columns: 1fr;
                }

                .chart-card {
                    min-width: auto;
                }

                .card-header {
                    flex-direction: column;
                    align-items: stretch;
                    gap: 1rem;
                }

                .quick-actions {
                    grid-template-columns: repeat(2, 1fr);
                }
            }

            @media (max-width: 576px) {
                .chart-body {
                    height: 250px;
                }

                .activity-item {
                    flex-direction: column;
                    align-items: flex-start;
                    text-align: left;
                }

                .activity-icon {
                    margin-bottom: 0.5rem;
                }

                .quick-actions {
                    grid-template-columns: 1fr;
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
            <div class="action-title">Tambah User</div>
            <div class="action-description">Buat akun pengguna baru</div>
        </a>

        <a href="{{ route('admin.users.index') }}" class="action-card" data-aos="fade-up" data-aos-delay="200">
            <div class="action-icon">
                <i class="fas fa-users-cog"></i>
            </div>
            <div class="action-title">Kelola User</div>
            <div class="action-description">Kelola semua pengguna</div>
        </a>

        <a href="{{ route('products.index') }}" class="action-card" data-aos="fade-up" data-aos-delay="300">
            <div class="action-icon">
                <i class="fas fa-box"></i>
            </div>
            <div class="action-title">Produk</div>
            <div class="action-description">Kelola katalog produk</div>
        </a>

        <a href="#" class="action-card" data-aos="fade-up" data-aos-delay="400">
            <div class="action-icon">
                <i class="fas fa-user-friends"></i>
            </div>
            <div class="action-title">Pelanggan</div>
            <div class="action-description">Kelola data pelanggan</div>
        </a>
    </div>

    <!-- Metrics Grid -->
    <div class="metrics-grid">
        <div class="metric-card" data-aos="fade-up" data-aos-delay="100">
            <div class="metric-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="metric-info">
                <div class="metric-title">Total Pengguna</div>
                <div class="metric-value">{{ $totalUsers }}</div>
                <div class="metric-trend trend-up">
                    <i class="fas fa-arrow-up"></i>
                    {{ round(($totalUsers / max($totalUsers - 5, 1) - 1) * 100) }}% growth
                </div>
            </div>
        </div>

        <div class="metric-card" data-aos="fade-up" data-aos-delay="200">
            <div class="metric-icon" style="background: var(--gradient-success);">
                <i class="fas fa-box"></i>
            </div>
            <div class="metric-info">
                <div class="metric-title">Total Produk</div>
                <div class="metric-value">{{ $totalProducts }}</div>
                <div class="metric-trend trend-up">
                    <i class="fas fa-arrow-up"></i>
                    {{ round(($totalProducts / max($totalProducts - 3, 1) - 1) * 100) }}% vs last month
                </div>
            </div>
        </div>

        <div class="metric-card" data-aos="fade-up" data-aos-delay="300">
            <div class="metric-icon" style="background: var(--gradient-warning);">
                <i class="fas fa-user-friends"></i>
            </div>
            <div class="metric-info">
                <div class="metric-title">Total Pelanggan</div>
                <div class="metric-value">{{ $totalCustomers }}</div>
                <div class="metric-trend trend-up">
                    <i class="fas fa-arrow-up"></i>
                    {{ round(($totalCustomers / max($totalCustomers - 2, 1) - 1) * 100) }}% growth
                </div>
            </div>
        </div>

        <div class="metric-card" data-aos="fade-up" data-aos-delay="400">
            <div class="metric-icon" style="background: var(--gradient-danger);">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="metric-info">
                <div class="metric-title">Total Pendapatan</div>
                <div class="metric-value">Rp {{ number_format($totalRevenue / 1000000, 1) }}JT</div>
                <div class="metric-trend trend-up">
                    <i class="fas fa-arrow-up"></i>
                    {{ round(($totalRevenue / max($totalRevenue - 10000000, 1) - 1) * 100) }}% vs last month
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="charts-container">
        <div class="chart-card" data-aos="fade-up" data-aos-delay="300">
            <div class="chart-header">
                <h3 class="chart-title">
                    <i class="fas fa-chart-bar"></i>
                    Grafik Penjualan per Bulan
                </h3>
                <select class="form-select form-select-sm" style="width: auto;" onchange="updateChart(this.value)">
                    <option value="revenue">Berdasarkan Revenue</option>
                    <option value="transactions">Berdasarkan Transaksi</option>
                </select>
            </div>
            <div class="chart-body">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <div class="chart-card" data-aos="fade-up" data-aos-delay="400">
            <div class="chart-header">
                <h3 class="chart-title">
                    <i class="fas fa-chart-pie"></i>
                    Distribusi Status Transaksi
                </h3>
                <select class="form-select form-select-sm" style="width: auto;" onchange="updatePieChart(this.value)">
                    <option value="status">Berdasarkan Status</option>
                    <option value="products">Berdasarkan Produk</option>
                </select>
            </div>
            <div class="chart-body">
                <canvas id="distributionChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="activity-feed" data-aos="fade-up" data-aos-delay="500">
        <h3 class="mb-3">
            <i class="fas fa-history"></i>
            Aktivitas Terbaru
        </h3>
        @forelse ($recentActivities as $activity)
            <div class="activity-item">
                <div class="activity-icon">
                    <i
                        class="fas fa-{{ $activity->type === 'transaction' ? 'shopping-cart' : ($activity->type === 'user' ? 'user-plus' : 'info-circle') }}"></i>
                </div>
                <div class="activity-content">
                    <div class="activity-title">{{ $activity->activity }}</div>
                    <div class="activity-time">{{ $activity->created_at->diffForHumans() }}</div>
                </div>
            </div>
        @empty
            <div class="text-center py-4">
                <i class="fas fa-history fa-2x text-muted mb-2"></i>
                <p class="text-muted">Belum ada aktivitas</p>
            </div>
        @endforelse
    </div>

    <!-- Recent Transactions Section -->
    <div class="card" data-aos="fade-up" data-aos-delay="600">
        <div class="card-header">
            <h2 class="card-title">
                <i class="fas fa-receipt"></i>
                Transaksi Terbaru
            </h2>
            <a href="#" class="btn btn-primary btn-sm">
                <i class="fas fa-list me-1"></i>Lihat Semua
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentTransactions as $t)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar me-2" style="background: var(--gradient-primary);">
                                            {{ strtoupper(substr($t->customer->name ?? 'C', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div style="font-weight: 600;">{{ $t->customer->name ?? '-' }}</div>
                                            @if ($t->customer->phone ?? false)
                                                <small class="text-muted">{{ $t->customer->phone }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 600;">{{ $t->product->name ?? '-' }}</div>
                                    @if ($t->product->sku ?? false)
                                        <small class="text-muted">SKU: {{ $t->product->sku }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-primary">{{ $t->quantity }} pcs</span>
                                </td>
                                <td>
                                    <strong>Rp {{ number_format($t->total_price, 0, ',', '.') }}</strong>
                                </td>
                                <td>
                                    <span
                                        class="badge badge-{{ $t->status === 'completed' ? 'success' : ($t->status === 'pending' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($t->status) }}
                                    </span>
                                </td>
                                <td>
                                    {{ $t->created_at->format('d M Y') }}
                                    <br>
                                    <small class="text-muted">{{ $t->created_at->format('H:i') }}</small>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-receipt fa-2x text-muted mb-2"></i>
                                    <p class="text-muted">Belum ada transaksi</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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

        // Sales Chart
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(salesCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($salesChart)) !!},
                datasets: [{
                    label: 'Total Penjualan (Rp)',
                    data: {!! json_encode(array_values($salesChart)) !!},
                    backgroundColor: 'rgba(79, 70, 229, 0.8)',
                    borderColor: 'rgba(79, 70, 229, 1)',
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Distribution Chart
        const distributionCtx = document.getElementById('distributionChart').getContext('2d');
        const distributionChart = new Chart(distributionCtx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Pending', 'Cancelled'],
                datasets: [{
                    data: [70, 20, 10],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(239, 68, 68, 0.8)'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                cutout: '60%'
            }
        });

        function updateChart(type) {
            // Update chart based on selection
            console.log('Updating chart with type:', type);
        }

        function updatePieChart(type) {
            // Update pie chart based on selection
            console.log('Updating pie chart with type:', type);
        }

        // Add hover effects to metric cards
        document.querySelectorAll('.metric-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
@endpush
