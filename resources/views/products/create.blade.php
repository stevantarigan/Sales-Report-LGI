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

@section('title', 'Add New Product | ' . ucfirst($role))
@section('page-title', 'Add New Product')
@section('page-description', 'Create a new product to the inventory')



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
                --gradient-success: linear-gradient(135deg, #10b981 0%, #059669 100%);
                --gradient-warning: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
                --gradient-danger: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
                --gradient-info: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
                --transition: all 0.3s ease;
                --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                --card-shadow-hover: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }

            .main-container {
                background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
                min-height: calc(100vh - 56px);
                padding: 2rem 0;
            }

            .form-card {
                background: white;
                border-radius: 20px;
                box-shadow: var(--card-shadow);
                border: none;
                overflow: hidden;
                margin-bottom: 2rem;
                transition: var(--transition);
            }

            .form-card:hover {
                box-shadow: var(--card-shadow-hover);
                transform: translateY(-2px);
            }

            .card-header-custom {
                background: var(--gradient-primary);
                color: white;
                padding: 1.5rem 2rem;
                border-bottom: none;
                position: relative;
            }

            .card-header-custom::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                height: 3px;
                background: rgba(255, 255, 255, 0.3);
            }

            .card-header-custom .card-title {
                margin: 0;
                font-weight: 700;
                font-size: 1.4rem;
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }

            .card-header-custom .card-title i {
                font-size: 1.2rem;
            }

            .section-card {
                background: white;
                border-radius: 16px;
                border: none;
                box-shadow: var(--card-shadow);
                margin-bottom: 1.5rem;
                overflow: hidden;
                transition: var(--transition);
            }

            .section-card:hover {
                box-shadow: var(--card-shadow-hover);
            }

            .section-header {
                background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
                padding: 1.25rem 1.5rem;
                border-bottom: 2px solid #e2e8f0;
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }

            .section-header i {
                color: var(--primary-color);
                font-size: 1.1rem;
            }

            .section-title {
                font-weight: 600;
                color: var(--dark-color);
                margin: 0;
                font-size: 1.1rem;
            }

            .card-body-custom {
                padding: 1.5rem;
            }

            .form-group {
                margin-bottom: 1.5rem;
            }

            .form-label {
                font-weight: 600;
                color: var(--dark-color);
                margin-bottom: 0.5rem;
                font-size: 0.9rem;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .form-label i {
                color: var(--primary-color);
                font-size: 0.8rem;
            }

            .form-control,
            .form-select,
            .custom-file-input {
                border: 2px solid #e2e8f0;
                border-radius: 12px;
                padding: 0.75rem 1rem;
                font-size: 0.9rem;
                transition: var(--transition);
                background: white;
            }

            .form-control:focus,
            .form-select:focus,
            .custom-file-input:focus {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
                transform: translateY(-1px);
            }

            .input-group-text {
                background: var(--gradient-primary);
                color: white;
                border: 2px solid var(--primary-color);
                border-right: none;
                font-weight: 600;
            }

            .input-group .form-control {
                border-left: none;
            }

            .form-text {
                font-size: 0.8rem;
                color: #64748b;
                margin-top: 0.5rem;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .form-text i {
                color: var(--info-color);
            }

            /* Image Upload Styles */
            .image-upload-container {
                text-align: center;
                padding: 1.5rem;
            }

            .image-preview-wrapper {
                position: relative;
                display: inline-block;
                margin-bottom: 1rem;
            }

            .image-preview {
                width: 200px;
                height: 200px;
                border-radius: 16px;
                border: 3px dashed #e2e8f0;
                object-fit: cover;
                transition: var(--transition);
            }

            .image-preview:hover {
                border-color: var(--primary-color);
                transform: scale(1.02);
            }

            .upload-placeholder {
                width: 200px;
                height: 200px;
                border: 3px dashed #e2e8f0;
                border-radius: 16px;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                color: #64748b;
                transition: var(--transition);
                cursor: pointer;
            }

            .upload-placeholder:hover {
                border-color: var(--primary-color);
                color: var(--primary-color);
                background: #f8fafc;
            }

            .upload-placeholder i {
                font-size: 3rem;
                margin-bottom: 1rem;
            }

            .custom-file {
                position: relative;
            }

            .custom-file-input {
                position: absolute;
                opacity: 0;
                width: 100%;
                height: 100%;
                cursor: pointer;
            }

            /* Specification Styles */
            .specifications-container {
                margin-top: 1rem;
            }

            .specification-row {
                display: flex;
                gap: 1rem;
                align-items: center;
                margin-bottom: 1rem;
                padding: 1rem;
                background: #f8fafc;
                border-radius: 12px;
                border: 1px solid #e2e8f0;
                transition: var(--transition);
            }

            .specification-row:hover {
                border-color: var(--primary-color);
                background: white;
            }

            .spec-input {
                flex: 1;
            }

            .remove-specification {
                background: var(--gradient-danger);
                color: white;
                border: none;
                border-radius: 8px;
                width: 40px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: var(--transition);
                cursor: pointer;
            }

            .remove-specification:hover:not(:disabled) {
                transform: scale(1.1);
                box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
            }

            .remove-specification:disabled {
                background: #94a3b8;
                cursor: not-allowed;
                opacity: 0.5;
            }

            .add-specification-btn {
                background: var(--gradient-success);
                color: white;
                border: none;
                border-radius: 12px;
                padding: 0.75rem 1.5rem;
                font-weight: 600;
                display: flex;
                align-items: center;
                gap: 0.5rem;
                transition: var(--transition);
                cursor: pointer;
            }

            .add-specification-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
            }

            /* Switch Styles */
            .custom-switch {
                padding-left: 3rem;
            }

            .custom-control-label {
                font-weight: 500;
                color: var(--dark-color);
            }

            .custom-control-label::before {
                border: 2px solid #cbd5e1;
                background: #f1f5f9;
            }

            .custom-control-input:checked~.custom-control-label::before {
                border-color: var(--primary-color);
                background: var(--primary-color);
            }

            /* Button Styles */
            .btn {
                padding: 0.9rem 1.8rem;
                border-radius: 12px;
                font-weight: 600;
                transition: var(--transition);
                border: none;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.75rem;
                font-size: 0.95rem;
            }

            .btn-primary {
                background: var(--gradient-primary);
                color: white;
                box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
            }

            .btn-primary:hover {
                transform: translateY(-3px);
                box-shadow: 0 8px 25px rgba(79, 70, 229, 0.4);
            }

            .btn-secondary {
                background: rgba(100, 116, 139, 0.1);
                color: #64748b;
                border: 1px solid rgba(100, 116, 139, 0.2);
            }

            .btn-secondary:hover {
                background: rgba(100, 116, 139, 0.2);
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            }

            .action-buttons {
                display: flex;
                gap: 1rem;
                margin-top: 2rem;
            }

            /* Back Button */
            .back-btn {
                background: white;
                color: var(--primary-color);
                border: 2px solid var(--primary-color);
                border-radius: 12px;
                padding: 0.75rem 1.5rem;
                font-weight: 600;
                text-decoration: none;
                display: flex;
                align-items: center;
                gap: 0.5rem;
                transition: var(--transition);
            }

            .back-btn:hover {
                background: var(--primary-color);
                color: white;
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
            }

            /* Profit Margin Indicator */
            .profit-margin {
                background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
                border: 1px solid #bae6fd;
                border-radius: 12px;
                padding: 1rem;
                margin-top: 1rem;
                text-align: center;
            }

            .margin-value {
                font-size: 1.5rem;
                font-weight: 700;
                color: var(--success-color);
            }

            .margin-label {
                font-size: 0.8rem;
                color: #64748b;
                margin-top: 0.25rem;
            }

            /* Error Message */
            .error-message {
                color: var(--error-color);
                font-size: 0.8rem;
                margin-top: 0.25rem;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .error-message::before {
                content: "⚠";
                font-size: 0.7rem;
            }

            /* Animation */
            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .form-card {
                animation: fadeIn 0.6s ease-out;
            }

            /* ============================ */
            /* MOBILE OPTIMIZATION STYLES */
            /* ============================ */

            @media (max-width: 768px) {
                .main-container {
                    padding: 1rem 0;
                    background: #f8fafc;
                }

                .form-card {
                    border-radius: 16px;
                    margin-bottom: 1rem;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                }

                .form-card:hover {
                    transform: none;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                }

                .card-header-custom {
                    padding: 1.25rem 1.5rem;
                }

                .card-header-custom .card-title {
                    font-size: 1.2rem;
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 0.5rem;
                }

                .card-body-custom {
                    padding: 1.25rem;
                }

                .section-card {
                    margin-bottom: 1rem;
                    border-radius: 12px;
                }

                .section-card:hover {
                    box-shadow: var(--card-shadow);
                }

                .section-header {
                    padding: 1rem 1.25rem;
                }

                .section-title {
                    font-size: 1rem;
                }

                /* Form Elements Mobile */
                .form-group {
                    margin-bottom: 1.25rem;
                }

                .form-label {
                    font-size: 0.85rem;
                }

                .form-control,
                .form-select {
                    padding: 0.75rem;
                    font-size: 16px;
                    /* Prevent zoom on iOS */
                    border-radius: 10px;
                }

                .input-group-text {
                    padding: 0.75rem;
                    font-size: 0.9rem;
                }

                /* Layout Mobile */
                .row {
                    margin-left: -0.5rem;
                    margin-right: -0.5rem;
                }

                .col-md-6,
                .col-md-12 {
                    padding-left: 0.5rem;
                    padding-right: 0.5rem;
                }

                /* Specifications Mobile */
                .specification-row {
                    flex-direction: column;
                    gap: 0.75rem;
                    padding: 0.75rem;
                }

                .spec-input {
                    width: 100%;
                }

                .remove-specification {
                    width: 100%;
                    height: 44px;
                    margin-top: 0.5rem;
                }

                .add-specification-btn {
                    width: 100%;
                    justify-content: center;
                    padding: 1rem;
                }

                /* Action Buttons Mobile */
                .action-buttons {
                    flex-direction: column;
                    gap: 0.75rem;
                    margin-top: 1.5rem;
                }

                .btn {
                    width: 100%;
                    padding: 1rem 1.5rem;
                    font-size: 1rem;
                    min-height: 54px;
                }

                /* Back Button Mobile */
                .back-btn {
                    width: 100%;
                    justify-content: center;
                    padding: 1rem;
                    margin-top: 1rem;
                }

                /* Image Upload Mobile */
                .image-upload-container {
                    padding: 1rem;
                }

                .image-preview,
                .upload-placeholder {
                    width: 150px;
                    height: 150px;
                }

                .upload-placeholder i {
                    font-size: 2rem;
                }

                .form-text {
                    font-size: 0.75rem;
                }

                /* Profit Margin Mobile */
                .profit-margin {
                    padding: 0.75rem;
                    margin-top: 0.75rem;
                }

                .margin-value {
                    font-size: 1.25rem;
                }

                /* Header Layout Mobile */
                .card-header-custom .d-flex {
                    flex-direction: column;
                    gap: 1rem;
                    align-items: flex-start !important;
                }
            }

            @media (max-width: 576px) {
                .main-container {
                    padding: 0.5rem 0;
                }

                .form-card {
                    border-radius: 12px;
                    margin: 0.5rem;
                }

                .card-header-custom {
                    padding: 1rem 1.25rem;
                }

                .card-body-custom {
                    padding: 1rem;
                }

                .section-header {
                    padding: 0.75rem 1rem;
                }

                .form-control,
                .form-select {
                    padding: 0.65rem 0.85rem;
                }

                .image-preview,
                .upload-placeholder {
                    width: 120px;
                    height: 120px;
                }

                .upload-placeholder i {
                    font-size: 1.5rem;
                }

                .upload-placeholder span {
                    font-size: 0.8rem;
                    text-align: center;
                }

                .btn {
                    padding: 0.85rem 1.25rem;
                    min-height: 50px;
                }
            }

            @media (max-width: 400px) {
                .card-header-custom .card-title {
                    font-size: 1.1rem;
                }

                .section-title {
                    font-size: 0.9rem;
                }

                .form-label {
                    font-size: 0.8rem;
                }

                .image-preview,
                .upload-placeholder {
                    width: 100px;
                    height: 100px;
                }
            }

            /* Touch-friendly improvements */
            @media (max-width: 768px) {

                .btn,
                .back-btn,
                .add-specification-btn,
                .remove-specification,
                .upload-placeholder {
                    min-height: 44px;
                    display: flex;
                    align-items: center;
                    cursor: pointer;
                }

                .form-control:focus,
                .form-select:focus {
                    transform: none;
                }

                /* Prevent horizontal scroll */
                body {
                    overflow-x: hidden;
                }

                .container-fluid {
                    padding-left: 0.5rem;
                    padding-right: 0.5rem;
                }
            }
            /* Fix for iOS form elements */
            @media (max-width: 768px) {

                input,
                select,
                textarea {
                    font-size: 16px !important;
                    /* Prevent zoom on focus */
                }

                .form-control:focus {
                    border-width: 2px;
                }
            }
        </style>
    @endpush

    @section('content')
        <div class="main-container">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12 col-xl-10">
                        <div class="form-card">
                            <div class="card-header-custom">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="card-title">
                                        <i class="fas fa-plus-circle"></i>
                                        Add New Product
                                    </h3>
                                    <a href="{{ route('products.index') }}" class="back-btn">
                                        <i class="fas fa-arrow-left"></i>
                                        Back to Products
                                    </a>
                                </div>
                            </div>

                            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body-custom">
                                    <div class="row">
                                        <!-- Left Column - Main Form -->
                                        <div class="col-lg-8">
                                            <!-- Basic Information -->
                                            <div class="section-card">
                                                <div class="section-header">
                                                    <i class="fas fa-info-circle"></i>
                                                    <h4 class="section-title">Basic Information</h4>
                                                </div>
                                                <div class="card-body-custom">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="name" class="form-label">
                                                                    <i class="fas fa-tag"></i>
                                                                    Product Name *
                                                                </label>
                                                                <input type="text"
                                                                    class="form-control @error('name') is-invalid @enderror"
                                                                    id="name" name="name" value="{{ old('name') }}"
                                                                    placeholder="Enter product name" required>
                                                                @error('name')
                                                                    <div class="error-message">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="sku" class="form-label">
                                                                    <i class="fas fa-barcode"></i>
                                                                    SKU Code
                                                                </label>
                                                                <input type="text"
                                                                    class="form-control @error('sku') is-invalid @enderror"
                                                                    id="sku" name="sku" value="{{ old('sku') }}"
                                                                    placeholder="Auto-generate if empty">
                                                                @error('sku')
                                                                    <div class="error-message">{{ $message }}</div>
                                                                @enderror
                                                                <small class="form-text">
                                                                    <i class="fas fa-info-circle"></i>
                                                                    SKU will be auto-generated if left empty
                                                                </small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="category" class="form-label">
                                                                    <i class="fas fa-folder"></i>
                                                                    Category *
                                                                </label>
                                                                <input type="text"
                                                                    class="form-control @error('category') is-invalid @enderror"
                                                                    id="category" name="category" value="{{ old('category') }}"
                                                                    placeholder="e.g., Electronics, Fashion" required>
                                                                @error('category')
                                                                    <div class="error-message">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="description" class="form-label">
                                                            <i class="fas fa-align-left"></i>
                                                            Product Description
                                                        </label>
                                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                                            rows="4" placeholder="Describe the product features and benefits...">{{ old('description') }}</textarea>
                                                        @error('description')
                                                            <div class="error-message">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="brand" class="form-label">
                                                                    <i class="fas fa-copyright"></i>
                                                                    Brand
                                                                </label>
                                                                <input type="text"
                                                                    class="form-control @error('brand') is-invalid @enderror"
                                                                    id="brand" name="brand" value="{{ old('brand') }}"
                                                                    placeholder="Product brand">
                                                                @error('brand')
                                                                    <div class="error-message">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="supplier" class="form-label">
                                                                    <i class="fas fa-truck"></i>
                                                                    Supplier
                                                                </label>
                                                                <input type="text"
                                                                    class="form-control @error('supplier') is-invalid @enderror"
                                                                    id="supplier" name="supplier"
                                                                    value="{{ old('supplier') }}"
                                                                    placeholder="Product supplier">
                                                                @error('supplier')
                                                                    <div class="error-message">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Pricing Information -->
                                            <div class="section-card">
                                                <div class="section-header">
                                                    <i class="fas fa-money-bill-wave"></i>
                                                    <h4 class="section-title">Pricing Information</h4>
                                                </div>
                                                <div class="card-body-custom">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="price" class="form-label">
                                                                    <i class="fas fa-tag"></i>
                                                                    Selling Price *
                                                                </label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Rp</span>
                                                                    </div>
                                                                    <input type="number" step="0.01"
                                                                        class="form-control @error('price') is-invalid @enderror"
                                                                        id="price" name="price"
                                                                        value="{{ old('price') }}" placeholder="0.00"
                                                                        required min="0">
                                                                </div>
                                                                @error('price')
                                                                    <div class="error-message">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="cost_price" class="form-label">
                                                                    <i class="fas fa-receipt"></i>
                                                                    Cost Price
                                                                </label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Rp</span>
                                                                    </div>
                                                                    <input type="number" step="0.01"
                                                                        class="form-control @error('cost_price') is-invalid @enderror"
                                                                        id="cost_price" name="cost_price"
                                                                        value="{{ old('cost_price') }}" placeholder="0.00"
                                                                        min="0">
                                                                </div>
                                                                @error('cost_price')
                                                                    <div class="error-message">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Profit Margin Display -->
                                                    <div class="profit-margin" id="profitMargin" style="display: none;">
                                                        <div class="margin-value" id="marginValue">0%</div>
                                                        <div class="margin-label">Profit Margin</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Stock Information -->
                                            <div class="section-card">
                                                <div class="section-header">
                                                    <i class="fas fa-boxes"></i>
                                                    <h4 class="section-title">Stock Information</h4>
                                                </div>
                                                <div class="card-body-custom">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="stock_quantity" class="form-label">
                                                                    <i class="fas fa-layer-group"></i>
                                                                    Stock Quantity *
                                                                </label>
                                                                <input type="number"
                                                                    class="form-control @error('stock_quantity') is-invalid @enderror"
                                                                    id="stock_quantity" name="stock_quantity"
                                                                    value="{{ old('stock_quantity', 0) }}" required
                                                                    min="0">
                                                                @error('stock_quantity')
                                                                    <div class="error-message">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="min_stock" class="form-label">
                                                                    <i class="fas fa-exclamation-triangle"></i>
                                                                    Minimum Stock *
                                                                </label>
                                                                <input type="number"
                                                                    class="form-control @error('min_stock') is-invalid @enderror"
                                                                    id="min_stock" name="min_stock"
                                                                    value="{{ old('min_stock', 5) }}" required
                                                                    min="0">
                                                                @error('min_stock')
                                                                    <div class="error-message">{{ $message }}</div>
                                                                @enderror
                                                                <small class="form-text">
                                                                    <i class="fas fa-bell"></i>
                                                                    Low stock alert will trigger when stock reaches this level
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Specifications -->
                                            <div class="section-card">
                                                <div class="section-header">
                                                    <i class="fas fa-list-alt"></i>
                                                    <h4 class="section-title">Product Specifications</h4>
                                                </div>
                                                <div class="card-body-custom">
                                                    <div id="specifications-container">
                                                        <div class="specification-row">
                                                            <div class="spec-input">
                                                                <input type="text" class="form-control"
                                                                    name="specifications[key][]"
                                                                    placeholder="Specification name (e.g., Color, Size)">
                                                            </div>
                                                            <div class="spec-input">
                                                                <input type="text" class="form-control"
                                                                    name="specifications[value][]"
                                                                    placeholder="Specification value (e.g., Black, Large)">
                                                            </div>
                                                            <button type="button" class="remove-specification" disabled>
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="add-specification-btn"
                                                        id="add-specification">
                                                        <i class="fas fa-plus"></i> Add Specification
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Right Column - Sidebar -->
                                        <div class="col-lg-4">
                                            <!-- Image Upload -->
                                            <div class="section-card">
                                                <div class="section-header">
                                                    <i class="fas fa-camera"></i>
                                                    <h4 class="section-title">Product Image</h4>
                                                </div>
                                                <div class="card-body-custom">
                                                    <div class="image-upload-container">
                                                        <div class="image-preview-wrapper">
                                                            <img id="image-preview"
                                                                src="https://via.placeholder.com/300x300?text=Product+Image"
                                                                class="image-preview" style="display: none;">
                                                            <div class="upload-placeholder" id="upload-placeholder">
                                                                <i class="fas fa-cloud-upload-alt"></i>
                                                                <span>Click to upload image</span>
                                                            </div>
                                                        </div>
                                                        <input type="file"
                                                            class="custom-file-input @error('image') is-invalid @enderror"
                                                            id="image" name="image" accept="image/*">
                                                        @error('image')
                                                            <div class="error-message">{{ $message }}</div>
                                                        @enderror
                                                        <small class="form-text">
                                                            <i class="fas fa-info-circle"></i>
                                                            Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Status Settings -->
                                            <div class="section-card">
                                                <div class="section-header">
                                                    <i class="fas fa-cog"></i>
                                                    <h4 class="section-title">Status Settings</h4>
                                                </div>
                                                <div class="card-body-custom">
                                                    <div class="form-group">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="is_active" name="is_active" value="1" checked>
                                                            <label class="custom-control-label" for="is_active">Active
                                                                Product</label>
                                                        </div>
                                                        <small class="form-text">
                                                            <i class="fas fa-eye"></i>
                                                            Inactive products won't be shown to customers
                                                        </small>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="is_featured" name="is_featured" value="1">
                                                            <label class="custom-control-label" for="is_featured">Featured
                                                                Product</label>
                                                        </div>
                                                        <small class="form-text">
                                                            <i class="fas fa-star"></i>
                                                            Featured products may be highlighted on the website
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Action Buttons -->
                                            <div class="section-card">
                                                <div class="card-body-custom">
                                                    <div class="action-buttons">
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fas fa-save"></i> Save Product
                                                        </button>
                                                        <a href="{{ route('products.index') }}" class="btn btn-secondary">
                                                            <i class="fas fa-times"></i> Cancel
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Image preview functionality
                const imageInput = document.getElementById('image');
                const imagePreview = document.getElementById('image-preview');
                const uploadPlaceholder = document.getElementById('upload-placeholder');

                uploadPlaceholder.addEventListener('click', function() {
                    imageInput.click();
                });

                imageInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        // Check file size (2MB max)
                        if (file.size > 2 * 1024 * 1024) {
                            alert('File size must be less than 2MB');
                            this.value = '';
                            return;
                        }

                        const reader = new FileReader();
                        reader.onload = function(e) {
                            imagePreview.src = e.target.result;
                            imagePreview.style.display = 'block';
                            uploadPlaceholder.style.display = 'none';
                        }
                        reader.readAsDataURL(file);
                    } else {
                        imagePreview.style.display = 'none';
                        uploadPlaceholder.style.display = 'flex';
                    }
                });

                // Specifications management
                const specsContainer = document.getElementById('specifications-container');
                const addSpecBtn = document.getElementById('add-specification');

                addSpecBtn.addEventListener('click', function() {
                    const newRow = document.createElement('div');
                    newRow.className = 'specification-row';
                    newRow.innerHTML = `
            <div class="spec-input">
                <input type="text" class="form-control" name="specifications[key][]" placeholder="Specification name">
            </div>
            <div class="spec-input">
                <input type="text" class="form-control" name="specifications[value][]" placeholder="Specification value">
            </div>
            <button type="button" class="remove-specification">
                <i class="fas fa-trash"></i>
            </button>
        `;
                    specsContainer.appendChild(newRow);
                    updateRemoveButtons();
                });

                function updateRemoveButtons() {
                    const removeButtons = document.querySelectorAll('.remove-specification');
                    removeButtons.forEach(button => {
                        button.disabled = removeButtons.length === 1;
                        button.addEventListener('click', function() {
                            if (removeButtons.length > 1) {
                                this.closest('.specification-row').remove();
                                updateRemoveButtons();
                            }
                        });
                    });
                }

                // Initialize remove buttons
                updateRemoveButtons();

                // Profit margin calculation
                const priceInput = document.getElementById('price');
                const costPriceInput = document.getElementById('cost_price');
                const profitMargin = document.getElementById('profitMargin');
                const marginValue = document.getElementById('marginValue');

                function calculateProfitMargin() {
                    const price = parseFloat(priceInput.value) || 0;
                    const costPrice = parseFloat(costPriceInput.value) || 0;

                    if (costPrice > 0 && price > 0) {
                        const margin = ((price - costPrice) / costPrice) * 100;
                        marginValue.textContent = margin.toFixed(1) + '%';

                        // Color coding based on margin
                        if (margin >= 50) {
                            marginValue.style.color = 'var(--success-color)';
                        } else if (margin >= 20) {
                            marginValue.style.color = 'var(--warning-color)';
                        } else {
                            marginValue.style.color = 'var(--error-color)';
                        }

                        profitMargin.style.display = 'block';
                    } else {
                        profitMargin.style.display = 'none';
                    }
                }

                priceInput.addEventListener('input', calculateProfitMargin);
                costPriceInput.addEventListener('input', calculateProfitMargin);

                // Auto-generate SKU if empty
                const skuInput = document.getElementById('sku');
                const nameInput = document.getElementById('name');
                const categoryInput = document.getElementById('category');

                function generateSKU() {
                    if (!skuInput.value) {
                        const name = nameInput.value.substring(0, 3).toUpperCase();
                        const category = categoryInput.value.substring(0, 3).toUpperCase();
                        const random = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
                        skuInput.value = `${name}-${category}-${random}`;
                    }
                }

                nameInput.addEventListener('blur', generateSKU);
                categoryInput.addEventListener('blur', generateSKU);

                // Form validation
                const form = document.querySelector('form');
                form.addEventListener('submit', function(e) {
                    let isValid = true;

                    // Basic validation
                    const requiredFields = form.querySelectorAll('[required]');
                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            isValid = false;
                            field.classList.add('is-invalid');
                        } else {
                            field.classList.remove('is-invalid');
                        }
                    });

                    if (!isValid) {
                        e.preventDefault();
                        alert('Please fill in all required fields.');
                    }
                });
            });
        </script>
    @endpush
