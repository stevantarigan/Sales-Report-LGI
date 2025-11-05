@extends('layouts.app')

@section('title', 'Product Management | SuperAdmin')
@section('page-title', 'Product Management')
@section('page-description', 'Manage your product inventory and catalog')

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

        /* Product Image */
        .product-img {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            object-fit: cover;
            border: 2px solid #e2e8f0;
            transition: var(--transition);
        }

        .product-img:hover {
            transform: scale(1.1);
            border-color: var(--primary-color);
        }

        .product-img-placeholder {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            font-size: 0.8rem;
        }

        /* Badge Styles */
        .badge {
            padding: 0.3rem 0.6rem;
            border-radius: 6px;
            font-size: 0.7rem;
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

        .badge-secondary {
            background: rgba(100, 116, 139, 0.1);
            color: #64748b;
        }

        .badge-warning {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning-color);
        }

        /* Stock Status */
        .stock-status {
            font-size: 0.75rem;
            padding: 0.3rem 0.6rem;
            border-radius: 6px;
            font-weight: 600;
            display: inline-block;
        }

        .stock-status.in-stock {
            color: var(--success-color);
            background: rgba(16, 185, 129, 0.1);
        }

        .stock-status.low-stock {
            color: var(--warning-color);
            background: rgba(245, 158, 11, 0.1);
        }

        .stock-status.out-of-stock {
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

        /* Pagination */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.2rem;
            border-top: 1px solid #e2e8f0;
            font-size: 0.85rem;
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
                width: 28px;
                height: 28px;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
            <div class="stat-icon" style="background: var(--gradient-primary);">
                <i class="fas fa-boxes"></i>
            </div>
            <div class="stat-value">{{ $totalProducts }}</div>
            <div class="stat-label">Total Products</div>
        </div>

        <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
            <div class="stat-icon" style="background: var(--gradient-success);">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-value">{{ $activeProducts }}</div>
            <div class="stat-label">Active Products</div>
        </div>

        <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
            <div class="stat-icon" style="background: var(--gradient-warning);">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-value">{{ $lowStockProducts }}</div>
            <div class="stat-label">Low Stock</div>
        </div>

        <div class="stat-card" data-aos="fade-up" data-aos-delay="400">
            <div class="stat-icon" style="background: var(--gradient-danger);">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stat-value">{{ $outOfStockProducts }}</div>
            <div class="stat-label">Out of Stock</div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section" data-aos="fade-up" data-aos-delay="500">
        <form action="{{ route('products.index') }}" method="GET" id="filterForm">
            <div class="filter-row">
                <div>
                    <label class="form-label">Category</label>
                    <select name="category" class="form-select" id="categorySelect">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" id="statusSelect">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="featured" {{ request('status') == 'featured' ? 'selected' : '' }}>Featured</option>
                        <option value="low_stock" {{ request('status') == 'low_stock' ? 'selected' : '' }}>Low Stock
                        </option>
                        <option value="out_of_stock" {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>Out of
                            Stock</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Sort By</label>
                    <select name="sort" class="form-select" id="sortSelect">
                        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Newest First
                        </option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                        <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Price Low-High</option>
                        <option value="stock_quantity" {{ request('sort') == 'stock_quantity' ? 'selected' : '' }}>Stock
                            Level</option>
                    </select>
                </div>

                <div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i>Apply Filters
                    </button>
                </div>
            </div>

            <!-- Hidden search input untuk maintain search value -->
            @if (request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif
        </form>
    </div>

    <!-- Action Bar -->
    <div class="action-bar" data-aos="fade-up" data-aos-delay="600">
        <form action="{{ route('products.index') }}" method="GET" class="d-flex gap-2 align-items-center">
            <!-- Maintain existing filters -->
            @if (request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            @if (request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            @if (request('sort'))
                <input type="hidden" name="sort" value="{{ request('sort') }}">
            @endif

            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" name="search" class="form-control" placeholder="Search by name, SKU, category..."
                    value="{{ request('search') }}" id="searchInput">
            </div>

            <button type="submit" class="btn btn-primary" style="display: none;" id="searchSubmit">Search</button>
        </form>

        <div class="d-flex gap-2">
            <a href="{{ route('products.create') }}" class="btn btn-success">
                <i class="fas fa-plus me-2"></i>Add New Product
            </a>
            <button class="btn btn-primary" onclick="exportProducts()">
                <i class="fas fa-download me-2"></i>Export
            </button>

            <!-- Clear Filters Button -->
            @if (request()->hasAny(['search', 'category', 'status', 'sort']))
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-2"></i>Clear Filters
                </a>
            @endif
        </div>
    </div>

    <!-- Products Table -->
    <div class="table-container" data-aos="fade-up" data-aos-delay="700">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th>Last Updated</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr data-aos="fade-right" data-aos-delay="{{ $loop->index * 100 }}">
                            <td>
                                <div class="d-flex align-items-center">
                                    @if ($product->image)
                                        <img src="{{ Storage::disk('public')->exists($product->image) ? asset('storage/' . $product->image) : 'https://via.placeholder.com/60x60?text=No+Image' }}"
                                            alt="{{ $product->name }}" class="product-img me-3"
                                            onerror="this.src='https://via.placeholder.com/60x60?text=Image+Error'">
                                    @else
                                        <div class="product-img-placeholder me-3">
                                            <i class="fas fa-box"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div style="font-weight: 600;">{{ $product->name }}</div>
                                        @if ($product->brand)
                                            <small class="text-muted">{{ $product->brand }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <code>{{ $product->sku }}</code>
                            </td>
                            <td>
                                <span class="badge badge-secondary">{{ $product->category }}</span>
                            </td>
                            <td>
                                <strong>${{ number_format($product->price, 2) }}</strong>
                                @if ($product->cost_price)
                                    <br>
                                    <small class="text-muted">
                                        Cost: ${{ number_format($product->cost_price, 2) }}
                                    </small>
                                @endif
                            </td>
                            <td>
                                <div>
                                    <span
                                        class="stock-status 
                                        @if ($product->stock_quantity == 0) out-of-stock
                                        @elseif($product->stock_quantity <= $product->min_stock) low-stock
                                        @else in-stock @endif">
                                        {{ $product->stock_quantity }}
                                    </span>
                                    <small class="text-muted d-block">
                                        Min: {{ $product->min_stock }}
                                    </small>
                                </div>
                            </td>
                            <td>
                                @if ($product->is_active)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                @if ($product->is_featured)
                                    <span class="badge badge-primary">Featured</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                {{ $product->updated_at->format('M j, Y') }}
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('products.show', $product) }}" class="btn-icon btn-icon-view"
                                        title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('products.edit', $product) }}" class="btn-icon btn-icon-edit"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn-icon btn-icon-delete delete-product-btn"
                                        title="Delete" data-product-id="{{ $product->id }}"
                                        data-product-name="{{ $product->name }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <i class="fas fa-box-open"></i>
                                    <h4>No products found</h4>
                                    <p>No products match your current filters.</p>
                                    @if (request()->hasAny(['search', 'category', 'status', 'sort']))
                                        <a href="{{ route('products.index') }}" class="btn btn-primary">
                                            <i class="fas fa-times me-2"></i>Clear Filters
                                        </a>
                                    @else
                                        <a href="{{ route('products.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Add New Product
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($products->hasPages())
            <div class="pagination-container">
                <div class="text-muted">
                    Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }}
                    products
                </div>
                <nav>
                    {{ $products->appends(request()->query())->links() }}
                </nav>
            </div>
        @endif
    </div>

    <!-- Delete Form (Hidden) -->
    <form id="deleteProductForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-submit filter form ketika dropdown berubah
            const filterSelects = document.querySelectorAll('#categorySelect, #statusSelect, #sortSelect');
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
            const deleteButtons = document.querySelectorAll('.delete-product-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productId = this.getAttribute('data-product-id');
                    const productName = this.getAttribute('data-product-name');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: `You are about to delete product "${productName}". This action cannot be undone!`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.getElementById('deleteProductForm');
                            form.action = `/products/${productId}`;
                            form.submit();
                        }
                    });
                });
            });
        });

        function exportProducts() {
            // Build export URL dengan parameter filter saat ini
            const currentParams = new URLSearchParams(window.location.search);
            const exportUrl = '{{ route('products.index') }}?' + currentParams.toString() + '&export=true';

            Swal.fire({
                icon: 'info',
                title: 'Export Products',
                text: 'Preparing your export file...',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                window.location.href = exportUrl;
            });
        }
    </script>
@endpush
