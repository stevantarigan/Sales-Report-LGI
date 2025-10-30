<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User Baru - Super Admin</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
        }
        .form-container {
            max-width: 800px;
            margin: 0 auto;
        }
        .required-field::after {
            content: " *";
            color: red;
        }
        body {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="form-container">
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
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0"><i class="fas fa-user-circle me-2"></i>Form Data User</h5>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Terjadi Kesalahan!</h6>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <!-- Nama Lengkap -->
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label required-field">Nama Lengkap</label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       placeholder="Masukkan nama lengkap" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label required-field">Email</label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       placeholder="Masukkan alamat email" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Role -->
                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label required-field">Role</label>
                                <select class="form-select @error('role') is-invalid @enderror" 
                                        id="role" 
                                        name="role" 
                                        required>
                                    <option value="">Pilih Role</option>
                                    <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                                    <option value="adminsales" {{ old('role') == 'adminsales' ? 'selected' : '' }}>Admin Sales</option>
                                    <option value="sales" {{ old('role') == 'sales' ? 'selected' : '' }}>Sales</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nomor Telepon -->
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="text" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone') }}" 
                                       placeholder="Contoh: 081234567890">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Password -->
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label required-field">Password</label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Masukkan password (minimal 8 karakter)" 
                                       required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Password minimal 8 karakter</div>
                            </div>

                            <!-- Konfirmasi Password -->
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label required-field">Konfirmasi Password</label>
                                <input type="password" 
                                       class="form-control @error('password_confirmation') is-invalid @enderror" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       placeholder="Ulangi password" 
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
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
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
    </script>
</body>
</html>