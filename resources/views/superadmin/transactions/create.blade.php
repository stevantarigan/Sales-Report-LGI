@extends('layouts.app')

@section('title', 'Tambah Transaksi Baru - Super Admin')

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
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

        /* Form Styles */
        .form-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .required-field::after {
            content: " *";
            color: var(--error-color);
        }

        .form-label {
            font-weight: 500;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            padding: 0.7rem 1rem;
            transition: var(--transition);
            background: rgba(255, 255, 255, 0.8);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            background: white;
        }

        .form-text {
            font-size: 0.8rem;
            color: #64748b;
            margin-top: 0.25rem;
        }

        .invalid-feedback {
            color: var(--error-color);
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }

        /* Alert Styles */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.25rem;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error-color);
            border-left: 4px solid var(--error-color);
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
            border-left: 4px solid var(--success-color);
        }

        .alert-info {
            background: rgba(6, 182, 212, 0.1);
            color: var(--info-color);
            border-left: 4px solid var(--info-color);
        }

        .alert-warning {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning-color);
            border-left: 4px solid var(--warning-color);
        }

        .alert-heading {
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 8px;
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

        /* Breadcrumb */
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 0;
        }

        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
            transition: var(--transition);
        }

        .breadcrumb-item a:hover {
            color: var(--secondary-color);
        }

        .breadcrumb-item.active {
            color: #64748b;
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

        /* Price Calculation */
        .price-calculation {
            background: rgba(79, 70, 229, 0.05);
            border-radius: 10px;
            padding: 1rem;
            margin-top: 1rem;
        }

        .calculation-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .calculation-row:last-child {
            border-bottom: none;
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--primary-color);
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

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(79, 70, 229, 0.4);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(79, 70, 229, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(79, 70, 229, 0);
            }
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        /* Responsive */
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
                        <a href="{{ route('admin.transactions.index') }}">Transactions</a>
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

                <form action="{{ route('admin.transactions.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <!-- Sales Person -->
                        <div class="col-md-6 mb-3">
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
                        <div class="col-md-6 mb-3">
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

                    <div class="row">
                        <!-- Product -->
                        <div class="col-md-6 mb-3">
                            <label for="product_id" class="form-label required-field">Produk</label>
                            <select class="form-select @error('product_id') is-invalid @enderror" id="product_id"
                                name="product_id" required>
                                <option value="">Pilih Produk</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                        data-stock="{{ $product->stock }}"
                                        {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} - Rp {{ number_format($product->price, 0, ',', '.') }} (Stok:
                                        {{ $product->stock }})
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Quantity -->
                        <div class="col-md-3 mb-3">
                            <label for="quantity" class="form-label required-field">Quantity</label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                id="quantity" name="quantity" value="{{ old('quantity', 1) }}" min="1"
                                max="1000" required>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text" id="stock-info">Stok tersedia: -</div>
                        </div>

                        <!-- Price per Unit -->
                        <div class="col-md-3 mb-3">
                            <label for="price" class="form-label required-field">Harga per Unit</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('price') is-invalid @enderror"
                                    id="price" name="price" value="{{ old('price') }}" min="0" step="1000"
                                    required>
                            </div>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Price Calculation -->
                    <div class="price-calculation">
                        <div class="calculation-row">
                            <span>Quantity:</span>
                            <span id="calc-quantity">1</span>
                        </div>
                        <div class="calculation-row">
                            <span>Harga per Unit:</span>
                            <span id="calc-price">Rp 0</span>
                        </div>
                        <div class="calculation-row">
                            <span>Total Harga:</span>
                            <span id="calc-total">Rp 0</span>
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
                        <button type="submit" class="btn btn-success">
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

        // Price calculation functionality
        document.addEventListener('DOMContentLoaded', function() {
            const productSelect = document.getElementById('product_id');
            const quantityInput = document.getElementById('quantity');
            const priceInput = document.getElementById('price');
            const stockInfo = document.getElementById('stock-info');

            // Calculation display elements
            const calcQuantity = document.getElementById('calc-quantity');
            const calcPrice = document.getElementById('calc-price');
            const calcTotal = document.getElementById('calc-total');

            function updatePriceCalculation() {
                const quantity = parseInt(quantityInput.value) || 0;
                const price = parseInt(priceInput.value) || 0;
                const total = quantity * price;

                // Update calculation display
                calcQuantity.textContent = quantity;
                calcPrice.textContent = `Rp ${price.toLocaleString('id-ID')}`;
                calcTotal.textContent = `Rp ${total.toLocaleString('id-ID')}`;
            }

            function updateProductInfo() {
                const selectedOption = productSelect.options[productSelect.selectedIndex];
                if (selectedOption && selectedOption.value) {
                    const price = selectedOption.getAttribute('data-price');
                    const stock = selectedOption.getAttribute('data-stock');

                    // Update price input
                    priceInput.value = price;

                    // Update stock info
                    stockInfo.textContent = `Stok tersedia: ${stock}`;

                    // Update max quantity
                    quantityInput.setAttribute('max', stock);

                    // Check if current quantity exceeds stock
                    if (parseInt(quantityInput.value) > parseInt(stock)) {
                        quantityInput.value = stock;
                    }
                } else {
                    priceInput.value = '';
                    stockInfo.textContent = 'Stok tersedia: -';
                    quantityInput.removeAttribute('max');
                }

                updatePriceCalculation();
            }

            // Event listeners
            productSelect.addEventListener('change', updateProductInfo);
            quantityInput.addEventListener('input', updatePriceCalculation);
            priceInput.addEventListener('input', updatePriceCalculation);

            // Initialize on page load
            updateProductInfo();
            updatePriceCalculation();

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

                            alert(errorMessage);
                            getLocationBtn.innerHTML =
                                '<i class="fas fa-crosshairs me-1"></i> Dapatkan';
                            getLocationBtn.disabled = false;
                        }, {
                            enableHighAccuracy: true,
                            timeout: 10000,
                            maximumAge: 0
                        }
                    );
                } else {
                    alert('Browser tidak mendukung geolocation');
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

                        setTimeout(() => {
                            copyLocationBtn.innerHTML = originalText;
                            copyLocationBtn.classList.remove('btn-primary');
                            copyLocationBtn.classList.add('btn-success');
                        }, 2000);
                    });
                } else {
                    alert('Tidak ada lokasi untuk disalin');
                }
            });

            // Photo functionality
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

            // Form validation
            document.querySelector('form').addEventListener('submit', function(e) {
                const quantity = parseInt(quantityInput.value);
                const maxQuantity = parseInt(quantityInput.getAttribute('max'));

                if (maxQuantity && quantity > maxQuantity) {
                    e.preventDefault();
                    alert(`Quantity melebihi stok yang tersedia. Stok tersedia: ${maxQuantity}`);
                    quantityInput.focus();
                }
            });

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const fade = new bootstrap.Alert(alert);
                    fade.close();
                });
            }, 5000);
        });

        // Format currency display
        function formatCurrency(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(amount);
        }
        // Improved photo handling function
        function dataURLtoFile(dataurl, filename) {
            var arr = dataurl.split(','),
                mime = arr[0].match(/:(.*?);/)[1],
                bstr = atob(arr[1]),
                n = bstr.length,
                u8arr = new Uint8Array(n);

            while (n--) {
                u8arr[n] = bstr.charCodeAt(n);
            }

            return new File([u8arr], filename, {
                type: mime
            });
        }

        // Improved capture function
        captureBtn.addEventListener('click', function() {
            const context = photoCanvas.getContext('2d');
            photoCanvas.width = cameraPreview.videoWidth;
            photoCanvas.height = cameraPreview.videoHeight;
            context.drawImage(cameraPreview, 0, 0, photoCanvas.width, photoCanvas.height);

            photoData = photoCanvas.toDataURL('image/jpeg', 0.8);
            previewImage.src = photoData;
            previewImage.classList.remove('d-none');

            // Convert data URL to file properly
            const file = dataURLtoFile(photoData, 'transaction_photo_' + Date.now() + '.jpg');

            // Create new DataTransfer and set files
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            photoInput.files = dataTransfer.files;

            console.log('Photo captured and converted to file:', file.name, file.size);

            stopCamera();
        });

        // Auto-generate map link when coordinates are available
        function updateMapLink() {
            const latitude = latitudeInput.value;
            const longitude = longitudeInput.value;

            if (latitude && longitude) {
                const mapLink = `https://maps.google.com/?q=${latitude},${longitude}`;
                console.log('Generated map link:', mapLink);
                // You can store this in a hidden field if needed
                return mapLink;
            }
            return null;
        }

        // Update map link when coordinates change
        latitudeInput.addEventListener('change', updateMapLink);
        longitudeInput.addEventListener('change', updateMapLink);

        // Enhanced form validation to ensure photo is processed
        document.querySelector('form').addEventListener('submit', function(e) {
            const quantity = parseInt(quantityInput.value);
            const maxQuantity = parseInt(quantityInput.getAttribute('max'));

            if (maxQuantity && quantity > maxQuantity) {
                e.preventDefault();
                alert(`Quantity melebihi stok yang tersedia. Stok tersedia: ${maxQuantity}`);
                quantityInput.focus();
                return;
            }

            // Validate coordinates if provided
            const latitude = latitudeInput.value;
            const longitude = longitudeInput.value;
            if (latitude && !isValidCoordinate(latitude, 'latitude')) {
                e.preventDefault();
                alert('Format latitude tidak valid');
                return;
            }
            if (longitude && !isValidCoordinate(longitude, 'longitude')) {
                e.preventDefault();
                alert('Format longitude tidak valid');
                return;
            }

            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...';
            submitBtn.disabled = true;

            // Generate map link before submit
            updateMapLink();
        });

        function isValidCoordinate(coord, type) {
            const num = parseFloat(coord);
            if (isNaN(num)) return false;

            if (type === 'latitude') {
                return num >= -90 && num <= 90;
            } else {
                return num >= -180 && num <= 180;
            }
        }
    </script>
@endpush
