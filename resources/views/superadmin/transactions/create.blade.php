@php
    $layout = auth()->user()->role === 'adminsales' ? 'layouts.app2' : 'layouts.app';
@endphp

@extends($layout)

@section('title', 'Tambah Transaksi Baru | ' . ucfirst(auth()->user()->role))
@section('page-title', 'Tambah Transaksi Baru')
@section('page-description', 'Form untuk menambahkan transaksi baru ke sistem')


@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
            --transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        /* Enhanced Select2 Customization */
        .select2-container--default .select2-selection--single {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            height: 48px;
            padding: 0.75rem 1rem;
            background: rgba(255, 255, 255, 0.9);
            transition: var(--transition);
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.8;
            padding-left: 0;
            color: var(--dark-color);
            font-weight: 500;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px;
            right: 12px;
        }

        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
            background: white;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: var(--primary-color);
            color: white;
        }

        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #f1f5f9;
            color: var(--dark-color);
        }

        .select2-dropdown {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .select2-results__option {
            padding: 12px 16px;
            border-bottom: 1px solid #f1f5f9;
            transition: var(--transition);
        }

        .select2-results__option:last-child {
            border-bottom: none;
        }

        .select2-results__option:hover {
            background-color: #f8fafc;
        }

        /* Enhanced Product Items */
        .product-item {
            border: 2px solid #f1f5f9;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            background: white;
            transition: var(--transition);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.03);
        }

        .product-item:hover {
            border-color: var(--primary-light);
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.1);
            transform: translateY(-2px);
        }

        .product-item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f8fafc;
        }

        .product-item-title {
            font-weight: 600;
            color: var(--dark-color);
            margin: 0;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .product-item-title i {
            color: var(--primary-color);
        }

        .remove-product {
            color: var(--error-color);
            background: rgba(239, 68, 68, 0.1);
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .remove-product:hover {
            color: white;
            background: var(--error-color);
            transform: scale(1.05);
        }

        .add-product-btn {
            background: var(--gradient-success);
            border: none;
            border-radius: 12px;
            padding: 0.875rem 1.75rem;
            color: white;
            font-weight: 600;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .add-product-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        }

        .add-new-product-btn {
            background: var(--gradient-warning);
            border: none;
            border-radius: 12px;
            padding: 0.875rem 1.75rem;
            color: white;
            font-weight: 600;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-left: 1rem;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }

        .add-new-product-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
        }

        .product-actions {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        /* Enhanced Form Elements */
        .form-container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .required-field::after {
            content: " *";
            color: var(--error-color);
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
        }

        .form-control,
        .form-select {
            border-radius: 12px;
            border: 2px solid #f1f5f9;
            padding: 0.875rem 1rem;
            transition: var(--transition);
            background: rgba(255, 255, 255, 0.9);
            font-size: 0.95rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
            background: white;
        }

        .form-text {
            font-size: 0.85rem;
            color: #64748b;
            margin-top: 0.5rem;
            font-weight: 500;
        }

        .invalid-feedback {
            color: var(--error-color);
            font-size: 0.85rem;
            margin-top: 0.5rem;
            font-weight: 500;
        }

        /* Enhanced Price Calculation */
        .price-calculation {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 12px;
            padding: 1.25rem;
            margin-top: 1.25rem;
            border: 2px solid #f1f5f9;
        }

        .calculation-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .calculation-row:last-child {
            border-bottom: none;
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--primary-color);
            padding-top: 1rem;
            margin-top: 0.5rem;
            border-top: 2px solid rgba(79, 70, 229, 0.1);
        }

        /* Stock Info Styles */
        .stock-info {
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-top: 0.5rem;
        }

        .stock-available {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
            border-left: 4px solid var(--success-color);
        }

        .stock-low {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning-color);
            border-left: 4px solid var(--warning-color);
        }

        .stock-out {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error-color);
            border-left: 4px solid var(--error-color);
        }

        /* Product Search Enhancement */
        .product-search-container {
            position: relative;
        }

        .product-search-icon {
            position: absolute;
            left: -5px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            z-index: 1;
        }

        .select2-selection__rendered {
            padding-left: 35px !important;
        }

        /* Section Headers */
        .section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f1f5f9;
        }

        .section-header i {
            color: var(--primary-color);
            font-size: 1.25rem;
        }

        .section-header h6 {
            margin: 0;
            color: var(--dark-color);
            font-weight: 700;
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

        /* Location Section */
        .location-section {
            background: rgba(79, 70, 229, 0.05);
            border-radius: 12px;
            padding: 1.5rem;
            margin: 1rem 0;
        }

        .location-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .location-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .location-coordinates {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        /* Photo Section */
        .photo-section {
            background: rgba(16, 185, 129, 0.05);
            border-radius: 12px;
            padding: 1.5rem;
            margin: 1rem 0;
        }

        .photo-options {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .photo-option {
            border: 2px dashed #e2e8f0;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .photo-option:hover {
            border-color: var(--primary-color);
            background: rgba(79, 70, 229, 0.05);
        }

        .photo-option i {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .photo-preview {
            margin-top: 1rem;
            text-align: center;
        }

        .photo-preview img {
            max-width: 100%;
            max-height: 300px;
            border-radius: 12px;
            border: 2px solid #e2e8f0;
        }

        .camera-container {
            position: relative;
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        #cameraPreview {
            width: 100%;
            height: 300px;
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            object-fit: cover;
        }

        .camera-controls {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 1rem;
        }

        /* Cards */
        .card {
            background: var(--card-bg);
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            margin-bottom: 1.5rem;
            backdrop-filter: blur(10px);
            overflow: hidden;
            width: 100%;
        }

        .card:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
            transform: translateY(-5px);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            padding: 1.25rem;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark-color);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-body {
            padding: 1.25rem;
        }

        /* Buttons */
        .btn {
            border-radius: 10px;
            padding: 0.7rem 1.5rem;
            font-weight: 600;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary {
            background: var(--gradient-primary);
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.4);
        }

        .btn-success {
            background: var(--gradient-success);
            border: none;
        }

        .btn-success:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.4);
        }

        .btn-warning {
            background: var(--gradient-warning);
            border: none;
            color: white;
        }

        .btn-warning:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(245, 158, 11, 0.4);
        }

        .btn-secondary {
            background: rgba(100, 116, 139, 0.1);
            color: #64748b;
            border: 1px solid rgba(100, 116, 139, 0.2);
        }

        .btn-secondary:hover {
            background: rgba(100, 116, 139, 0.2);
            color: #475569;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .btn-outline-secondary {
            background: transparent;
            color: #64748b;
            border: 1px solid rgba(100, 116, 139, 0.3);
        }

        .btn-outline-secondary:hover {
            background: rgba(100, 116, 139, 0.1);
            color: #475569;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
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

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .product-item {
            animation: slideIn 0.3s ease-out;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .content-area {
                padding: 1rem;
            }

            .form-container {
                max-width: 100%;
            }

            .photo-options {
                grid-template-columns: 1fr;
            }

            .location-coordinates {
                grid-template-columns: 1fr;
            }

            .product-actions {
                flex-direction: column;
            }

            .add-new-product-btn {
                margin-left: 0;
                margin-top: 1rem;
            }

            .product-item {
                padding: 1.25rem;
            }

            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
        }

        /* Loading States */
        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        .btn-loading {
            position: relative;
            color: transparent !important;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin-left: -10px;
            margin-top: -10px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
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

    <div class="form-container" data-aos="fade-up">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h4 mb-1"><i class="fas fa-exchange-alt me-2"></i>Tambah Transaksi Baru</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.transactions.index') }}">Transactions</a></li>
                        <li class="breadcrumb-item active">Tambah Transaksi</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('admin.transactions.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <!-- Form Card -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="fas fa-receipt me-2"></i>Form Data Transaksi</h5>
            </div>
            <div class="card-body">
                <!-- Session Messages -->
                @if (session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                    </div>
                @endif

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Terjadi Kesalahan!</h6>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.transactions.store') }}" method="POST" enctype="multipart/form-data"
                    id="transactionForm">
                    @csrf

                    <div class="row">
                        <!-- Sales Person -->
                        <div class="col-md-6 mb-4">
                            <label for="user_id" class="form-label required-field">Sales Person</label>
                            <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id"
                                required>
                                <option value="">Pilih Sales Person</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->role }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Customer -->
                        <div class="col-md-6 mb-4">
                            <label for="customer_id" class="form-label required-field">Customer</label>
                            <select class="form-select @error('customer_id') is-invalid @enderror" id="customer_id"
                                name="customer_id" required>
                                <option value="">Pilih Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                        {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }} - {{ $customer->email }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Products Section -->
                    <div class="products-section mb-4">
                        <div class="section-header">
                            <i class="fas fa-boxes"></i>
                            <h6>Produk Transaksi</h6>
                        </div>

                        <div class="product-actions mb-3">
                            <button type="button" class="add-product-btn" id="addProductBtn">
                                <i class="fas fa-plus me-1"></i> Tambah Produk Lain
                            </button>
                            <a href="{{ route('products.create') }}" class="add-new-product-btn" target="_blank">
                                <i class="fas fa-plus-circle me-1"></i> Buat Produk Baru
                            </a>
                        </div>

                        <div id="productsContainer">
                            <!-- Product items will be added here dynamically -->
                            <div class="product-item" data-index="0">
                                <div class="product-item-header">
                                    <h6 class="product-item-title">
                                        <i class="fas fa-cube"></i>
                                        <span class="product-name">Produk #1</span>
                                    </h6>
                                    <button type="button" class="remove-product" onclick="removeProduct(0)" disabled>
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required-field">Pilih Produk</label>
                                        <div class="product-search-container">
                                            <i class="fas fa-search product-search-icon"></i>
                                            <select class="form-select product-select" name="products[0][product_id]"
                                                required onchange="updateProductInfo(0)">
                                                <option value="">Cari atau pilih produk...</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                                        data-stock="{{ $product->stock_quantity }}"
                                                        data-name="{{ $product->name }}" data-sku="{{ $product->sku }}"
                                                        data-category="{{ $product->category }}">
                                                        {{ $product->name }} - Rp
                                                        {{ number_format($product->price, 0, ',', '.') }} (Stok:
                                                        {{ $product->stock_quantity }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-text product-stock-info">Pilih produk untuk melihat stok</div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label required-field">Quantity</label>
                                        <input type="number" class="form-control product-quantity"
                                            name="products[0][quantity]" value="1" min="1" required
                                            onchange="updateProductTotal(0)">
                                        <div class="form-text">Jumlah yang dibeli</div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label required-field">Harga per Unit</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" class="form-control product-price"
                                                name="products[0][price]" value="0" min="0" step="1000"
                                                required readonly>
                                        </div>
                                        <div class="form-text">Harga otomatis</div>
                                    </div>
                                </div>
                                <div class="price-calculation">
                                    <div class="calculation-row">
                                        <span>Subtotal Produk:</span>
                                        <span class="product-subtotal">Rp 0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Calculation -->
                    <div class="price-calculation mb-4">
                        <div class="calculation-row">
                            <span><strong>Total Quantity:</strong></span>
                            <span id="total-quantity">1</span>
                        </div>
                        <div class="calculation-row">
                            <span><strong>Total Harga Semua Produk:</strong></span>
                            <span id="total-price">Rp 0</span>
                        </div>
                    </div>

                    <!-- Location Section -->
                    <div class="location-section">
                        <h6 class="card-title mb-3"><i class="fas fa-map-marker-alt me-2"></i>Lokasi Transaksi</h6>

                        <div class="location-info">
                            <div class="location-icon">
                                <i class="fas fa-location-dot"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Share Location</h6>
                                <p class="mb-0 text-muted">Dapatkan koordinat lokasi saat ini secara otomatis</p>
                            </div>
                        </div>

                        <div class="location-coordinates">
                            <div>
                                <label for="latitude" class="form-label">Latitude</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('latitude') is-invalid @enderror"
                                        id="latitude" name="latitude" value="{{ old('latitude') }}"
                                        placeholder="Koordinat latitude" readonly>
                                    <button type="button" class="btn btn-primary" id="getLocationBtn">
                                        <i class="fas fa-crosshairs me-1"></i> Dapatkan
                                    </button>
                                </div>
                                @error('latitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="longitude" class="form-label">Longitude</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('longitude') is-invalid @enderror"
                                        id="longitude" name="longitude" value="{{ old('longitude') }}"
                                        placeholder="Koordinat longitude" readonly>
                                    <button type="button" class="btn btn-success" id="copyLocationBtn">
                                        <i class="fas fa-copy me-1"></i> Copy
                                    </button>
                                </div>
                                @error('longitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Pastikan Anda mengizinkan akses lokasi di browser untuk menggunakan fitur ini
                        </div>
                    </div>

                    <!-- Photo Section -->
                    <div class="photo-section">
                        <h6 class="card-title mb-3"><i class="fas fa-camera me-2"></i>Foto Transaksi</h6>

                        <div class="photo-options">
                            <div class="photo-option" id="cameraOption">
                                <i class="fas fa-camera"></i>
                                <h6>Ambil Foto Langsung</h6>
                                <p class="text-muted mb-0">Gunakan kamera perangkat</p>
                            </div>

                            <div class="photo-option" id="uploadOption">
                                <i class="fas fa-upload"></i>
                                <h6>Upload Foto</h6>
                                <p class="text-muted mb-0">Pilih dari galeri</p>
                            </div>
                        </div>

                        <!-- Camera Preview -->
                        <div class="camera-container d-none" id="cameraContainer">
                            <video id="cameraPreview" autoplay playsinline></video>
                            <div class="camera-controls">
                                <button type="button" class="btn btn-warning" id="captureBtn">
                                    <i class="fas fa-camera me-1"></i> Ambil Foto
                                </button>
                                <button type="button" class="btn btn-secondary" id="closeCameraBtn">
                                    <i class="fas fa-times me-1"></i> Tutup
                                </button>
                            </div>
                        </div>

                        <!-- Photo Preview -->
                        <div class="photo-preview" id="photoPreview">
                            <canvas id="photoCanvas" class="d-none"></canvas>
                            <img id="previewImage" src="" alt="Preview" class="d-none">
                        </div>

                        <!-- Hidden file input -->
                        <input type="file" id="photoInput" name="photo" accept="image/*" class="d-none"
                            @error('photo') is-invalid @enderror>
                        @error('photo')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <!-- Status -->
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label required-field">Status Transaksi</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status"
                                name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed
                                </option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Payment Status -->
                        <div class="col-md-6 mb-3">
                            <label for="payment_status" class="form-label required-field">Status Pembayaran</label>
                            <select class="form-select @error('payment_status') is-invalid @enderror" id="payment_status"
                                name="payment_status" required>
                                <option value="">Pilih Status Pembayaran</option>
                                <option value="pending" {{ old('payment_status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="paid" {{ old('payment_status') == 'paid' ? 'selected' : '' }}>Paid
                                </option>
                                <option value="cancelled" {{ old('payment_status') == 'cancelled' ? 'selected' : '' }}>
                                    Cancelled</option>
                            </select>
                            @error('payment_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Informasi Tambahan -->
                    <div class="alert alert-info mt-3">
                        <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Informasi Transaksi</h6>
                        <ul class="mb-0">
                            <li>Total harga akan dihitung otomatis berdasarkan quantity dan harga per unit</li>
                            <li>Pastikan stok produk mencukupi sebelum membuat transaksi</li>
                            <li>Gunakan fitur share location untuk mendapatkan koordinat lokasi yang akurat</li>
                            <li>Foto transaksi akan membantu dalam verifikasi dan dokumentasi</li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-success" id="submitBtn">
                            <i class="fas fa-save me-1"></i> Simpan Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });

        // Global variables
        let stream = null;
        let photoData = null;
        let productCount = 1;

        // Enhanced Select2 initialization with better search
        function initializeSelect2(selectElement) {
            $(selectElement).select2({
                placeholder: "Ketik untuk mencari produk...",
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return "Produk tidak ditemukan. <a href='{{ route('products.create') }}' target='_blank' class='btn btn-sm btn-warning mt-2'><i class='fas fa-plus me-1'></i>Tambah Produk Baru</a>";
                    },
                    searching: function() {
                        return "Mencari produk...";
                    },
                    inputTooShort: function(args) {
                        return "Ketik minimal " + args.minimum + " karakter";
                    }
                },
                escapeMarkup: function(markup) {
                    return markup;
                },
                templateResult: formatProductResult,
                templateSelection: formatProductSelection,
                minimumInputLength: 1
            });
        }

        // Format product results in dropdown
        function formatProductResult(product) {
            if (!product.id) {
                return product.text;
            }

            if (product.element && product.element.dataset) {
                const stock = parseInt(product.element.dataset.stock);
                let stockBadge = '';

                if (stock === 0) {
                    stockBadge = '<span class="badge bg-danger ms-2">Habis</span>';
                } else if (stock <= 10) {
                    stockBadge = '<span class="badge bg-warning ms-2">Rendah</span>';
                } else {
                    stockBadge = '<span class="badge bg-success ms-2">Tersedia</span>';
                }

                const $result = $(
                    `<div class="product-result d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fw-semibold">${product.element.dataset.name}</div>
                            <div class="text-muted small">
                                <div>SKU: ${product.element.dataset.sku}</div>
                                <div>Kategori: ${product.element.dataset.category}</div>
                                <div>Harga: Rp ${parseInt(product.element.dataset.price).toLocaleString('id-ID')}</div>
                            </div>
                        </div>
                        <div class="text-end">
                            ${stockBadge}
                            <div class="small text-muted mt-1">Stok: ${stock}</div>
                        </div>
                    </div>`
                );
                return $result;
            }

            return product.text;
        }

        // Format selected product
        function formatProductSelection(product) {
            if (!product.id) {
                return product.text;
            }

            if (product.element && product.element.dataset) {
                return $(
                    `<span class="selected-product">
                        <strong>${product.element.dataset.name}</strong>
                        <small class="text-muted"> - Rp ${parseInt(product.element.dataset.price).toLocaleString('id-ID')}</small>
                    </span>`
                );
            }

            return product.text;
        }

        // Initialize all select2 elements
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize first product select
            initializeSelect2('.product-select');

            // Update totals on page load
            updateTotals();

            // Initialize first product info if there's a selected value
            const firstSelect = document.querySelector('[data-index="0"] .product-select');
            if (firstSelect.value) {
                updateProductInfo(0);
            }
        });

        // Add new product with enhanced animation
        document.getElementById('addProductBtn').addEventListener('click', function() {
            const container = document.getElementById('productsContainer');
            const index = productCount;

            const productHtml = `
                <div class="product-item" data-index="${index}">
                    <div class="product-item-header">
                        <h6 class="product-item-title">
                            <i class="fas fa-cube"></i>
                            <span class="product-name">Produk #${index + 1}</span>
                        </h6>
                        <button type="button" class="remove-product" onclick="removeProduct(${index})">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">Pilih Produk</label>
                            <div class="product-search-container">
                                <i class="fas fa-search product-search-icon"></i>
                                <select class="form-select product-select" name="products[${index}][product_id]" required onchange="updateProductInfo(${index})">
                                    <option value=""> Cari atau pilih produk...</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" 
                                            data-price="{{ $product->price }}"
                                            data-stock="{{ $product->stock_quantity }}"
                                            data-name="{{ $product->name }}"
                                            data-sku="{{ $product->sku }}"
                                            data-category="{{ $product->category }}">
                                            {{ $product->name }} - Rp {{ number_format($product->price, 0, ',', '.') }} (Stok: {{ $product->stock_quantity }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-text product-stock-info">Pilih produk untuk melihat stok</div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label required-field">Quantity</label>
                            <input type="number" class="form-control product-quantity" name="products[${index}][quantity]" value="1" min="1" required onchange="updateProductTotal(${index})">
                            <div class="form-text">Jumlah yang dibeli</div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label required-field">Harga per Unit</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control product-price" name="products[${index}][price]" value="0" min="0" step="1000" required readonly>
                            </div>
                            <div class="form-text">Harga otomatis</div>
                        </div>
                    </div>
                    <div class="price-calculation">
                        <div class="calculation-row">
                            <span>Subtotal Produk:</span>
                            <span class="product-subtotal">Rp 0</span>
                        </div>
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', productHtml);

            // Initialize Select2 for the new product select
            initializeSelect2(container.querySelector(`[data-index="${index}"] .product-select`));

            productCount++;

            // Update remove buttons state
            updateRemoveButtons();

            // Scroll to the new product
            const newProduct = container.lastElementChild;
            newProduct.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest'
            });

            showToast('Produk baru berhasil ditambahkan', 'success');
        });

        // Remove product with confirmation
        function removeProduct(index) {
            const productItem = document.querySelector(`[data-index="${index}"]`);
            if (productItem) {
                if (document.querySelectorAll('.product-item').length === 1) {
                    showToast('Minimal harus ada satu produk dalam transaksi', 'warning');
                    return;
                }

                if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
                    productItem.style.transform = 'scale(0.8)';
                    productItem.style.opacity = '0';

                    setTimeout(() => {
                        productItem.remove();
                        updateTotals();
                        updateRemoveButtons();
                        reindexProducts();
                        showToast('Produk berhasil dihapus', 'success');
                    }, 300);
                }
            }
        }

        // Reindex products after removal
        function reindexProducts() {
            const productItems = document.querySelectorAll('.product-item');
            productItems.forEach((item, index) => {
                item.setAttribute('data-index', index);
                const title = item.querySelector('.product-item-title .product-name');
                title.textContent = `Produk #${index + 1}`;

                // Update input names
                const select = item.querySelector('.product-select');
                const quantity = item.querySelector('.product-quantity');
                const price = item.querySelector('.product-price');

                select.name = `products[${index}][product_id]`;
                quantity.name = `products[${index}][quantity]`;
                price.name = `products[${index}][price]`;

                // Update event listeners
                select.onchange = () => updateProductInfo(index);
                quantity.onchange = () => updateProductTotal(index);
            });
            productCount = productItems.length;
        }

        // Update remove buttons state
        function updateRemoveButtons() {
            const productItems = document.querySelectorAll('.product-item');
            const removeButtons = document.querySelectorAll('.remove-product');

            removeButtons.forEach(button => {
                button.disabled = productItems.length === 1;
            });
        }

        // Enhanced product info update with stock status
        function updateProductInfo(index) {
            const productItem = document.querySelector(`[data-index="${index}"]`);
            const select = productItem.querySelector('.product-select');
            const selectedOption = select.options[select.selectedIndex];
            const priceInput = productItem.querySelector('.product-price');
            const stockInfo = productItem.querySelector('.product-stock-info');
            const quantityInput = productItem.querySelector('.product-quantity');
            const productName = productItem.querySelector('.product-name');

            if (selectedOption && selectedOption.value) {
                const price = selectedOption.getAttribute('data-price');
                const stock = parseInt(selectedOption.getAttribute('data-stock'));
                const name = selectedOption.getAttribute('data-name');

                // Update price
                priceInput.value = price;

                // Update stock info with status
                let stockClass = 'stock-available';
                let stockMessage = `Stok tersedia: ${stock}`;
                let icon = 'fa-check';

                if (stock === 0) {
                    stockClass = 'stock-out';
                    stockMessage = 'Stok habis!';
                    icon = 'fa-times';
                } else if (stock <= 10) {
                    stockClass = 'stock-low';
                    stockMessage = `Stok rendah: ${stock}`;
                    icon = 'fa-exclamation-triangle';
                }

                stockInfo.innerHTML = `<div class="stock-info ${stockClass}">
                    <i class="fas ${icon} me-2"></i>${stockMessage}
                </div>`;

                // Update max quantity
                quantityInput.setAttribute('max', stock);

                // Update product title
                productName.textContent = name;

                // Check if current quantity exceeds stock
                const currentQuantity = parseInt(quantityInput.value);
                if (currentQuantity > stock) {
                    quantityInput.value = stock;
                    showToast('Quantity disesuaikan dengan stok tersedia', 'warning');
                }

                // Update product total
                updateProductTotal(index);
            } else {
                priceInput.value = 0;
                stockInfo.innerHTML = '<div class="form-text">Pilih produk untuk melihat stok</div>';
                quantityInput.removeAttribute('max');
                productName.textContent = `Produk #${parseInt(index) + 1}`;
                updateProductTotal(index);
            }
        }

        // Update product total
        function updateProductTotal(index) {
            const productItem = document.querySelector(`[data-index="${index}"]`);
            const quantityInput = productItem.querySelector('.product-quantity');
            const priceInput = productItem.querySelector('.product-price');
            const subtotalElement = productItem.querySelector('.product-subtotal');

            const quantity = parseInt(quantityInput.value) || 0;
            const price = parseInt(priceInput.value) || 0;
            const subtotal = quantity * price;

            subtotalElement.textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
            subtotalElement.style.fontWeight = '600';
            subtotalElement.style.color = 'var(--primary-color)';

            updateTotals();
        }

        // Update totals
        function updateTotals() {
            let totalQuantity = 0;
            let totalPrice = 0;

            document.querySelectorAll('.product-item').forEach(item => {
                const quantityInput = item.querySelector('.product-quantity');
                const priceInput = item.querySelector('.product-price');

                const quantity = parseInt(quantityInput.value) || 0;
                const price = parseInt(priceInput.value) || 0;

                totalQuantity += quantity;
                totalPrice += quantity * price;
            });

            document.getElementById('total-quantity').textContent = totalQuantity;
            document.getElementById('total-price').textContent = `Rp ${totalPrice.toLocaleString('id-ID')}`;
        }

        // Toast notification
        function showToast(message, type = 'info') {
            // Remove existing toasts
            const existingToasts = document.querySelectorAll('.custom-toast');
            existingToasts.forEach(toast => toast.remove());

            const toast = document.createElement('div');
            toast.className = `custom-toast alert alert-${type} alert-dismissible fade show`;
            toast.innerHTML = `
                <i class="fas ${type === 'success' ? 'fa-check' : type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info'}-circle me-2"></i>
                ${message}
                <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
            `;

            // Toast styles
            Object.assign(toast.style, {
                position: 'fixed',
                top: '20px',
                right: '20px',
                zIndex: '9999',
                minWidth: '300px',
                borderRadius: '10px',
                boxShadow: '0 5px 15px rgba(0,0,0,0.1)',
                border: 'none'
            });

            document.body.appendChild(toast);

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (toast.parentElement) {
                    toast.remove();
                }
            }, 5000);
        }

        // Enhanced form validation
        document.getElementById('transactionForm').addEventListener('submit', function(e) {
            let hasErrors = false;
            const productItems = document.querySelectorAll('.product-item');
            const submitBtn = document.getElementById('submitBtn');

            // Check if at least one product is selected
            if (productItems.length === 0) {
                e.preventDefault();
                showToast('Minimal harus ada satu produk dalam transaksi', 'warning');
                hasErrors = true;
                return;
            }

            // Validate each product
            productItems.forEach((item, index) => {
                const select = item.querySelector('.product-select');
                const quantityInput = item.querySelector('.product-quantity');
                const priceInput = item.querySelector('.product-price');
                const maxQuantity = parseInt(quantityInput.getAttribute('max'));
                const quantity = parseInt(quantityInput.value);
                const price = parseFloat(priceInput.value);

                if (!select.value) {
                    e.preventDefault();
                    showToast(`Silakan pilih produk untuk Produk #${index + 1}`, 'warning');
                    select.focus();
                    hasErrors = true;
                    return;
                }

                if (!quantity || quantity < 1) {
                    e.preventDefault();
                    showToast(`Quantity tidak valid untuk Produk #${index + 1}`, 'warning');
                    quantityInput.focus();
                    hasErrors = true;
                    return;
                }

                if (maxQuantity && quantity > maxQuantity) {
                    e.preventDefault();
                    const productName = select.options[select.selectedIndex].dataset.name;
                    showToast(`Quantity melebihi stok untuk ${productName}. Stok tersedia: ${maxQuantity}`,
                        'warning');
                    quantityInput.focus();
                    hasErrors = true;
                    return;
                }

                if (!price || price <= 0) {
                    e.preventDefault();
                    showToast(`Harga tidak valid untuk Produk #${index + 1}`, 'warning');
                    hasErrors = true;
                    return;
                }
            });

            if (!hasErrors) {
                // Show loading state
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                submitBtn.disabled = true;

                // Add loading class to form
                this.classList.add('loading');

                // Show saving toast
                showToast('Menyimpan transaksi...', 'info');
            }
        });

        // Location functionality
        const getLocationBtn = document.getElementById('getLocationBtn');
        const copyLocationBtn = document.getElementById('copyLocationBtn');
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');

        getLocationBtn.addEventListener('click', function() {
            if (navigator.geolocation) {
                getLocationBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Mendapatkan...';
                getLocationBtn.disabled = true;

                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;

                        latitudeInput.value = lat.toFixed(6);
                        longitudeInput.value = lng.toFixed(6);

                        getLocationBtn.innerHTML = '<i class="fas fa-check me-1"></i> Berhasil';
                        getLocationBtn.classList.remove('btn-primary');
                        getLocationBtn.classList.add('btn-success');

                        showToast('Lokasi berhasil didapatkan', 'success');

                        setTimeout(() => {
                            getLocationBtn.innerHTML =
                            '<i class="fas fa-crosshairs me-1"></i> Dapatkan';
                            getLocationBtn.classList.remove('btn-success');
                            getLocationBtn.classList.add('btn-primary');
                            getLocationBtn.disabled = false;
                        }, 2000);
                    },
                    function(error) {
                        let errorMessage = 'Gagal mendapatkan lokasi: ';
                        switch (error.code) {
                            case error.PERMISSION_DENIED:
                                errorMessage += 'Akses lokasi ditolak';
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMessage += 'Informasi lokasi tidak tersedia';
                                break;
                            case error.TIMEOUT:
                                errorMessage += 'Permintaan lokasi timeout';
                                break;
                            default:
                                errorMessage += 'Error tidak diketahui';
                        }

                        showToast(errorMessage, 'error');
                        getLocationBtn.innerHTML = '<i class="fas fa-crosshairs me-1"></i> Dapatkan';
                        getLocationBtn.disabled = false;
                    }, {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            } else {
                showToast('Browser tidak mendukung geolocation', 'error');
            }
        });

        copyLocationBtn.addEventListener('click', function() {
            if (latitudeInput.value && longitudeInput.value) {
                const locationText = `${latitudeInput.value}, ${longitudeInput.value}`;
                navigator.clipboard.writeText(locationText).then(function() {
                    const originalText = copyLocationBtn.innerHTML;
                    copyLocationBtn.innerHTML = '<i class="fas fa-check me-1"></i> Tersalin';
                    copyLocationBtn.classList.remove('btn-success');
                    copyLocationBtn.classList.add('btn-primary');

                    showToast('Koordinat berhasil disalin', 'success');

                    setTimeout(() => {
                        copyLocationBtn.innerHTML = originalText;
                        copyLocationBtn.classList.remove('btn-primary');
                        copyLocationBtn.classList.add('btn-success');
                    }, 2000);
                }).catch(function() {
                    showToast('Gagal menyalin koordinat', 'error');
                });
            } else {
                showToast('Tidak ada lokasi untuk disalin', 'warning');
            }
        });

        // Photo functionality - Simplified like before
        const cameraOption = document.getElementById('cameraOption');
        const uploadOption = document.getElementById('uploadOption');
        const cameraContainer = document.getElementById('cameraContainer');
        const cameraPreview = document.getElementById('cameraPreview');
        const captureBtn = document.getElementById('captureBtn');
        const closeCameraBtn = document.getElementById('closeCameraBtn');
        const photoInput = document.getElementById('photoInput');
        const photoCanvas = document.getElementById('photoCanvas');
        const previewImage = document.getElementById('previewImage');

        cameraOption.addEventListener('click', function() {
            startCamera();
        });

        uploadOption.addEventListener('click', function() {
            photoInput.click();
        });

        photoInput.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const file = e.target.files[0];
                const reader = new FileReader();

                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.classList.remove('d-none');
                    photoData = e.target.result;
                }

                reader.readAsDataURL(file);
            }
        });

        async function startCamera() {
            try {
                stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'environment',
                        width: {
                            ideal: 1280
                        },
                        height: {
                            ideal: 720
                        }
                    }
                });

                cameraPreview.srcObject = stream;
                cameraContainer.classList.remove('d-none');
                cameraOption.classList.add('d-none');
                uploadOption.classList.add('d-none');

            } catch (error) {
                console.error('Error accessing camera:', error);
                alert('Tidak dapat mengakses kamera. Pastikan Anda memberikan izin akses kamera.');
            }
        }

        function stopCamera() {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
            }
            cameraContainer.classList.add('d-none');
            cameraOption.classList.remove('d-none');
            uploadOption.classList.remove('d-none');
        }

        captureBtn.addEventListener('click', function() {
            const context = photoCanvas.getContext('2d');
            photoCanvas.width = cameraPreview.videoWidth;
            photoCanvas.height = cameraPreview.videoHeight;
            context.drawImage(cameraPreview, 0, 0, photoCanvas.width, photoCanvas.height);

            photoData = photoCanvas.toDataURL('image/jpeg');
            previewImage.src = photoData;
            previewImage.classList.remove('d-none');

            // Convert data URL to blob and create file
            fetch(photoData)
                .then(res => res.blob())
                .then(blob => {
                    const file = new File([blob], 'transaction_photo.jpg', {
                        type: 'image/jpeg'
                    });
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    photoInput.files = dataTransfer.files;
                });

            stopCamera();
        });

        closeCameraBtn.addEventListener('click', stopCamera);

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert:not(.custom-toast)');
            alerts.forEach(function(alert) {
                const fade = new bootstrap.Alert(alert);
                fade.close();
            });
        }, 5000);

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl + Enter to submit form
            if (e.ctrlKey && e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('transactionForm').dispatchEvent(new Event('submit'));
            }

            // Escape to close camera
            if (e.key === 'Escape' && !cameraContainer.classList.contains('d-none')) {
                stopCamera();
            }
        });

        // Reset form when leaving page
        window.addEventListener('beforeunload', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            if (submitBtn.disabled) {
                // Form is in loading state, don't show confirmation
                return;
            }

            const form = document.getElementById('transactionForm');
            const formData = new FormData(form);
            let hasData = false;

            for (let [key, value] of formData.entries()) {
                if (value && key !== '_token') {
                    hasData = true;
                    break;
                }
            }

            if (hasData) {
                e.preventDefault();
                e.returnValue = 'Anda memiliki data yang belum disimpan. Yakin ingin meninggalkan halaman?';
            }
        });
    </script>
@endpush
