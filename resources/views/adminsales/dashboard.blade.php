@extends('layouts.app2')

@section('title', 'Dashboard Admin Sales | Sales Management')
@section('page-title', 'Sales Team Performance')
@section('page-description',
    'Selamat datang kembali, ' .
    auth()->user()->name .
    '. Monitor kinerja tim sales dan
    aktivitas penjualan.')

    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <style>
            /* GUNAKAN CSS BIRU SAMA SEPERTI SUPERADMIN */
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
                --gradient-info: linear-gradient(135deg, #06b6d4 0%, #22d3ee 100%);
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

            /* Quick Stats */
            .quick-stats {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1rem;
                margin-bottom: 2rem;
            }

            .stat-card {
                background: white;
                border-radius: 12px;
                padding: 1.5rem;
                text-align: center;
                transition: var(--transition);
                box-shadow: var(--card-shadow);
                border-left: 4px solid var(--primary-color);
            }

            .stat-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
            }

            .stat-icon {
                width: 50px;
                height: 50px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 1.5rem;
                margin: 0 auto 1rem;
                background: var(--gradient-primary);
            }

            .stat-value {
                font-size: 1.8rem;
                font-weight: 700;
                color: var(--dark-color);
                margin-bottom: 0.25rem;
            }

            .stat-label {
                font-size: 0.85rem;
                color: #64748b;
                font-weight: 500;
            }

            /* Performance Metrics */
            .performance-metrics {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 1.5rem;
                margin-bottom: 2rem;
            }

            .metric-card {
                background: white;
                border-radius: 16px;
                padding: 1.5rem;
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

            .metric-header {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                margin-bottom: 1rem;
            }

            .metric-title {
                font-size: 1rem;
                font-weight: 600;
                color: var(--dark-color);
                margin: 0;
            }

            .metric-value {
                font-size: 2rem;
                font-weight: 700;
                color: var(--primary-color);
                margin-bottom: 0.5rem;
            }

            .metric-progress {
                margin-top: 1rem;
            }

            .progress-info {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 0.5rem;
            }

            .progress-label {
                font-size: 0.85rem;
                color: #64748b;
            }

            .progress-percentage {
                font-size: 0.85rem;
                font-weight: 600;
                color: var(--primary-color);
            }

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
                background: var(--gradient-primary);
            }

            /* Team Performance */
            .team-performance {
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

            .section-title i {
                color: var(--primary-color);
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
                min-width: 150px;
                font-size: 0.85rem;
            }

            /* Sales Grid */
            .sales-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
                gap: 1.5rem;
            }

            .sales-card {
                background: white;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                padding: 1.5rem;
                transition: var(--transition);
                box-shadow: var(--card-shadow);
            }

            .sales-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
                border-color: var(--primary-light);
            }

            .sales-header {
                display: flex;
                align-items: center;
                gap: 1rem;
                margin-bottom: 1rem;
                padding-bottom: 1rem;
                border-bottom: 1px solid #f1f5f9;
            }

            .sales-avatar {
                width: 50px;
                height: 50px;
                border-radius: 50%;
                background: var(--gradient-primary);
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 1.2rem;
                font-weight: 600;
            }

            .sales-info {
                flex: 1;
            }

            .sales-name {
                font-weight: 600;
                color: var(--dark-color);
                margin-bottom: 0.25rem;
                font-size: 1rem;
            }

            .sales-email {
                font-size: 0.8rem;
                color: #64748b;
            }

            .sales-stats {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 0.75rem;
                margin-bottom: 1rem;
            }

            .stat-item {
                text-align: center;
                padding: 0.75rem;
                background: #f8fafc;
                border-radius: 8px;
            }

            .stat-value {
                font-size: 1.2rem;
                font-weight: 700;
                color: var(--primary-color);
                display: block;
                line-height: 1;
            }

            .stat-label {
                font-size: 0.7rem;
                color: #64748b;
                margin-top: 0.25rem;
            }

            .performance-indicator {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                font-size: 0.8rem;
                font-weight: 500;
            }

            .indicator-dot {
                width: 8px;
                height: 8px;
                border-radius: 50%;
            }

            .indicator-excellent {
                background: var(--success-color);
            }

            .indicator-good {
                background: var(--warning-color);
            }

            .indicator-needs-improvement {
                background: var(--error-color);
            }

            /* Recent Activity */
            .recent-activity {
                background: white;
                border-radius: 16px;
                padding: 1.5rem;
                box-shadow: var(--card-shadow);
                margin-bottom: 2rem;
            }

            .activity-list {
                space-y: 1rem;
            }

            .activity-item {
                display: flex;
                align-items: flex-start;
                gap: 1rem;
                padding: 1rem;
                border-radius: 8px;
                transition: var(--transition);
                border-left: 3px solid transparent;
            }

            .activity-item:hover {
                background: #f8fafc;
                border-left-color: var(--primary-color);
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
                background: var(--gradient-info);
                flex-shrink: 0;
            }

            .activity-content {
                flex: 1;
            }

            .activity-text {
                font-size: 0.9rem;
                color: var(--dark-color);
                margin-bottom: 0.25rem;
            }

            .activity-time {
                font-size: 0.75rem;
                color: #64748b;
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
                font-size: 0.95rem;
            }

            .action-description {
                font-size: 0.8rem;
                color: #64748b;
            }

            /* Badges */
            .badge {
                padding: 0.4rem 0.75rem;
                border-radius: 6px;
                font-size: 0.7rem;
                font-weight: 600;
                transition: var(--transition);
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

            .badge-primary {
                background: rgba(79, 70, 229, 0.1);
                color: var(--primary-color);
                border: 1px solid rgba(79, 70, 229, 0.2);
            }

            /* Animations */
            @keyframes float {

                0%,
                100% {
                    transform: translateY(0px) rotate(0deg);
                }

                50% {
                    transform: translateY(-15px) rotate(3deg);
                }
            }

            /* Responsive */
            @media (max-width: 768px) {
                .quick-stats {
                    grid-template-columns: repeat(2, 1fr);
                }

                .performance-metrics {
                    grid-template-columns: 1fr;
                }

                .sales-grid {
                    grid-template-columns: 1fr;
                }

                .sales-stats {
                    grid-template-columns: repeat(2, 1fr);
                }

                .section-header {
                    flex-direction: column;
                    align-items: stretch;
                }

                .filter-controls {
                    justify-content: center;
                }

                .quick-actions {
                    grid-template-columns: repeat(2, 1fr);
                }
            }

            @media (max-width: 576px) {
                .quick-stats {
                    grid-template-columns: 1fr;
                }

                .quick-actions {
                    grid-template-columns: 1fr;
                }

                .sales-stats {
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
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="quick-stats" data-aos="fade-up">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-value">{{ $totalSalesUsers ?? 0 }}</div>
            <div class="stat-label">Total Sales Team</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: var(--gradient-success);">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-value">Rp {{ number_format(($currentMonthRevenue ?? 0) / 1000000, 1) }}JT</div>
            <div class="stat-label">Revenue Bulan Ini</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: var(--gradient-warning);">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-value">{{ $currentMonthTransactions ?? 0 }}</div>
            <div class="stat-label">Transaksi Bulan Ini</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: var(--gradient-info);">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-value">{{ $activeSalesUsers ?? 0 }}</div>
            <div class="stat-label">Sales Aktif</div>
        </div>
    </div>

    <!-- Performance Metrics -->
    <div class="performance-metrics" data-aos="fade-up" data-aos-delay="100">
        <div class="metric-card">
            <div class="metric-header">
                <h3 class="metric-title">Target Achievement</h3>
                <span class="badge badge-primary">{{ round((($currentMonthRevenue ?? 0) / 500000000) * 100) }}%</span>
            </div>
            <div class="metric-value">Rp {{ number_format(($currentMonthRevenue ?? 0) / 1000000, 1) }}JT</div>
            <div class="metric-progress">
                <div class="progress-info">
                    <span class="progress-label">Progress Target</span>
                    <span
                        class="progress-percentage">{{ min(round((($currentMonthRevenue ?? 0) / 500000000) * 100), 100) }}%</span>
                </div>
                <div class="progress">
                    <div class="progress-bar"
                        style="width: {{ min((($currentMonthRevenue ?? 0) / 500000000) * 100, 100) }}%"></div>
                </div>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-header">
                <h3 class="metric-title">Average Performance</h3>
                <span
                    class="badge badge-success">+{{ round((($currentMonthRevenue ?? 0) / max($lastMonthRevenue ?? 1, 1) - 1) * 100) }}%</span>
            </div>
            <div class="metric-value">Rp {{ number_format(($averageSalesPerPerson ?? 0) / 1000000, 1) }}JT</div>
            <div class="metric-progress">
                <div class="progress-info">
                    <span class="progress-label">Per Sales Person</span>
                    <span class="progress-percentage">vs Last Month</span>
                </div>
                <div class="progress">
                    <div class="progress-bar"
                        style="width: {{ min((($averageSalesPerPerson ?? 0) / 50000000) * 100, 100) }}%"></div>
                </div>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-header">
                <h3 class="metric-title">Team Efficiency</h3>
                <span class="badge badge-warning">{{ $totalSalesUsers ?? 0 }} Members</span>
            </div>
            <div class="metric-value">{{ round(($currentMonthTransactions ?? 0) / max($totalSalesUsers ?? 1, 1)) }}</div>
            <div class="metric-progress">
                <div class="progress-info">
                    <span class="progress-label">Transactions per Sales</span>
                    <span class="progress-percentage">Monthly Average</span>
                </div>
                <div class="progress">
                    <div class="progress-bar"
                        style="width: {{ min((($currentMonthTransactions ?? 0) / ($totalSalesUsers ?? 1) / 20) * 100, 100) }}%">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Performance Section -->
    <div class="team-performance" data-aos="fade-up" data-aos-delay="200">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-trophy"></i>
                Team Performance
            </h2>
            <div class="filter-controls">
                <select class="form-select" id="performanceFilter">
                    <option value="revenue">By Revenue</option>
                    <option value="transactions">By Transactions</option>
                    <option value="performance">By Performance</option>
                </select>
            </div>
        </div>

        <div class="sales-grid">
            @forelse(($salesPerformance ?? []) as $sales)
                @php
                    $performanceScore = (($sales->total_revenue ?? 0) / max($sales->target_revenue ?? 1, 1)) * 100;
                    $indicatorClass =
                        $performanceScore >= 100
                            ? 'indicator-excellent'
                            : ($performanceScore >= 80
                                ? 'indicator-good'
                                : 'indicator-needs-improvement');
                    $indicatorText =
                        $performanceScore >= 100
                            ? 'Excellent'
                            : ($performanceScore >= 80
                                ? 'Good'
                                : 'Needs Improvement');
                @endphp

                <div class="sales-card">
                    <div class="sales-header">
                        <div class="sales-avatar">
                            {{ strtoupper(substr($sales->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="sales-info">
                            <div class="sales-name">{{ $sales->name ?? 'Unknown User' }}</div>
                            <div class="sales-email">{{ $sales->email ?? 'No email' }}</div>
                        </div>
                    </div>

                    <div class="sales-stats">
                        <div class="stat-item">
                            <span class="stat-value">{{ $sales->transactions_count ?? 0 }}</span>
                            <span class="stat-label">Transactions</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value">Rp
                                {{ number_format(($sales->total_revenue ?? 0) / 1000000, 1) }}JT</span>
                            <span class="stat-label">Revenue</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value">{{ round($performanceScore) }}%</span>
                            <span class="stat-label">Target</span>
                        </div>
                    </div>

                    <div class="performance-indicator">
                        <div class="indicator-dot {{ $indicatorClass }}"></div>
                        <span>{{ $indicatorText }}</span>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-4">
                    <i class="fas fa-users fa-2x text-muted mb-2"></i>
                    <p class="text-muted">Belum ada data performance sales team</p>
                </div>
            @endforelse
        </div>
    </div>

    <div class="row">
        <!-- Recent Activity -->
        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
            <div class="recent-activity">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-bell"></i>
                        Recent Activity
                    </h2>
                </div>
                <div class="activity-list">
                    @php
                        // Pastikan $recentActivities adalah Collection
                        $activities = $recentActivities ?? collect();
                        if (is_array($activities)) {
                            $activities = collect($activities);
                        }
                    @endphp

                    @forelse($activities->take(5) as $activity)
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-bell"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-text">
                                    @if (isset($activity->user) && $activity->user)
                                        <strong>{{ $activity->user->name ?? 'User' }}</strong>
                                    @endif
                                    {{ $activity->description ?? 'Activity recorded' }}
                                </div>
                                <div class="activity-time">
                                    {{ isset($activity->created_at) ? $activity->created_at->diffForHumans() : 'Just now' }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="fas fa-bell fa-2x text-muted mb-2"></i>
                            <p class="text-muted">Tidak ada aktivitas terbaru</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="400">
            <div class="recent-activity">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-bolt"></i>
                        Quick Actions
                    </h2>
                </div>
                <div class="quick-actions">
                    <a href="{{ route('admin.customers.create') }}" class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="action-title">Tambah Customer</div>
                        <div class="action-description">Input customer baru</div>
                    </a>

                    <a href="{{ route('admin.transactions.create') }}" class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <div class="action-title">Tambah Transaksi</div>
                        <div class="action-description">Input transaksi sales</div>
                    </a>

                    <a href="{{ route('products.index') }}" class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="action-title">Lihat Produk</div>
                        <div class="action-description">Kelola katalog produk</div>
                    </a>

                    <a href="{{ route('admin.users.index') }}" class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="action-title">Kelola Sales</div>
                        <div class="action-description">Lihat tim sales</div>
                    </a>
                </div>
            </div>
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

        // Performance filter
        document.getElementById('performanceFilter').addEventListener('change', function() {
            const filterValue = this.value;
            const salesCards = document.querySelectorAll('.sales-card');

            salesCards.forEach(card => {
                card.style.display = 'block';
            });

            // Show notification
            showNotification(`Filtering by ${filterValue}...`, 'info');
        });

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

            // Auto remove after 3 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 3000);
        }

        // Add hover effects to cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.sales-card, .stat-card, .action-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = this.classList.contains('stat-card') ?
                        'translateY(-5px)' : 'translateY(-3px)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });

        // Auto-refresh every 3 minutes
        setInterval(() => {
            console.log('Auto-refreshing AdminSales dashboard...');
            showNotification('Memperbarui data dashboard...', 'info');

            // In production, this would fetch new data via AJAX
            // location.reload(); // Uncomment for auto-refresh
        }, 180000);
    </script>
@endpush
