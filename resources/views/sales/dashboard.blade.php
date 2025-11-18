@extends('layouts.app3')

@section('title', 'Sales Dashboard')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">Dashboard Sales</h2>
                <p class="text-muted mb-0"></p>
            </div>
            <div class="d-flex align-items-center">
                <span class="badge bg-primary fs-6 px-3 py-2">
                    <i class="fas fa-user me-2"></i>{{ auth()->user()->role }}
                </span>
            </div>
        </div>

        <!-- Quick Access Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-gradient-primary text-white py-3">
                        <h5 class="mb-0"><i class="fas fa-rocket me-2"></i>Quick Actions</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row text-center">
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('sales.products.create') }}" class="card quick-action-card text-decoration-none">
                                    <div class="card-body text-center p-4">
                                        <div class="quick-action-icon bg-success">
                                            <i class="fas fa-plus-circle fa-2x"></i>
                                        </div>
                                        <h6 class="mt-3 mb-1 fw-bold">Create Product</h6>
                                        <small class="text-muted">Add new product to catalog</small>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('sales.customers.create') }}" class="card quick-action-card text-decoration-none">
                                    <div class="card-body text-center p-4">
                                        <div class="quick-action-icon bg-info">
                                            <i class="fas fa-user-plus fa-2x"></i>
                                        </div>
                                        <h6 class="mt-3 mb-1 fw-bold">Create Customer</h6>
                                        <small class="text-muted">Register new customer</small>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('sales.transactions.create') }}" class="card quick-action-card text-decoration-none">
                                    <div class="card-body text-center p-4">
                                        <div class="quick-action-icon bg-warning">
                                            <i class="fas fa-cash-register fa-2x"></i>
                                        </div>
                                        <h6 class="mt-3 mb-1 fw-bold">Create Transaction</h6>
                                        <small class="text-muted">Process new sale</small>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Statistics Grid -->
        <div class="row mb-4">
            <!-- Today's Performance -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card border-left-primary shadow h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Today's Sales
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $todayTransactions }}</div>
                                <div class="mt-2 text-success">
                                    <small>Rp {{ number_format($todayRevenue, 0, ',', '.') }}</small>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-day fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Revenue -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card border-left-success shadow h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Revenue
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                                <div class="mt-2 text-muted">
                                    <small>Rp {{ number_format($monthlyRevenue, 0, ',', '.') }} this month</small>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Transactions -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card border-left-info shadow h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Total Transactions
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalTransactions }}</div>
                                <div class="mt-2">
                                    <span class="badge bg-success">{{ $completedTransactions }} Completed</span>
                                    <span class="badge bg-warning ms-1">{{ $pendingTransactions }} Pending</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-receipt fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Rate -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card border-left-warning shadow h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Completion Rate
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    @php
                                        $completionRate = $totalTransactions > 0 ? ($completedTransactions / $totalTransactions) * 100 : 0;
                                    @endphp
                                    {{ number_format($completionRate, 1) }}%
                                </div>
                                <div class="progress mt-2" style="height: 8px;">
                                    <div class="progress-bar bg-warning" role="progressbar" 
                                         style="width: {{ $completionRate }}%" 
                                         aria-valuenow="{{ $completionRate }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-chart-line fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Row Statistics -->
        <div class="row mb-4">
            <!-- Monthly Transactions -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card border-left-primary shadow h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    This Month
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $monthlyTransactions }}</div>
                                <div class="mt-2 text-muted">
                                    <small>{{ $weeklyTransactions }} this week</small>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-chart-bar fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Status -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card border-left-success shadow h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Payment Status
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $paidTransactions }} Paid</div>
                                <div class="mt-2 text-danger">
                                    <small>{{ $unpaidTransactions }} Unpaid</small>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-credit-card fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Overview -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card border-left-info shadow h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Products
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalProducts }}</div>
                                <div class="mt-2">
                                    @if($lowStockProducts > 0)
                                        <span class="badge bg-warning text-dark me-1">{{ $lowStockProducts }} Low Stock</span>
                                    @endif
                                    @if($outOfStockProducts > 0)
                                        <span class="badge bg-danger">{{ $outOfStockProducts }} Out of Stock</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-boxes fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customers -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card border-left-warning shadow h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Total Customers
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalCustomers }}</div>
                                <div class="mt-2">
                                    <a href="{{ route('sales.customers') }}" class="btn btn-outline-warning btn-sm">
                                        <i class="fas fa-eye me-1"></i>View All
                                    </a>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Recent Activity -->
        <div class="row">
            <!-- Recent Transactions -->
            <div class="col-xl-6 col-lg-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header bg-white py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-history me-2"></i>Recent Transactions
                        </h6>
                        <a href="{{ route('sales.transactions') }}" class="btn btn-sm btn-primary">View All</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead class="bg-light">
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
                                                <small class="text-muted">{{ $transaction->created_at->format('M d') }}</small>
                                            </td>
                                            <td>
                                                <div>{{ $transaction->customer->name ?? 'N/A' }}</div>
                                                <small class="text-muted">{{ $transaction->customer->company ?? '' }}</small>
                                            </td>
                                            <td>
                                                <div>{{ Str::limit($transaction->product->name ?? 'N/A', 15) }}</div>
                                                <small class="text-muted">{{ $transaction->product->sku ?? '' }}</small>
                                            </td>
                                            <td class="fw-bold text-success">
                                                Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $transaction->status == 'completed' ? 'success' : ($transaction->status == 'pending' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($transaction->status) }}
                                                </span>
                                                <br>
                                                <small class="text-muted">{{ ucfirst($transaction->payment_status) }}</small>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                <i class="fas fa-receipt fa-2x mb-2"></i>
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
                <div class="card shadow h-100">
                    <div class="card-header bg-white py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-success">
                            <i class="fas fa-star me-2"></i>Top Products
                        </h6>
                        <a href="{{ route('sales.products') }}" class="btn btn-sm btn-success">View All</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead class="bg-light">
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
                                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $product->stock_quantity == 0 ? 'danger' : ($product->stock_quantity <= $product->min_stock ? 'warning' : 'success') }}">
                                                    {{ $product->stock_quantity }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $product->is_active ? 'success' : 'secondary' }}">
                                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">
                                                <i class="fas fa-box fa-2x mb-2"></i>
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
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-chart-line me-2"></i>Sales Performance (Last 6 Months)
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-bar">
                            <canvas id="salesChart" height="80"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sales Chart
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        const monthlySales = @json($monthlySales);
        
        const months = [];
        const salesData = [];
        const transactionCounts = [];
        
        // Prepare data for chart
        monthlySales.forEach(sale => {
            const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            months.push(monthNames[sale.month - 1] + ' ' + sale.year);
            salesData.push(sale.total);
            transactionCounts.push(sale.count);
        });
        
        const salesChart = new Chart(salesCtx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [
                    {
                        label: 'Sales Revenue (Rp)',
                        data: salesData,
                        backgroundColor: 'rgba(54, 162, 235, 0.8)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2,
                        borderRadius: 5,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Transaction Count',
                        data: transactionCounts,
                        type: 'line',
                        fill: false,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
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
    });
</script>
@endpush

<style>
.stat-card {
    border-radius: 15px;
    border: none;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.border-left-primary {
    border-left: 5px solid #4e73df !important;
}

.border-left-success {
    border-left: 5px solid #1cc88a !important;
}

.border-left-info {
    border-left: 5px solid #36b9cc !important;
}

.border-left-warning {
    border-left: 5px solid #f6c23e !important;
}

.bg-gradient-primary {
    background: linear-gradient(45deg, #4e73df, #224abe) !important;
}

.quick-action-card {
    border: none;
    border-radius: 15px;
    transition: all 0.3s ease;
    height: 100%;
}

.quick-action-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.quick-action-icon {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    color: white;
}

.progress {
    border-radius: 10px;
    background-color: #f8f9fc;
}

.progress-bar {
    border-radius: 10px;
}

.table th {
    border-top: none;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    color: #6c757d;
    background-color: #f8f9fa;
}

.badge {
    font-size: 0.7rem;
    font-weight: 500;
}

.card-header {
    border-bottom: 1px solid #e3e6f0;
}

.text-xs {
    font-size: 0.7rem;
}
</style>