@php
    $layout = auth()->user()->role === 'adminsales' ? 'layouts.app2' : 'layouts.app';
@endphp

@extends($layout)

@section('title', 'Edit User | ' . ucfirst(auth()->user()->role))
@section('page-title', 'Edit User')
@section('page-description', 'Update user information and permissions')


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

    .form-container {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: var(--card-shadow);
        border: 1px solid #e2e8f0;
        max-width: 900px;
        margin: 0 auto;
    }

    .form-section {
        margin-bottom: 2.5rem;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--dark-color);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-title i {
        color: var(--primary-color);
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
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
        font-size: 0.95rem;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        outline: none;
    }

    .form-text {
        font-size: 0.875rem;
        color: #64748b;
        margin-top: 0.25rem;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 1rem;
    }

    .form-check {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-check-input {
        width: 18px;
        height: 18px;
        border-radius: 4px;
        border: 2px solid #cbd5e1;
        cursor: pointer;
    }

    .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .form-check-label {
        font-weight: 500;
        color: var(--dark-color);
        cursor: pointer;
    }

    /* User Info Card */
    .user-info-card {
        background: #f8fafc;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border-left: 4px solid var(--primary-color);
    }

    .user-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: var(--gradient-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
        margin-right: 1.5rem;
    }

    .user-details {
        flex: 1;
    }

    .user-name {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--dark-color);
        margin-bottom: 0.25rem;
    }

    .user-email {
        color: #64748b;
        margin-bottom: 0.5rem;
    }

    .user-meta {
        display: flex;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #64748b;
        font-size: 0.875rem;
    }

    /* Badge Styles */
    .badge {
        padding: 0.5rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
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

    .btn-danger {
        background: var(--error-color);
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
        transform: translateY(-2px);
    }

    /* Form Switch */
    .form-switch {
        padding-left: 2.5em;
    }

    .form-switch .form-check-input {
        width: 2em;
        margin-left: -2.5em;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e");
        background-position: left center;
        border-radius: 2em;
        transition: background-position 0.15s ease-in-out;
    }

    .form-switch .form-check-input:checked {
        background-position: right center;
        background-color: var(--success-color);
        border-color: var(--success-color);
    }

    /* Password Section */
    .password-section {
        background: #f8fafc;
        border-radius: 12px;
        padding: 1.5rem;
        margin-top: 1rem;
    }

    .password-toggle {
        cursor: pointer;
        color: var(--primary-color);
        font-size: 0.875rem;
        font-weight: 500;
    }

    .password-toggle:hover {
        text-decoration: underline;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .form-container {
            padding: 1.5rem;
            margin: 0 1rem;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .user-info-card {
            flex-direction: column;
            text-align: center;
        }

        .user-avatar {
            margin-right: 0;
            margin-bottom: 1rem;
        }

        .user-meta {
            justify-content: center;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }

    /* Loading state */
    .btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none !important;
    }

    /* Error states */
    .is-invalid {
        border-color: var(--error-color) !important;
    }

    .invalid-feedback {
        display: block;
        color: var(--error-color);
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    /* Success states */
    .is-valid {
        border-color: var(--success-color) !important;
    }
</style>
@endpush

@section('content')
<div class="form-container" data-aos="fade-up">
    <!-- User Info Header -->
    <div class="user-info-card d-flex align-items-center">
        <div class="user-avatar">
            <i class="fas fa-user"></i>
        </div>
        <div class="user-details">
            <div class="user-name">{{ $user->name }}</div>
            <div class="user-email">{{ $user->email }}</div>
            <div class="user-meta">
                <div class="meta-item">
                    <i class="fas fa-id-badge"></i>
                    <span>ID: {{ $user->id }}</span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-user-tag"></i>
                    <span>
                        <span class="badge 
                            @if($user->role == 'superadmin') badge-danger
                            @elseif($user->role == 'adminsales') badge-warning
                            @else badge-secondary @endif">
                            {{ $user->role }}
                        </span>
                    </span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-circle"></i>
                    <span>
                        <span class="badge {{ $user->is_active ? 'badge-success' : 'badge-danger' }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-calendar"></i>
                    <span>Joined: {{ $user->created_at->format('M j, Y') }}</span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-clock"></i>
                    <span>Last Login: {{ $user->last_login_at ? $user->last_login_at->format('M j, Y g:i A') : 'Never' }}</span>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.users.update', $user) }}" method="POST" id="editUserForm">
        @csrf
        @method('PUT')

        <!-- Basic Information Section -->
        <div class="form-section">
            <h3 class="section-title">
                <i class="fas fa-user-circle"></i>
                Basic Information
            </h3>
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="name" class="form-label">Full Name *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email Address *</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                           id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="role" class="form-label">Role *</label>
                    <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" required>
                        <option value="">Select Role</option>
                        <option value="superadmin" {{ old('role', $user->role) == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                        <option value="adminsales" {{ old('role', $user->role) == 'adminsales' ? 'selected' : '' }}>Admin Sales</option>
                        <option value="sales" {{ old('role', $user->role) == 'sales' ? 'selected' : '' }}>Sales</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Account Status Section -->
        <div class="form-section">
            <h3 class="section-title">
                <i class="fas fa-cog"></i>
                Account Settings
            </h3>
            
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Account Status</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                               {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Active Account
                        </label>
                    </div>
                    <div class="form-text">
                        When inactive, user cannot login to the system
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Last Activity</label>
                    <div class="card bg-light">
                        <div class="card-body">
                            <div class="mb-2">
                                <small class="text-muted">
                                    <strong>Last Login:</strong>
                                    {{ $user->last_login_at ? $user->last_login_at->format('M j, Y g:i A') : 'Never' }}
                                </small>
                            </div>
                            <div>
                                <small class="text-muted">
                                    <strong>Account Created:</strong>
                                    {{ $user->created_at->format('M j, Y g:i A') }}
                                </small>
                            </div>
                            <div class="mt-2">
                                <small class="text-muted">
                                    <strong>Last Updated:</strong>
                                    {{ $user->updated_at->format('M j, Y g:i A') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Password Section -->
        <div class="form-section">
            <h3 class="section-title">
                <i class="fas fa-lock"></i>
                Password Management
            </h3>
            
            <div class="password-section">
                <div class="form-text mb-3">
                    <i class="fas fa-info-circle text-primary"></i>
                    Leave password fields blank if you don't want to change the password
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" placeholder="Enter new password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Minimum 8 characters</div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation" 
                               placeholder="Confirm new password">
                    </div>
                </div>

                <div class="mt-3">
                    <button type="button" class="password-toggle btn btn-sm btn-outline-primary" 
                            onclick="togglePasswordVisibility()">
                        <i class="fas fa-eye me-1"></i>Show Passwords
                    </button>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Users
            </a>
            <button type="button" class="btn btn-danger" onclick="resetForm()">
                <i class="fas fa-undo me-2"></i>Reset
            </button>
            <button type="submit" class="btn btn-success" id="updateUserBtn">
                <i class="fas fa-save me-2"></i>Update User
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form submission handling
        const form = document.getElementById('editUserForm');
        const submitBtn = document.getElementById('updateUserBtn');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading state
            showLoading(true);
            
            // Submit form
            this.submit();
        });

        // Password visibility toggle
        window.togglePasswordVisibility = function() {
            const passwordField = document.getElementById('password');
            const confirmField = document.getElementById('password_confirmation');
            const toggleBtn = document.querySelector('.password-toggle');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                confirmField.type = 'text';
                toggleBtn.innerHTML = '<i class="fas fa-eye-slash me-1"></i>Hide Passwords';
                toggleBtn.classList.remove('btn-outline-primary');
                toggleBtn.classList.add('btn-primary');
            } else {
                passwordField.type = 'password';
                confirmField.type = 'password';
                toggleBtn.innerHTML = '<i class="fas fa-eye me-1"></i>Show Passwords';
                toggleBtn.classList.remove('btn-primary');
                toggleBtn.classList.add('btn-outline-primary');
            }
        }

        // Form reset functionality
        window.resetForm = function() {
            Swal.fire({
                title: 'Reset Form?',
                text: 'All changes will be lost. This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, reset!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.reset();
                    
                    // Reset checkboxes to original state
                    document.getElementById('is_active').checked = {{ $user->is_active ? 'true' : 'false' }};
                    
                    // Clear password fields
                    document.getElementById('password').value = '';
                    document.getElementById('password_confirmation').value = '';
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Form Reset!',
                        text: 'The form has been reset to its original state.',
                        confirmButtonColor: '#10b981'
                    });
                }
            });
        }

        // Loading state management
        function showLoading(show) {
            if (show) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
            } else {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Update User';
            }
        }

        // Auto-hide alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });

        // Real-time validation
        const inputs = form.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
        });

        function validateField(field) {
            // Simple validation - you can enhance this
            if (field.hasAttribute('required') && !field.value.trim()) {
                field.classList.add('is-invalid');
            } else {
                field.classList.remove('is-invalid');
                field.classList.add('is-valid');
            }

            // Email validation
            if (field.type === 'email' && field.value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(field.value)) {
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                    field.classList.add('is-valid');
                }
            }

            // Password confirmation validation
            if (field.id === 'password_confirmation' && field.value) {
                const password = document.getElementById('password').value;
                if (field.value !== password) {
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                    field.classList.add('is-valid');
                }
            }
        }
    });

    // Show success message if there's any in session
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#10b981'
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#ef4444'
        });
    @endif
</script>
@endpush