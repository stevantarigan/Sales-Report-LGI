@extends('layouts.app')

@section('title', 'Customers Management | SuperAdmin')
@section('page-title', 'Customer Management')
@section('page-description', 'Kelola data pelanggan dan informasi kontak')

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

        /* WhatsApp Link Styles */
        .whatsapp-link {
            color: #25D366;
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 6px;
            border-radius: 4px;
        }

        .whatsapp-link:hover {
            color: #128C7E;
            background: rgba(37, 211, 102, 0.1);
            transform: translateY(-1px);
        }

        .phone-text {
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .fa-whatsapp {
            color: #25D366;
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

        /* Customer Avatar */
        .customer-avatar {
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

        .customer-avatar:hover {
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

        .badge-primary {
            background: rgba(79, 70, 229, 0.1);
            color: var(--primary-color);
        }

        .badge-secondary {
            background: rgba(100, 116, 139, 0.1);
            color: #64748b;
        }

        .badge-warning {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning-color);
        }

        /* Status Badge */
        .status-badge.active {
            color: var(--success-color);
            font-weight: 600;
            background: rgba(16, 185, 129, 0.1);
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            display: inline-block;
        }

        .status-badge.inactive {
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

        /* WhatsApp Action Button */
        .btn-icon-whatsapp {
            background: rgba(37, 211, 102, 0.1);
            color: #25D366;
            border: 1px solid rgba(37, 211, 102, 0.2);
        }

        .btn-icon-whatsapp:hover {
            background: #25D366;
            color: white;
            transform: scale(1.1);
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

        /* Contact Info */
        .contact-info {
            font-size: 0.875rem;
        }

        .email-text {
            color: var(--primary-color);
            font-weight: 500;
        }

        .phone-text {
            color: #64748b;
        }

        /* Location Info */
        .location-info {
            font-size: 0.8rem;
            color: #64748b;
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
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-value">{{ $totalCustomers ?? $customers->total() }}</div>
            <div class="stat-label">Total Customers</div>
        </div>

        <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
            <div class="stat-icon" style="background: var(--gradient-success);">
                <i class="fab fa-whatsapp"></i>
            </div>
            <div class="stat-value">{{ $customersWithPhone ?? $customers->whereNotNull('phone')->count() }}</div>
            <div class="stat-label">With WhatsApp</div>
        </div>

        <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
            <div class="stat-icon" style="background: var(--gradient-warning);">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="stat-value">{{ $customersWithAddress ?? $customers->whereNotNull('address')->count() }}</div>
            <div class="stat-label">With Address</div>
        </div>

        <div class="stat-card" data-aos="fade-up" data-aos-delay="400">
            <div class="stat-icon" style="background: var(--gradient-danger);">
                <i class="fas fa-calendar"></i>
            </div>
            <div class="stat-value">
                {{ $newCustomersThisMonth ?? $customers->where('created_at', '>=', now()->startOfMonth())->count() }}</div>
            <div class="stat-label">New This Month</div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section" data-aos="fade-up" data-aos-delay="500">
        <form action="{{ route('admin.customers.index') }}" method="GET">
            <div class="filter-row">
                <div>
                    <label class="form-label">Search Customers</label>
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" class="form-control"
                            placeholder="Search by name, email, city..." value="{{ request('search') }}">
                    </div>
                </div>

                <div>
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Has WhatsApp</label>
                    <select name="has_phone" class="form-control">
                        <option value="">All</option>
                        <option value="yes" {{ request('has_phone') == 'yes' ? 'selected' : '' }}>With WhatsApp</option>
                        <option value="no" {{ request('has_phone') == 'no' ? 'selected' : '' }}>Without WhatsApp
                        </option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Sort By</label>
                    <select name="sort" class="form-control">
                        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Newest First
                        </option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                        <option value="city" {{ request('sort') == 'city' ? 'selected' : '' }}>City</option>
                    </select>
                </div>

                <div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i>Apply Filters
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Action Bar -->
    <div class="action-bar" data-aos="fade-up" data-aos-delay="600">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="quickSearch" class="form-control" placeholder="Quick search...">
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.customers.create') }}" class="btn btn-success">
                <i class="fas fa-plus me-2"></i>Add New Customer
            </a>
            <button class="btn btn-primary" onclick="exportCustomers()">
                <i class="fas fa-download me-2"></i>Export
            </button>
        </div>
    </div>

    <!-- Customers Table -->
    <div class="table-container" data-aos="fade-up" data-aos-delay="700">
        @if ($customers->count() > 0)
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
                    <option value="activate">Activate</option>
                    <option value="deactivate">Deactivate</option>
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
                        <th>Customer</th>
                        <th>Contact Information</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Transactions</th>
                        <th>Registered</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                        <tr data-aos="fade-right" data-aos-delay="{{ $loop->index * 100 }}">
                            <td>
                                <input type="checkbox" class="form-check-input customer-checkbox"
                                    value="{{ $customer->id }}">
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="customer-avatar me-3">
                                        <i class="fas fa-user text-primary"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight: 600;">{{ $customer->name }}</div>
                                        <small class="text-muted">ID: {{ $customer->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="contact-info">
                                    <div class="email-text">
                                        <i class="fas fa-envelope me-1"></i>
                                        {{ $customer->email }}
                                    </div>
                                    @if ($customer->phone)
                                        <div class="phone-text mt-1">
                                            <i class="fab fa-whatsapp me-1"></i>
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $customer->phone) }}"
                                                target="_blank" class="whatsapp-link"
                                                title="Chat via WhatsApp dengan {{ $customer->name }}">
                                                {{ $customer->phone }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="location-info">
                                    @if ($customer->city)
                                        <div><i class="fas fa-city me-1"></i>{{ $customer->city }}</div>
                                    @endif
                                    @if ($customer->province)
                                        <div><i class="fas fa-map me-1"></i>{{ $customer->province }}</div>
                                    @endif
                                    @if ($customer->address)
                                        <div class="text-muted mt-1">
                                            <small><i
                                                    class="fas fa-location-dot me-1"></i>{{ Str::limit($customer->address, 25) }}</small>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if ($customer->is_active)
                                    <span class="status-badge active">Active</span>
                                @else
                                    <span class="status-badge inactive">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-secondary">
                                    {{ $customer->transactions_count ?? 0 }} transaksi
                                </span>
                            </td>
                            <td>
                                {{ $customer->created_at->format('M j, Y') }}
                                <br>
                                <small class="text-muted">{{ $customer->created_at->diffForHumans() }}</small>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    @if ($customer->phone)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $customer->phone) }}"
                                            target="_blank" class="btn-icon btn-icon-whatsapp" title="Chat via WhatsApp">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.customers.show', $customer) }}"
                                        class="btn-icon btn-icon-view" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.customers.edit', $customer) }}"
                                        class="btn-icon btn-icon-edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon btn-icon-delete" title="Delete"
                                            onclick="return confirm('Are you sure you want to delete this customer?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="fas fa-user-friends"></i>
                                    <h4>No customers found</h4>
                                    <p>Get started by adding your first customer to the system.</p>
                                    <a href="{{ route('admin.customers.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Add New Customer
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($customers->hasPages())
            <div class="pagination-container">
                <div class="text-muted">
                    Showing {{ $customers->firstItem() }} to {{ $customers->lastItem() }} of {{ $customers->total() }}
                    customers
                </div>
                <nav>
                    {{ $customers->links() }}
                </nav>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    const checkboxes = document.querySelectorAll('.customer-checkbox');
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = e.target.checked;
                    });
                });
            }

            // WhatsApp link dengan SweetAlert2
            const whatsappLinks = document.querySelectorAll('.whatsapp-link, .btn-icon-whatsapp');
            whatsappLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    const customerName = this.closest('tr').querySelector(
                        'td:nth-child(2) div div:first-child').textContent;
                    const customerPhone = this.closest('tr').querySelector('.whatsapp-link')
                        ?.textContent ||
                        this.getAttribute('href')?.replace('https://wa.me/', '');
                    const whatsappUrl = this.getAttribute('href');

                    Swal.fire({
                        title: 'Buka WhatsApp?',
                        html: `
                            <div class="text-start">
                                <div class="mb-3">
                                    <strong>Customer:</strong> ${customerName}
                                </div>
                                <div class="mb-3">
                                    <strong>Nomor:</strong> 
                                    <span class="text-success fw-bold">${customerPhone}</span>
                                </div>
                                <div class="alert alert-info mt-2">
                                    <small>
                                        <i class="fas fa-info-circle me-1"></i>
                                        Anda akan diarahkan ke aplikasi WhatsApp untuk memulai percakapan
                                    </small>
                                </div>
                            </div>
                        `,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Buka WhatsApp',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#25D366',
                        cancelButtonColor: '#6c757d',
                        reverseButtons: true,
                        customClass: {
                            popup: 'whatsapp-swal',
                            confirmButton: 'btn-whatsapp-swal',
                            cancelButton: 'btn-cancel-swal'
                        },
                        buttonsStyling: false,
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.open(whatsappUrl, '_blank');

                            // Tampilkan notifikasi sukses
                            Swal.fire({
                                title: 'Berhasil!',
                                text: `WhatsApp dibuka untuk ${customerName}`,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false,
                                timerProgressBar: true,
                                toast: true,
                                position: 'top-end'
                            });
                        }
                    });
                });
            });
        });

        function handleBulkAction(action) {
            const selectedCustomers = Array.from(document.querySelectorAll('.customer-checkbox:checked'))
                .map(checkbox => checkbox.value);

            if (selectedCustomers.length === 0) {
                showNotification('Please select at least one customer.', 'error');
                return;
            }

            if (action === 'delete') {
                Swal.fire({
                    title: 'Hapus Customer?',
                    text: `Anda akan menghapus ${selectedCustomers.length} customer. Tindakan ini tidak dapat dibatalkan!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Implement delete logic here
                        showNotification(`${selectedCustomers.length} customer berhasil dihapus`, 'success');
                    }
                });
                return;
            }

            // Implement other bulk actions
            showNotification(`Bulk action "${action}" would be performed on ${selectedCustomers.length} customers`, 'info');
        }

        function exportCustomers() {
            Swal.fire({
                title: 'Export Data Customer',
                text: 'Data customer akan diexport dalam format Excel',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Export',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#4f46e5',
                customClass: {
                    confirmButton: 'btn-export-swal'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Implement export logic here
                    showNotification('Data customer berhasil diexport', 'success');
                }
            });
        }

        // Global helper function untuk notifications dengan SweetAlert2
        function showNotification(message, type = 'info') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: type,
                title: message
            });
        }
    </script>

    <style>
        /* SweetAlert2 Custom Styles */
        .swal2-popup {
            border-radius: 16px;
            padding: 2rem;
        }

        .whatsapp-swal .swal2-title {
            color: #25D366;
            font-weight: 600;
        }

        .btn-whatsapp-swal {
            background: #25D366 !important;
            color: white !important;
            border: none !important;
            border-radius: 8px !important;
            padding: 10px 24px !important;
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
        }

        .btn-whatsapp-swal:hover {
            background: #128C7E !important;
            transform: translateY(-2px) !important;
        }

        .btn-cancel-swal {
            background: #6c757d !important;
            color: white !important;
            border: none !important;
            border-radius: 8px !important;
            padding: 10px 24px !important;
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
        }

        .btn-cancel-swal:hover {
            background: #5a6268 !important;
            transform: translateY(-2px) !important;
        }

        .btn-export-swal {
            background: #4f46e5 !important;
            color: white !important;
            border: none !important;
            border-radius: 8px !important;
            padding: 10px 24px !important;
            font-weight: 600 !important;
        }

        /* WhatsApp link hover effects */
        .whatsapp-link {
            position: relative;
            transition: all 0.3s ease;
        }

        .whatsapp-link:hover::after {
            content: 'Klik untuk chat WhatsApp';
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: #25D366;
            color: white;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 0.75rem;
            white-space: nowrap;
            z-index: 1000;
        }

        .whatsapp-link:hover::before {
            content: '';
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            border: 5px solid transparent;
            border-top-color: #25D366;
            margin-bottom: -5px;
        }
    </style>
@endpush
