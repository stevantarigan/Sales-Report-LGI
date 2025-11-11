@php
    $layout = auth()->user()->role === 'adminsales' ? 'layouts.app2' : 'layouts.app';
@endphp

@extends($layout)

@section('title', 'Tambah User Baru | ' . ucfirst(auth()->user()->role))

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
            max-width: 800px;
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
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(255, 255, 255, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0);
            }
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-5px);
            }

            60% {
                transform: translateY(-3px);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .content-area {
                padding: 1rem;
            }

            .form-container {
                max-width: 100%;
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
                <h2 class="h4 mb-1"><i class="fas fa-user-plus me-2"></i>Tambah User Baru</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                        <li class="breadcrumb-item active">Tambah User</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <!-- Form Card -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="fas fa-user-circle me-2"></i>Form Data User</h5>
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

                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <!-- Nama Lengkap -->
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label required-field">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label required-field">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email') }}" placeholder="Masukkan alamat email" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- Role -->
                        <div class="col-md-6 mb-3">
                            <label for="role" class="form-label required-field">Role</label>
                            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role"
                                required>
                                <option value="">Pilih Role</option>
                                <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>Super Admin
                                </option>
                                <option value="adminsales" {{ old('role') == 'adminsales' ? 'selected' : '' }}>Admin Sales
                                </option>
                                <option value="sales" {{ old('role') == 'sales' ? 'selected' : '' }}>Sales</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nomor Telepon -->
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                name="phone" value="{{ old('phone') }}" placeholder="Contoh: 081234567890">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- Password -->
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label required-field">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="Masukkan password (minimal 8 karakter)"
                                required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Password minimal 8 karakter</div>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label required-field">Konfirmasi Password</label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                id="password_confirmation" name="password_confirmation" placeholder="Ulangi password"
                                required>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Informasi Tambahan -->
                    <div class="alert alert-info mt-3">
                        <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Informasi</h6>
                        <ul class="mb-0">
                            <li>User akan langsung aktif setelah dibuat</li>
                            <li>Email akan terverifikasi otomatis</li>
                            <li>Password harus minimal 8 karakter</li>
                            <li>Pastikan email yang dimasukkan valid dan unik</li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i> Simpan User
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

        // Password confirmation validation
        document.addEventListener('DOMContentLoaded', function() {
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('password_confirmation');

            function validatePassword() {
                if (password.value !== confirmPassword.value) {
                    confirmPassword.setCustomValidity('Password tidak sesuai');
                } else {
                    confirmPassword.setCustomValidity('');
                }
            }

            password.addEventListener('change', validatePassword);
            password.addEventListener('keyup', validatePassword);
            confirmPassword.addEventListener('keyup', validatePassword);
        });

        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const fade = new bootstrap.Alert(alert);
                    fade.close();
                });
            }, 5000);
        });

        // Phone number formatting
        document.getElementById('phone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.startsWith('0')) {
                value = value.substring(1);
            }
            if (value.length > 0) {
                value = '0' + value;
            }
            e.target.value = value;
        });
    </script>
@endpush
