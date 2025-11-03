@extends('layouts.app')

@section('title', 'Transactions Management | SuperAdmin')
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

        /* Filter Section */
        .filter-section {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 1.8rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--card-shadow);
        }

        .filter-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.2rem;
            align-items: end;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            width: 100%;
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            outline: none;
        }

        /* Action Bar */
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
            min-width: 320px;
        }

        .search-box input {
            padding-left: 3rem;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            transition: var(--transition);
            background: white;
        }

        .search-box input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        .btn {
            padding: 0.8rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: var(--gradient-primary);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.4);
        }

        .btn-success {
            background: var(--gradient-success);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.4);
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
        }

        .table thead th {
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
            padding: 1rem;
            font-weight: 600;
            color: var(--dark-color);
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        .table tbody tr:hover {
            background: #f8fafc;
        }

        /* Transaction Avatar */
        .transaction-avatar {
            width: 60px;
            height: 60px;
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

        /* Badge Styles */
        .badge {
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
        }

        .badge-danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error-color);
        }

        .badge-primary {
            background: rgba(79, 70, 229, 0.1);
            color: var(--primary-color);
        }

        .badge-warning {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning-color);
        }

        .badge-secondary {
            background: rgba(100, 116, 139, 0.1);
            color: #64748b;
        }

        /* Status Badge */
        .status-badge.completed {
            color: var(--success-color);
            font-weight: 600;
            background: rgba(16, 185, 129, 0.1);
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            display: inline-block;
        }

        .status-badge.pending {
            color: var(--warning-color);
            font-weight: 600;
            background: rgba(245, 158, 11, 0.1);
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            display: inline-block;
        }

        .status-badge.cancelled {
            color: var(--error-color);
            font-weight: 600;
            background: rgba(239, 68, 68, 0.1);
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            display: inline-block;
        }

        /* Payment Status Badge */
        .payment-badge.paid {
            color: var(--success-color);
            font-weight: 600;
            background: rgba(16, 185, 129, 0.1);
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            display: inline-block;
        }

        .payment-badge.pending {
            color: var(--warning-color);
            font-weight: 600;
            background: rgba(245, 158, 11, 0.1);
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            display: inline-block;
        }

        .payment-badge.cancelled {
            color: var(--error-color);
            font-weight: 600;
            background: rgba(239, 68, 68, 0.1);
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            display: inline-block;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 0.6rem;
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: var(--transition);
            border: 1px solid transparent;
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
        }

        .quantity {
            font-weight: 600;
            color: #64748b;
        }

        /* Bulk Actions */
        .bulk-actions {
            background: rgba(79, 70, 229, 0.05);
            padding: 1.2rem 1.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: var(--transition);
        }

        .bulk-actions:hover {
            background: rgba(79, 70, 229, 0.08);
        }

        .form-check-input {
            margin-right: 0.5rem;
        }

        .form-select {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 0.5rem;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #64748b;
        }

        .empty-state i {
            font-size: 5rem;
            margin-bottom: 1.5rem;
            opacity: 0.5;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .empty-state h4 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--dark-color);
        }

        .empty-state p {
            font-size: 1rem;
            margin-bottom: 2rem;
            color: #64748b;
        }

        /* Pagination */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            border-top: 1px solid #e2e8f0;
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
                gap: 1rem;
                text-align: center;
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
                width: 32px;
                height: 32px;
            }
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
            <div class="stat-value">{{ $totalTransactions ?? $transactions->total() }}</div>
            <div class="stat-label">Total Transactions</div>
        </div>

        <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
            <div class="stat-icon" style="background: var(--gradient-success);">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-value">{{ $completedTransactions ?? $transactions->where('status', 'completed')->count() }}
            </div>
            <div class="stat-label">Completed</div>
        </div>

        <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
            <div class="stat-icon" style="background: var(--gradient-warning);">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-value">{{ $pendingTransactions ?? $transactions->where('status', 'pending')->count() }}</div>
            <div class="stat-label">Pending</div>
        </div>

        <div class="stat-card" data-aos="fade-up" data-aos-delay="400">
            <div class="stat-icon" style="background: var(--gradient-danger);">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stat-value">{{ $cancelledTransactions ?? $transactions->where('status', 'cancelled')->count() }}
            </div>
            <div class="stat-label">Cancelled</div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section" data-aos="fade-up" data-aos-delay="500">
        <form action="{{ route('admin.transactions.index') }}" method="GET">
            <div class="filter-row">
                <div>
                    <label class="form-label">Search Transactions</label>
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" class="form-control"
                            placeholder="Search by customer, product..." value="{{ request('search') }}">
                    </div>
                </div>

                <div>
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
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
                    <select name="payment_status" class="form-control">
                        <option value="">All Payment Status</option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending
                        </option>
                        <option value="cancelled" {{ request('payment_status') == 'cancelled' ? 'selected' : '' }}>
                            Cancelled</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Date Range</label>
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>

                <div>
                    <label class="form-label">To</label>
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>

                <div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i>Apply Filters
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Action Bar - YANG SUDAH DIPERBAIKI -->
    <div class="action-bar" data-aos="fade-up" data-aos-delay="600">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="quickSearch" class="form-control" placeholder="Quick search...">
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.transactions.create') }}" class="btn btn-success">
                <i class="fas fa-plus me-2"></i>Add New Transaction
            </a>
            <button class="btn btn-primary" onclick="exportTransactions()">
                <i class="fas fa-download me-2"></i>Export
            </button>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="table-container" data-aos="fade-up" data-aos-delay="700">
        @if ($transactions->count() > 0)
            <!-- Bulk Actions -->
            <div class="bulk-actions">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="selectAll">
                    <label class="form-check-label" for="selectAll">
                        Select All
                    </label>
                </div>
                <select class="form-select form-select-sm" style="width: auto;" onchange="handleBulkAction(this.value)">
                    <option value="">Bulk Actions</option>
                    <option value="complete">Mark as Completed</option>
                    <option value="cancel">Mark as Cancelled</option>
                    <option value="delete">Delete</option>
                </select>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="50">
                            <input type="checkbox" class="form-check-input">
                        </th>
                        <th>Transaction</th>
                        <th>Customer</th>
                        <th>Product</th>
                        <th>Quantity</th>
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
                                <input type="checkbox" class="form-check-input transaction-checkbox"
                                    value="{{ $transaction->id }}">
                            </td>
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
                                <div style="font-weight: 600;">{{ $transaction->product->name ?? 'N/A' }}</div>
                                <small class="text-muted">Rp {{ number_format($transaction->price, 0, ',', '.') }}</small>
                            </td>
                            <td>
                                <span class="quantity">{{ $transaction->quantity }} pcs</span>
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
                                    <form action="{{ route('admin.transactions.destroy', $transaction) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon btn-icon-delete" title="Delete"
                                            onclick="return confirm('Are you sure you want to delete this transaction?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">
                                <div class="empty-state">
                                    <i class="fas fa-exchange-alt"></i>
                                    <h4>No transactions found</h4>
                                    <p>Get started by creating your first transaction.</p>
                                    <a href="{{ route('admin.transactions.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Add New Transaction
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($transactions->hasPages())
            <div class="pagination-container">
                <div class="text-muted">
                    Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} of
                    {{ $transactions->total() }} transactions
                </div>
                <nav>
                    {{ $transactions->links() }}
                </nav>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Quick search functionality
            const quickSearch = document.getElementById('quickSearch');
            if (quickSearch) {
                quickSearch.addEventListener('input', function(e) {
                    const searchTerm = e.target.value.toLowerCase();
                    const rows = document.querySelectorAll('tbody tr');

                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                });
            }

            // Select all functionality
            const selectAll = document.getElementById('selectAll');
            if (selectAll) {
                selectAll.addEventListener('change', function(e) {
                    const checkboxes = document.querySelectorAll('.transaction-checkbox');
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = e.target.checked;
                    });
                });
            }
        });

        function handleBulkAction(action) {
            const selectedTransactions = Array.from(document.querySelectorAll('.transaction-checkbox:checked'))
                .map(checkbox => checkbox.value);

            if (selectedTransactions.length === 0) {
                showNotification('Please select at least one transaction.', 'error');
                return;
            }

            if (action === 'delete') {
                if (!confirm(`Are you sure you want to delete ${selectedTransactions.length} transaction(s)?`)) {
                    return;
                }
            }

            console.log('Bulk action:', action, 'on transactions:', selectedTransactions);

            // Implement bulk action logic here
            showNotification(`Bulk action "${action}" would be performed on ${selectedTransactions.length} transactions`,
                'info');
        }

        function exportTransactions() {
            showNotification('Export functionality would be implemented here', 'info');
        }

        // Global helper function untuk notifications
        function showNotification(message, type = 'info') {
            const alertClass = type === 'success' ? 'alert-success' :
                type === 'error' ? 'alert-danger' : 'alert-info';
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
            alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            alertDiv.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 
                             type === 'error' ? 'fa-exclamation-triangle' : 'fa-info-circle'} me-2"></i>
                <div>${message}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        `;
            document.body.appendChild(alertDiv);

            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.parentNode.removeChild(alertDiv);
                }
            }, 5000);
        }
    </script>
@endpush
