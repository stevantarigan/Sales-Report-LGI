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

@section('title', $product->name . ' | Product Details | ' . ucfirst(auth()->user()->role))
@section('page-title', 'Product Details')
@section('page-description', 'View complete product information details')

@push('styles')
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
                --transition: all 0.3s ease;
                --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            }

            .detail-container {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 2rem;
                margin-bottom: 2rem;
            }

            @media (max-width: 968px) {
                .detail-container {
                    grid-template-columns: 1fr;
                }
            }

            .card {
                background: white;
                border-radius: 16px;
                padding: 2rem;
                box-shadow: var(--card-shadow);
                border: 1px solid #e2e8f0;
                height: fit-content;
            }

            .card-header {
                display: flex;
                align-items: center;
                justify-content: between;
                margin-bottom: 1.5rem;
                padding-bottom: 1rem;
                border-bottom: 2px solid #f1f5f9;
            }

            .card-title {
                font-size: 1.25rem;
                font-weight: 600;
                color: var(--dark-color);
                display: flex;
                align-items: center;
                gap: 0.75rem;
                margin: 0;
            }

            .card-title i {
                color: var(--primary-color);
            }

            /* Product Image */
            .product-image-container {
                text-align: center;
                padding: 2rem;
            }

            .product-image {
                max-width: 300px;
                max-height: 300px;
                border-radius: 12px;
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
                margin-bottom: 1.5rem;
            }

            .no-image {
                width: 200px;
                height: 200px;
                background: #f8fafc;
                border: 2px dashed #e2e8f0;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 1.5rem;
                color: #94a3b8;
            }

            .no-image i {
                font-size: 3rem;
            }

            /* Info Grid */
            .info-grid {
                display: grid;
                gap: 1.5rem;
            }

            .info-item {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                padding: 1rem 0;
                border-bottom: 1px solid #f1f5f9;
            }

            .info-item:last-child {
                border-bottom: none;
            }

            .info-label {
                font-weight: 600;
                color: var(--dark-color);
                min-width: 120px;
            }

            .info-value {
                color: #475569;
                text-align: right;
                flex: 1;
                margin-left: 1rem;
            }

            .info-value strong {
                color: var(--dark-color);
            }

            /* Badge Styles */
            .badge {
                padding: 0.5rem 1rem;
                border-radius: 6px;
                font-size: 0.875rem;
                font-weight: 600;
                display: inline-block;
            }

            .badge-success {
                background: rgba(16, 185, 129, 0.1);
                color: var(--success-color);
            }

            .badge-danger {
                background: rgba(239, 68, 68, 0.1);
                color: var(--error-color);
            }

            .badge-warning {
                background: rgba(245, 158, 11, 0.1);
                color: var(--warning-color);
            }

            .badge-primary {
                background: rgba(79, 70, 229, 0.1);
                color: var(--primary-color);
            }

            .badge-secondary {
                background: rgba(100, 116, 139, 0.1);
                color: #64748b;
            }

            /* Stock Status */
            .stock-status {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.5rem 1rem;
                border-radius: 6px;
                font-weight: 600;
            }

            .stock-status.in-stock {
                background: rgba(16, 185, 129, 0.1);
                color: var(--success-color);
            }

            .stock-status.low-stock {
                background: rgba(245, 158, 11, 0.1);
                color: var(--warning-color);
            }

            .stock-status.out-of-stock {
                background: rgba(239, 68, 68, 0.1);
                color: var(--error-color);
            }

            /* Price Display */
            .price-display {
                font-size: 1.5rem;
                font-weight: 700;
                color: var(--dark-color);
            }

            .cost-price {
                font-size: 0.875rem;
                color: #64748b;
                text-decoration: line-through;
                margin-left: 0.5rem;
            }

            .profit-margin {
                font-size: 0.875rem;
                font-weight: 600;
                margin-left: 0.5rem;
            }

            .profit-positive {
                color: var(--success-color);
            }

            .profit-negative {
                color: var(--error-color);
            }

            /* Specifications */
            .specs-grid {
                display: grid;
                gap: 1rem;
            }

            .spec-item {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.75rem 1rem;
                background: #f8fafc;
                border-radius: 8px;
                border-left: 4px solid var(--primary-color);
            }

            .spec-key {
                font-weight: 600;
                color: var(--dark-color);
            }

            .spec-value {
                color: #475569;
            }

            .no-specs {
                text-align: center;
                padding: 2rem;
                color: #64748b;
            }

            .no-specs i {
                font-size: 2rem;
                margin-bottom: 1rem;
                opacity: 0.5;
            }

            /* Action Buttons */
            .action-buttons {
                display: flex;
                gap: 1rem;
                justify-content: flex-end;
                margin-top: 2rem;
                padding-top: 2rem;
                border-top: 1px solid #e2e8f0;
            }

            .btn {
                padding: 0.75rem 1.5rem;
                border-radius: 10px;
                font-weight: 600;
                transition: var(--transition);
                border: none;
                cursor: pointer;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                font-size: 0.95rem;
            }

            .btn-primary {
                background: var(--gradient-primary);
                color: white;
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 20px rgba(79, 70, 229, 0.3);
            }

            .btn-secondary {
                background: #f1f5f9;
                color: #475569;
                border: 1px solid #e2e8f0;
            }

            .btn-secondary:hover {
                background: #e2e8f0;
                transform: translateY(-2px);
            }

            .btn-success {
                background: var(--success-color);
                color: white;
            }

            .btn-success:hover {
                background: #059669;
                transform: translateY(-2px);
            }

            .btn-warning {
                background: var(--warning-color);
                color: white;
            }

            .btn-warning:hover {
                background: #d97706;
                transform: translateY(-2px);
            }

            /* Stats Overview */
            .stats-overview {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 1rem;
                margin-bottom: 2rem;
            }

            .stat-card {
                background: white;
                border-radius: 12px;
                padding: 1.5rem;
                text-align: center;
                box-shadow: var(--card-shadow);
                border: 1px solid #e2e8f0;
            }

            .stat-value {
                font-size: 1.5rem;
                font-weight: 700;
                color: var(--dark-color);
                margin-bottom: 0.5rem;
            }

            .stat-label {
                font-size: 0.875rem;
                color: #64748b;
                font-weight: 500;
            }

            /* Timeline */
            .timeline {
                margin-top: 1.5rem;
            }

            .timeline-item {
                display: flex;
                align-items: flex-start;
                gap: 1rem;
                padding: 1rem 0;
                border-bottom: 1px solid #f1f5f9;
            }

            .timeline-item:last-child {
                border-bottom: none;
            }

            .timeline-icon {
                width: 32px;
                height: 32px;
                border-radius: 50%;
                background: #f1f5f9;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #64748b;
                flex-shrink: 0;
            }

            .timeline-content {
                flex: 1;
            }

            .timeline-title {
                font-weight: 600;
                color: var(--dark-color);
                margin-bottom: 0.25rem;
            }

            .timeline-date {
                font-size: 0.875rem;
                color: #64748b;
            }

            /* Description */
            .description-content {
                line-height: 1.6;
                color: #475569;
                white-space: pre-wrap;
            }

            /* Quick Actions */
            .quick-actions {
                display: flex;
                gap: 0.5rem;
                flex-wrap: wrap;
                margin-top: 1rem;
            }

            .quick-action-btn {
                padding: 0.5rem 1rem;
                border-radius: 6px;
                font-size: 0.875rem;
                font-weight: 500;
                transition: var(--transition);
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 0.25rem;
                border: 1px solid #e2e8f0;
                background: white;
                color: #475569;
            }

            .quick-action-btn:hover {
                background: #f8fafc;
                transform: translateY(-1px);
            }

            /* ============================ */
            /* MOBILE OPTIMIZATION STYLES */
            /* ============================ */

            @media (max-width: 768px) {
                .detail-container {
                    gap: 1rem;
                    margin-bottom: 1rem;
                }

                .card {
                    padding: 1.25rem;
                    border-radius: 12px;
                    margin-bottom: 1rem;
                }

                .card-header {
                    margin-bottom: 1rem;
                    padding-bottom: 0.75rem;
                }

                .card-title {
                    font-size: 1.1rem;
                }

                /* Stats Overview Mobile */
                .stats-overview {
                    grid-template-columns: repeat(2, 1fr);
                    gap: 0.75rem;
                    margin-bottom: 1.5rem;
                }

                .stat-card {
                    padding: 1rem;
                    border-radius: 10px;
                }

                .stat-value {
                    font-size: 1.25rem;
                    margin-bottom: 0.25rem;
                }

                .stat-label {
                    font-size: 0.8rem;
                }

                /* Product Image Mobile */
                .product-image-container {
                    padding: 1rem;
                }

                .product-image {
                    max-width: 200px;
                    max-height: 200px;
                    margin-bottom: 1rem;
                }

                .no-image {
                    width: 150px;
                    height: 150px;
                    margin-bottom: 1rem;
                }

                .no-image i {
                    font-size: 2rem;
                }

                /* Info Grid Mobile */
                .info-grid {
                    gap: 1rem;
                }

                .info-item {
                    flex-direction: column;
                    gap: 0.5rem;
                    padding: 0.75rem 0;
                    align-items: flex-start;
                }

                .info-label {
                    min-width: auto;
                    font-size: 0.9rem;
                }

                .info-value {
                    text-align: left;
                    margin-left: 0;
                    font-size: 0.9rem;
                }

                /* Specifications Mobile */
                .specs-grid {
                    gap: 0.75rem;
                }

                .spec-item {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 0.5rem;
                    padding: 1rem;
                }

                .spec-key {
                    font-size: 0.9rem;
                }

                .spec-value {
                    font-size: 0.9rem;
                }

                .no-specs {
                    padding: 1.5rem;
                }

                .no-specs i {
                    font-size: 1.5rem;
                }

                /* Action Buttons Mobile */
                .action-buttons {
                    flex-direction: column;
                    gap: 0.75rem;
                    margin-top: 1.5rem;
                    padding-top: 1.5rem;
                }

                .btn {
                    width: 100%;
                    justify-content: center;
                    padding: 1rem 1.5rem;
                    font-size: 1rem;
                }

                /* Quick Actions Mobile */
                .quick-actions {
                    justify-content: center;
                    gap: 0.5rem;
                }

                .quick-action-btn {
                    flex: 1;
                    min-width: 120px;
                    justify-content: center;
                    padding: 0.75rem;
                    font-size: 0.8rem;
                }

                /* Price Display Mobile */
                .price-display {
                    font-size: 1.25rem;
                }

                /* Badge Mobile */
                .badge {
                    padding: 0.4rem 0.8rem;
                    font-size: 0.8rem;
                }

                /* Stock Status Mobile */
                .stock-status {
                    padding: 0.4rem 0.8rem;
                    font-size: 0.8rem;
                }

                /* Description Mobile */
                .description-content {
                    font-size: 0.9rem;
                    line-height: 1.5;
                }
            }

            @media (max-width: 480px) {
                .stats-overview {
                    grid-template-columns: 1fr;
                    gap: 0.5rem;
                }

                .stat-card {
                    padding: 0.75rem;
                }

                .stat-value {
                    font-size: 1.1rem;
                }

                .card {
                    padding: 1rem;
                }

                .product-image-container {
                    padding: 0.75rem;
                }

                .product-image {
                    max-width: 150px;
                    max-height: 150px;
                }

                .no-image {
                    width: 120px;
                    height: 120px;
                }

                .quick-actions {
                    flex-direction: column;
                }

                .quick-action-btn {
                    min-width: auto;
                }

                .info-item {
                    padding: 0.5rem 0;
                }

                .spec-item {
                    padding: 0.75rem;
                }
            }

            /* Touch-friendly improvements */
            @media (max-width: 768px) {

                .btn,
                .quick-action-btn,
                .spec-item {
                    min-height: 44px;
                    display: flex;
                    align-items: center;
                }

                .info-item,
                .card-header {
                    -webkit-tap-highlight-color: transparent;
                }
            }

            @media (max-width: 768px) {
                .detail-container {
                    padding-left: calc(1rem + env(safe-area-inset-left));
                    padding-right: calc(1rem + env(safe-area-inset-right));
                }
            }
        </style>
    @endpush

    @section('content')
        <!-- Stats Overview -->
        <div class="stats-overview" data-aos="fade-up">
            <div class="stat-card">
                <div class="stat-value">{{ $product->stock_quantity }}</div>
                <div class="stat-label">Current Stock</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">${{ number_format($product->price, 2) }}</div>
                <div class="stat-label">Selling Price</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">
                    @if ($product->cost_price)
                        ${{ number_format($product->cost_price, 2) }}
                    @else
                        N/A
                    @endif
                </div>
                <div class="stat-label">Cost Price</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">
                    @if ($product->cost_price && $product->price > 0)
                        {{ number_format($product->getProfitMarginAttribute(), 2) }}%
                    @else
                        N/A
                    @endif
                </div>
                <div class="stat-label">Profit Margin</div>
            </div>
        </div>

        <div class="detail-container">
            <!-- Left Column -->
            <div>
                <!-- Product Image & Basic Info -->
                <div class="card" data-aos="fade-right">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-image"></i>
                            Product Overview
                        </h3>
                    </div>

                    <div class="product-image-container">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                class="product-image"
                                onerror="this.style.display='none'; document.getElementById('fallbackImage').style.display='flex';">
                            <div id="fallbackImage" class="no-image" style="display: none;">
                                <i class="fas fa-image"></i>
                            </div>
                        @else
                            <div class="no-image">
                                <i class="fas fa-image"></i>
                            </div>
                        @endif

                        <h3>{{ $product->name }}</h3>
                        @if ($product->brand)
                            <p class="text-muted">{{ $product->brand }}</p>
                        @endif

                        <div class="quick-actions">
                            <a href="{{ route('products.edit', $product) }}" class="quick-action-btn">
                                <i class="fas fa-edit"></i>Edit
                            </a>
                            <a href="{{ route('products.index') }}" class="quick-action-btn">
                                <i class="fas fa-list"></i>All Products
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Specifications -->
                <div class="card" data-aos="fade-right" data-aos-delay="100">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-list-alt"></i>
                            Specifications
                        </h3>
                    </div>

                    <div class="specs-grid">
                        @if ($product->specifications && count($product->specifications) > 0)
                            @foreach ($product->specifications as $key => $value)
                                <div class="spec-item">
                                    <span class="spec-key">{{ $key }}</span>
                                    <span class="spec-value">{{ $value }}</span>
                                </div>
                            @endforeach
                        @else
                            <div class="no-specs">
                                <i class="fas fa-clipboard-list"></i>
                                <p>No specifications added</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div>
                <!-- Product Details -->
                <div class="card" data-aos="fade-left">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-info-circle"></i>
                            Product Details
                        </h3>
                    </div>

                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">SKU</span>
                            <span class="info-value">
                                <code>{{ $product->sku }}</code>
                            </span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Category</span>
                            <span class="info-value">
                                <span class="badge badge-secondary">{{ $product->category }}</span>
                            </span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Brand</span>
                            <span class="info-value">
                                {{ $product->brand ?: 'N/A' }}
                            </span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Supplier</span>
                            <span class="info-value">
                                {{ $product->supplier ?: 'N/A' }}
                            </span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Status</span>
                            <span class="info-value">
                                @if ($product->is_active)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif

                                @if ($product->is_featured)
                                    <span class="badge badge-primary ml-2">Featured</span>
                                @endif
                            </span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Created</span>
                            <span class="info-value">
                                {{ $product->created_at->format('M j, Y \a\t g:i A') }}
                            </span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Last Updated</span>
                            <span class="info-value">
                                {{ $product->updated_at->format('M j, Y \a\t g:i A') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Pricing & Inventory -->
                <div class="card" data-aos="fade-left" data-aos-delay="100">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-line"></i>
                            Pricing & Inventory
                        </h3>
                    </div>

                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Selling Price</span>
                            <span class="info-value">
                                <span class="price-display">${{ number_format($product->price, 2) }}</span>
                            </span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Cost Price</span>
                            <span class="info-value">
                                @if ($product->cost_price)
                                    ${{ number_format($product->cost_price, 2) }}
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Profit Margin</span>
                            <span class="info-value">
                                @if ($product->cost_price && $product->price > 0)
                                    @php
                                        $margin = $product->getProfitMarginAttribute();
                                        $class = $margin >= 0 ? 'profit-positive' : 'profit-negative';
                                    @endphp
                                    <span class="profit-margin {{ $class }}">
                                        {{ number_format($margin, 2) }}%
                                    </span>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Stock Quantity</span>
                            <span class="info-value">
                                <span
                                    class="stock-status 
                            @if ($product->stock_quantity == 0) out-of-stock
                            @elseif($product->stock_quantity <= $product->min_stock) low-stock
                            @else in-stock @endif">
                                    <i
                                        class="fas 
                                @if ($product->stock_quantity == 0) fa-times-circle
                                @elseif($product->stock_quantity <= $product->min_stock) fa-exclamation-triangle
                                @else fa-check-circle @endif">
                                    </i>
                                    {{ $product->stock_quantity }} units
                                </span>
                            </span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Minimum Stock</span>
                            <span class="info-value">
                                {{ $product->min_stock }} units
                            </span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Stock Status</span>
                            <span class="info-value">
                                @if ($product->stock_quantity == 0)
                                    <span class="badge badge-danger">Out of Stock</span>
                                @elseif($product->stock_quantity <= $product->min_stock)
                                    <span class="badge badge-warning">Low Stock</span>
                                @else
                                    <span class="badge badge-success">In Stock</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                @if ($product->description)
                    <div class="card" data-aos="fade-left" data-aos-delay="200">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-align-left"></i>
                                Description
                            </h3>
                        </div>

                        <div class="description-content">
                            {{ $product->description }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Products
            </a>
            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Edit Product
            </a>
        </div>
    @endsection

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Add any interactive functionality here if needed
                console.log('Product details page loaded');
            });
        </script>
    @endpush
