@php
    $role = auth()->user()->role;

    // Tentukan layout berdasarkan role
    if ($role === 'adminsales') {
        $layout = 'layouts.app2';
    } elseif ($role === 'sales') {
        $layout = 'layouts.app3';
    } else {
        $layout = 'layouts.app';
    }
@endphp


@extends($layout)

@section('title', 'Transactions Management | ' . ucfirst(auth()->user()->role))
@section('page-title', 'Transaction Management')
@section('page-description', 'Kelola transaksi penjualan dan pembelian')


@push('styles')
    <style>
        :root {
            --primary-color: #4f46e5;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --error-color: #ef4444;
            --info-color: #06b6d4;
            --dark-color: #1e293b;
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-success: linear-gradient(135deg, #10b981 0%, #059669 100%);
            --gradient-warning: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            --gradient-danger: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            --transition: all 0.3s ease;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 1.8rem;
            text-align: center;
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

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin: 0 auto 1rem;
            background: var(--gradient-primary);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.3);
            transition: var(--transition);
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #64748b;
            font-weight: 500;
        }

        /* Filter Section - Diperkecil */
        .filter-section {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 1.2rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--card-shadow);
        }

        .filter-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
            align-items: end;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.4rem;
            display: block;
            font-size: 0.85rem;
        }

        .form-control,
        .form-select {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
            width: 100%;
            transition: var(--transition);
            font-size: 0.85rem;
            height: 38px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.1);
            outline: none;
        }

        /* Action Bar - Diperkecil */
        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .search-box {
            position: relative;
            min-width: 280px;
        }

        .search-box input {
            padding-left: 2.5rem;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            transition: var(--transition);
            background: white;
            font-size: 0.85rem;
            height: 38px;
        }

        .search-box input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.1);
        }

        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.9rem;
        }

        .btn {
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-weight: 600;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.85rem;
            height: 38px;
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

        .btn-outline-secondary {
            background: transparent;
            color: #64748b;
            border: 1px solid #e2e8f0;
        }

        .btn-outline-secondary:hover {
            background: #f8fafc;
            color: #475569;
        }

        /* Table Styles */
        .table-container {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
        }

        .table {
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.9rem;
        }

        .table thead th {
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
            padding: 0.8rem;
            font-weight: 600;
            color: var(--dark-color);
            font-size: 0.85rem;
        }

        .table tbody td {
            padding: 0.8rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.85rem;
        }

        .table tbody tr:hover {
            background: #f8fafc;
        }

        /* Transaction Avatar */
        .transaction-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e2e8f0;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
        }

        .transaction-avatar:hover {
            transform: scale(1.1);
            border-color: var(--primary-color);
        }

        /* Status Badge */
        .status-badge {
            font-size: 0.75rem;
            padding: 0.3rem 0.6rem;
            border-radius: 6px;
            font-weight: 600;
            display: inline-block;
        }

        .status-badge.completed {
            color: var(--success-color);
            background: rgba(16, 185, 129, 0.1);
        }

        .status-badge.pending {
            color: var(--warning-color);
            background: rgba(245, 158, 11, 0.1);
        }

        .status-badge.cancelled {
            color: var(--error-color);
            background: rgba(239, 68, 68, 0.1);
        }

        /* Payment Status Badge */
        .payment-badge {
            font-size: 0.75rem;
            padding: 0.3rem 0.6rem;
            border-radius: 6px;
            font-weight: 600;
            display: inline-block;
        }

        .payment-badge.paid {
            color: var(--success-color);
            background: rgba(16, 185, 129, 0.1);
        }

        .payment-badge.pending {
            color: var(--warning-color);
            background: rgba(245, 158, 11, 0.1);
        }

        .payment-badge.cancelled {
            color: var(--error-color);
            background: rgba(239, 68, 68, 0.1);
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 0.4rem;
        }

        .btn-icon {
            width: 30px;
            height: 30px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: var(--transition);
            border: 1px solid transparent;
            font-size: 0.8rem;
        }

        .btn-icon-view {
            background: rgba(6, 182, 212, 0.1);
            color: var(--info-color);
            border: 1px solid rgba(6, 182, 212, 0.2);
        }

        .btn-icon-view:hover {
            background: var(--info-color);
            color: white;
            transform: scale(1.1);
        }

        .btn-icon-edit {
            background: rgba(79, 70, 229, 0.1);
            color: var(--primary-color);
            border: 1px solid rgba(79, 70, 229, 0.2);
        }

        .btn-icon-edit:hover {
            background: var(--primary-color);
            color: white;
            transform: scale(1.1);
        }

        .btn-icon-delete {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error-color);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .btn-icon-delete:hover {
            background: var(--error-color);
            color: white;
            transform: scale(1.1);
        }

        /* Price Styling */
        .price {
            font-weight: 700;
            color: var(--dark-color);
            font-size: 0.85rem;
        }

        .quantity {
            font-weight: 600;
            color: #64748b;
            font-size: 0.8rem;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: #64748b;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .empty-state h4 {
            font-size: 1.3rem;
            margin-bottom: 1rem;
            color: var(--dark-color);
        }

        .empty-state p {
            font-size: 0.9rem;
            margin-bottom: 2rem;
            color: #64748b;
        }

        /* Enhanced Pagination */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            border-top: 1px solid #e2e8f0;
            background: #f8fafc;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .pagination-info {
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 500;
        }

        .pagination-nav {
            display: flex;
            align-items: center;
        }

        .pagination {
            margin-bottom: 0;
            gap: 0.25rem;
        }

        .page-item .page-link {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
            color: #64748b;
            font-weight: 500;
            font-size: 0.85rem;
            min-width: 40px;
            text-align: center;
            transition: var(--transition);
        }

        .page-item .page-link:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
            transform: translateY(-1px);
        }

        .page-item.active .page-link {
            background: var(--gradient-primary);
            border-color: var(--primary-color);
            color: white;
        }

        .page-item.disabled .page-link {
            background: #f1f5f9;
            color: #94a3b8;
            border-color: #e2e8f0;
        }

        .page-size-selector {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
        }

        .page-size-selector .form-select {
            width: auto;
            display: inline-block;
            padding: 0.3rem 1.5rem 0.3rem 0.5rem;
            font-size: 0.8rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .filter-row {
                grid-template-columns: 1fr;
            }

            .action-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .search-box {
                min-width: 100%;
            }

            .pagination-container {
                flex-direction: column;
                text-align: center;
            }

            .pagination-info {
                order: 3;
            }

            .page-size-selector {
                order: 2;
            }

            .pagination-nav {
                order: 1;
            }
        }

        @media (max-width: 576px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-icon {
                width: 28px;
                height: 28px;
            }

            .pagination {
                flex-wrap: wrap;
                justify-content: center;
            }
        }

        /* Products List Styles */
        .products-list {
            max-width: 200px;
        }

        .product-item {
            padding: 0.25rem 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .product-item:last-child {
            border-bottom: none;
        }

        .more-products {
            margin-top: 0.5rem;
            padding-top: 0.5rem;
            border-top: 1px dashed #e2e8f0;
        }

        /* Hover effect for products */
        .products-list:hover .product-item {
            background: #f8fafc;
            border-radius: 4px;
        }
    </style>
@endpush

@section('content')
    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
            <div class="stat-icon" style="background: var(--gradient-primary);">
                <i class="fas fa-exchange-alt"></i>
            </div>
            <div class="stat-value">{{ $totalTransactions }}</div>
            <div class="stat-label">Total Transactions</div>
        </div>

        <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
            <div class="stat-icon" style="background: var(--gradient-success);">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-value">{{ $completedTransactions }}</div>
            <div class="stat-label">Completed</div>
        </div>

        <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
            <div class="stat-icon" style="background: var(--gradient-warning);">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-value">{{ $pendingTransactions }}</div>
            <div class="stat-label">Pending</div>
        </div>

        <div class="stat-card" data-aos="fade-up" data-aos-delay="400">
            <div class="stat-icon" style="background: var(--gradient-danger);">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stat-value">{{ $cancelledTransactions }}</div>
            <div class="stat-label">Cancelled</div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section" data-aos="fade-up" data-aos-delay="500">
        <form action="{{ route('admin.transactions.index') }}" method="GET" id="filterForm">
            <div class="filter-row">
                <div>
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" id="statusSelect">
                        <option value="">All Status</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed
                        </option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                        </option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Payment Status</label>
                    <select name="payment_status" class="form-select" id="paymentSelect">
                        <option value="">All Payment Status</option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending
                        </option>
                        <option value="cancelled" {{ request('payment_status') == 'cancelled' ? 'selected' : '' }}>
                            Cancelled</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Date From</label>
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>

                <div>
                    <label class="form-label">Date To</label>
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>

                <div>
                    <label class="form-label">Sort By</label>
                    <select name="sort" class="form-select" id="sortSelect">
                        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Newest First
                        </option>
                        <option value="total_price" {{ request('sort') == 'total_price' ? 'selected' : '' }}>Highest Amount
                        </option>
                    </select>
                </div>

                <div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i>Apply Filters
                    </button>
                </div>
            </div>

            <!-- Hidden inputs untuk maintain state -->
            @if (request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif
            @if (request('per_page'))
                <input type="hidden" name="per_page" value="{{ request('per_page') }}">
            @endif
        </form>
    </div>

    <!-- Action Bar -->
    <div class="action-bar" data-aos="fade-up" data-aos-delay="600">
        <form action="{{ route('admin.transactions.index') }}" method="GET" class="d-flex gap-2 align-items-center">
            <!-- Maintain existing filters -->
            @if (request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            @if (request('payment_status'))
                <input type="hidden" name="payment_status" value="{{ request('payment_status') }}">
            @endif
            @if (request('date_from'))
                <input type="hidden" name="date_from" value="{{ request('date_from') }}">
            @endif
            @if (request('date_to'))
                <input type="hidden" name="date_to" value="{{ request('date_to') }}">
            @endif
            @if (request('sort'))
                <input type="hidden" name="sort" value="{{ request('sort') }}">
            @endif
            @if (request('per_page'))
                <input type="hidden" name="per_page" value="{{ request('per_page') }}">
            @endif

            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" name="search" class="form-control" placeholder="Search by customer, product..."
                    value="{{ request('search') }}" id="searchInput">
            </div>

            <button type="submit" class="btn btn-primary" style="display: none;" id="searchSubmit">Search</button>
        </form>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.transactions.create') }}" class="btn btn-success">
                <i class="fas fa-plus me-2"></i>Add New Transaction
            </a>
            <button class="btn btn-primary" onclick="exportTransactions()">
                <i class="fas fa-download me-2"></i>Export
            </button>

            <!-- Clear Filters Button -->
            @if (request()->hasAny(['search', 'status', 'payment_status', 'date_from', 'date_to', 'sort']))
                <a href="{{ route('admin.transactions.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-2"></i>Clear Filters
                </a>
            @endif
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="table-container" data-aos="fade-up" data-aos-delay="700">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Transaction</th>
                        <th>Customer</th>
                        <th>Products</th>
                        <th>Total Quantity</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                        <tr data-aos="fade-right" data-aos-delay="{{ $loop->index * 100 }}">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="transaction-avatar me-3">
                                        <i class="fas fa-receipt text-primary"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight: 600;">
                                            TRX-{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</div>
                                        <small class="text-muted">by {{ $transaction->user->name ?? 'N/A' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 600;">{{ $transaction->customer->name ?? 'N/A' }}</div>
                                <small class="text-muted">{{ $transaction->customer->email ?? '' }}</small>
                            </td>
                            <td>
                                <div class="products-list">
                                    @php
                                        $products = $transaction->getAllProducts();
                                    @endphp
                                    @if ($products->count() > 0)
                                        @foreach ($products->take(2) as $productItem)
                                            @php
                                                $product = \App\Models\Product::find($productItem->product_id);
                                            @endphp
                                            <div class="product-item mb-1">
                                                <div style="font-weight: 600; font-size: 0.8rem;">
                                                    {{ $product->name ?? 'Product Not Found' }}
                                                </div>
                                                <small class="text-muted">
                                                    {{ $productItem->quantity }} pcs × Rp
                                                    {{ number_format($productItem->price, 0, ',', '.') }}
                                                </small>
                                            </div>
                                        @endforeach
                                        @if ($products->count() > 2)
                                            <div class="more-products">
                                                <small class="text-primary">
                                                    +{{ $products->count() - 2 }} more products
                                                </small>
                                            </div>
                                        @endif
                                    @else
                                        <div style="font-weight: 600; color: #64748b; font-size: 0.8rem;">
                                            {{ $transaction->product->name ?? 'N/A' }}
                                        </div>
                                        <small class="text-muted">
                                            {{ $transaction->quantity }} pcs × Rp
                                            {{ number_format($transaction->price, 0, ',', '.') }}
                                        </small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="quantity">{{ $transaction->getTotalQuantityAttribute() }} pcs</span>
                            </td>
                            <td>
                                <span class="price">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                <span class="status-badge {{ $transaction->status }}">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="payment-badge {{ $transaction->payment_status }}">
                                    {{ ucfirst($transaction->payment_status) }}
                                </span>
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($transaction->created_at)->format('M j, Y') }}
                                <br>
                                <small
                                    class="text-muted">{{ \Carbon\Carbon::parse($transaction->created_at)->format('H:i') }}</small>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.transactions.show', $transaction) }}"
                                        class="btn-icon btn-icon-view" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.transactions.edit', $transaction) }}"
                                        class="btn-icon btn-icon-edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn-icon btn-icon-delete delete-transaction-btn"
                                        title="Delete" data-transaction-id="{{ $transaction->id }}"
                                        data-transaction-code="TRX-{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <i class="fas fa-exchange-alt"></i>
                                    <h4>No transactions found</h4>
                                    <p>No transactions match your current filters.</p>
                                    @if (request()->hasAny(['search', 'status', 'payment_status', 'date_from', 'date_to', 'sort']))
                                        <a href="{{ route('admin.transactions.index') }}" class="btn btn-primary">
                                            <i class="fas fa-times me-2"></i>Clear Filters
                                        </a>
                                    @else
                                        <a href="{{ route('admin.transactions.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Add New Transaction
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Enhanced Pagination -->
        @if ($transactions->hasPages())
            <div class="pagination-container">
                <div class="pagination-info">
                    Menampilkan
                    <strong>{{ $transactions->firstItem() ?? 0 }}</strong>
                    sampai
                    <strong>{{ $transactions->lastItem() ?? 0 }}</strong>
                    dari
                    <strong>{{ $transactions->total() }}</strong>
                    transaksi
                </div>

                <nav class="pagination-nav">
                    <ul class="pagination">
                        <!-- Previous Page Link -->
                        @if ($transactions->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">
                                    <i class="fas fa-chevron-left"></i>
                                </span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $transactions->previousPageUrl() }}" rel="prev">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                        @endif

                        <!-- Pagination Elements -->
                        @php
                            $current = $transactions->currentPage();
                            $last = $transactions->lastPage();
                            $start = max(1, $current - 2);
                            $end = min($last, $current + 2);
                        @endphp

                        <!-- First Page Link -->
                        @if ($start > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $transactions->url(1) }}">1</a>
                            </li>
                            @if ($start > 2)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                        @endif

                        <!-- Page Number Links -->
                        @for ($i = $start; $i <= $end; $i++)
                            <li class="page-item {{ $i == $current ? 'active' : '' }}">
                                @if ($i == $current)
                                    <span class="page-link">{{ $i }}</span>
                                @else
                                    <a class="page-link" href="{{ $transactions->url($i) }}">{{ $i }}</a>
                                @endif
                            </li>
                        @endfor

                        <!-- Last Page Link -->
                        @if ($end < $last)
                            @if ($end < $last - 1)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                            <li class="page-item">
                                <a class="page-link" href="{{ $transactions->url($last) }}">{{ $last }}</a>
                            </li>
                        @endif

                        <!-- Next Page Link -->
                        @if ($transactions->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $transactions->nextPageUrl() }}" rel="next">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">
                                    <i class="fas fa-chevron-right"></i>
                                </span>
                            </li>
                        @endif
                    </ul>
                </nav>

                <!-- Page Size Selector -->
                <div class="page-size-selector">
                    <label class="form-label">Items per page:</label>
                    <select class="form-select form-select-sm" id="perPageSelect"
                        style="width: auto; display: inline-block;">
                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </div>
            </div>
        @endif
    </div>

    <!-- Delete Form (Hidden) -->
    <form id="deleteTransactionForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-submit filter form ketika dropdown berubah
            const filterSelects = document.querySelectorAll('#statusSelect, #paymentSelect, #sortSelect');
            filterSelects.forEach(select => {
                select.addEventListener('change', function() {
                    document.getElementById('filterForm').submit();
                });
            });

            // Auto-submit search dengan debounce
            let searchTimeout;
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', function(e) {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        this.closest('form').submit();
                    }, 800);
                });
            }

            // Delete button functionality dengan SweetAlert
            const deleteButtons = document.querySelectorAll('.delete-transaction-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const transactionId = this.getAttribute('data-transaction-id');
                    const transactionCode = this.getAttribute('data-transaction-code');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: `You are about to delete transaction "${transactionCode}". This action cannot be undone!`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.getElementById('deleteTransactionForm');
                            form.action = `/admin/transactions/${transactionId}`;
                            form.submit();
                        }
                    });
                });
            });

            // Per page selector
            const perPageSelect = document.getElementById('perPageSelect');
            if (perPageSelect) {
                perPageSelect.addEventListener('change', function() {
                    const url = new URL(window.location.href);
                    url.searchParams.set('per_page', this.value);
                    url.searchParams.set('page', '1'); // Reset ke page 1 ketika ganti per_page
                    window.location.href = url.toString();
                });
            }
        });

        function exportTransactions() {
            // Build export URL dengan parameter filter saat ini
            const currentParams = new URLSearchParams(window.location.search);
            const exportUrl = '{{ route('admin.transactions.export.pdf') }}?' + currentParams.toString();

            Swal.fire({
                title: 'Export Transactions',
                text: 'Choose export format',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'PDF Format',
                cancelButtonText: 'Cancel',
                showDenyButton: true,
                denyButtonText: 'Excel Format',
                denyButtonColor: '#059669'
            }).then((result) => {
                if (result.isConfirmed) {
                    // PDF Export
                    Swal.fire({
                        icon: 'info',
                        title: 'Generating PDF',
                        text: 'Please wait while we prepare your PDF report...',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Trigger download
                    window.location.href = exportUrl;

                    // Close loading after a delay
                    setTimeout(() => {
                        Swal.close();
                    }, 2000);

                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire('Cancelled', 'Export has been cancelled', 'info');
                }
            });
        }
    </script>
@endpush
