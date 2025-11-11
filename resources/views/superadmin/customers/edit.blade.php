@php
    $layout = auth()->user()->role === 'adminsales' ? 'layouts.app2' : 'layouts.app';
@endphp

@extends($layout)

@section('title', 'Edit Customer | ' . ucfirst(auth()->user()->role))
@section('page-title', 'Edit Customer')
@section('page-description', 'Edit data pelanggan dan informasi kontak')

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

        /* Form Container */
        .form-container {
            background: white;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .form-header {
            background: var(--gradient-primary);
            color: white;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .form-header h3 {
            margin: 0;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .form-body {
            padding: 2rem;
        }

        /* Form Sections */
        .form-section {
            margin-bottom: 2.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .form-section:last-of-type {
            border-bottom: none;
            margin-bottom: 0;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-title i {
            color: var(--primary-color);
        }

        /* Form Grid */
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

        /* Custom Select */
        .custom-select {
            position: relative;
        }

        .custom-select select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }

        /* Checkbox and Radio */
        .form-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .form-check-input {
            width: 1.1em;
            height: 1.1em;
            border: 2px solid #d1d5db;
            border-radius: 0.25em;
            transition: var(--transition);
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-label {
            font-weight: 500;
            color: var(--dark-color);
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .status-badge.active {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
        }

        .status-badge.inactive {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error-color);
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #f1f5f9;
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
            font-size: 0.95rem;
        }

        .btn-primary {
            background: var(--gradient-primary);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.4);
        }

        .btn-secondary {
            background: #64748b;
            color: white;
        }

        .btn-secondary:hover {
            background: #475569;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(100, 116, 139, 0.4);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid #e2e8f0;
            color: #64748b;
        }

        .btn-outline:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
            transform: translateY(-2px);
        }

        /* Customer Preview */
        .customer-preview {
            background: #f8fafc;
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 1rem;
        }

        .preview-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .customer-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            font-weight: 600;
        }

        .preview-info h4 {
            margin: 0 0 0.25rem 0;
            color: var(--dark-color);
        }

        .preview-info p {
            margin: 0;
            color: #64748b;
            font-size: 0.9rem;
        }

        .preview-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .preview-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .preview-label {
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 500;
        }

        .preview-value {
            font-weight: 600;
            color: var(--dark-color);
        }

        /* WhatsApp Preview */
        .whatsapp-preview {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #25D366;
            font-weight: 500;
            text-decoration: none;
            padding: 0.5rem 1rem;
            background: rgba(37, 211, 102, 0.1);
            border-radius: 8px;
            transition: var(--transition);
        }

        .whatsapp-preview:hover {
            background: rgba(37, 211, 102, 0.2);
            transform: translateY(-1px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                justify-content: center;
            }

            .preview-details {
                grid-template-columns: 1fr;
            }
        }

        /* Loading States */
        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        /* Error States */
        .is-invalid {
            border-color: var(--error-color) !important;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
        }

        .invalid-feedback {
            color: var(--error-color);
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: block;
        }

        /* Success States */
        .is-valid {
            border-color: var(--success-color) !important;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1) !important;
        }
    </style>
@endpush

@section('content')
    <div class="form-container" data-aos="fade-up">
        <div class="form-header">
            <h3>
                <i class="fas fa-user-edit"></i>
                Edit Customer - {{ $customer->name }}
            </h3>
        </div>

        <form action="{{ route('admin.customers.update', $customer) }}" method="POST" id="editCustomerForm">
            @csrf
            @method('PUT')

            <div class="form-body">
                <!-- Basic Information Section -->
                <div class="form-section">
                    <h4 class="section-title">
                        <i class="fas fa-user-circle"></i>
                        Informasi Dasar
                    </h4>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name" class="form-label">Nama Lengkap *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $customer->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email', $customer->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_active" id="active"
                                        value="1" {{ old('is_active', $customer->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="active">
                                        <span class="status-badge active">
                                            <i class="fas fa-check-circle"></i>
                                            Active
                                        </span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_active" id="inactive"
                                        value="0" {{ !old('is_active', $customer->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="inactive">
                                        <span class="status-badge inactive">
                                            <i class="fas fa-times-circle"></i>
                                            Inactive
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information Section -->
                <div class="form-section">
                    <h4 class="section-title">
                        <i class="fas fa-address-book"></i>
                        Informasi Kontak
                    </h4>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="phone" class="form-label">Nomor Telepon/WhatsApp</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                name="phone" value="{{ old('phone', $customer->phone) }}"
                                placeholder="Contoh: +6281234567890">
                            <div class="form-text">
                                Format: +62 followed by your number (contoh: +6281234567890)
                            </div>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone_secondary" class="form-label">Nomor Telepon Alternatif</label>
                            <input type="tel" class="form-control @error('phone_secondary') is-invalid @enderror"
                                id="phone_secondary" name="phone_secondary"
                                value="{{ old('phone_secondary', $customer->phone_secondary) }}"
                                placeholder="Nomor telepon alternatif">
                            @error('phone_secondary')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Location Information Section -->
                <div class="form-section">
                    <h4 class="section-title">
                        <i class="fas fa-map-marker-alt"></i>
                        Informasi Lokasi
                    </h4>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="address" class="form-label">Alamat Lengkap</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3"
                                placeholder="Masukkan alamat lengkap customer">{{ old('address', $customer->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="city" class="form-label">Kota</label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" id="city"
                                name="city" value="{{ old('city', $customer->city) }}" placeholder="Nama kota">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="province" class="form-label">Provinsi</label>
                            <input type="text" class="form-control @error('province') is-invalid @enderror"
                                id="province" name="province" value="{{ old('province', $customer->province) }}"
                                placeholder="Nama provinsi">
                            @error('province')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="postal_code" class="form-label">Kode Pos</label>
                            <input type="text" class="form-control @error('postal_code') is-invalid @enderror"
                                id="postal_code" name="postal_code"
                                value="{{ old('postal_code', $customer->postal_code) }}" placeholder="Kode pos">
                            @error('postal_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="country" class="form-label">Negara</label>
                            <input type="text" class="form-control @error('country') is-invalid @enderror"
                                id="country" name="country"
                                value="{{ old('country', $customer->country ?? 'Indonesia') }}"
                                placeholder="Nama negara">
                            @error('country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Additional Information Section -->
                <div class="form-section">
                    <h4 class="section-title">
                        <i class="fas fa-info-circle"></i>
                        Informasi Tambahan
                    </h4>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="company" class="form-label">Perusahaan</label>
                            <input type="text" class="form-control @error('company') is-invalid @enderror"
                                id="company" name="company" value="{{ old('company', $customer->company) }}"
                                placeholder="Nama perusahaan (jika ada)">
                            @error('company')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="notes" class="form-label">Catatan</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3"
                                placeholder="Catatan tambahan tentang customer">{{ old('notes', $customer->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Customer Preview -->
                <div class="customer-preview" data-aos="fade-up" data-aos-delay="200">
                    <div class="preview-header">
                        <div class="customer-avatar">
                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                        </div>
                        <div class="preview-info">
                            <h4 id="previewName">{{ $customer->name }}</h4>
                            <p id="previewEmail">{{ $customer->email }}</p>
                        </div>
                    </div>
                    <div class="preview-details">
                        <div class="preview-item">
                            <span class="preview-label">Status</span>
                            <span class="preview-value" id="previewStatus">
                                @if ($customer->is_active)
                                    <span class="status-badge active">Active</span>
                                @else
                                    <span class="status-badge inactive">Inactive</span>
                                @endif
                            </span>
                        </div>
                        <div class="preview-item">
                            <span class="preview-label">Telepon</span>
                            <span class="preview-value" id="previewPhone">
                                @if ($customer->phone)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $customer->phone) }}"
                                        target="_blank" class="whatsapp-preview">
                                        <i class="fab fa-whatsapp"></i>
                                        {{ $customer->phone }}
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </span>
                        </div>
                        <div class="preview-item">
                            <span class="preview-label">Lokasi</span>
                            <span class="preview-value" id="previewLocation">
                                @if ($customer->city && $customer->province)
                                    {{ $customer->city }}, {{ $customer->province }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </span>
                        </div>
                        <div class="preview-item">
                            <span class="preview-label">Terdaftar</span>
                            <span class="preview-value">
                                {{ $customer->created_at->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('admin.customers.index') }}" class="btn btn-outline">
                        <i class="fas fa-arrow-left me-2"></i>
                        Kembali
                    </a>
                    <button type="button" class="btn btn-secondary" onclick="resetForm()">
                        <i class="fas fa-undo me-2"></i>
                        Reset
                    </button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-save me-2"></i>
                        Update Customer
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('editCustomerForm');
            const submitBtn = document.getElementById('submitBtn');

            // Real-time preview updates
            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const phoneInput = document.getElementById('phone');
            const cityInput = document.getElementById('city');
            const provinceInput = document.getElementById('province');
            const activeRadio = document.getElementById('active');
            const inactiveRadio = document.getElementById('inactive');

            // Update preview when inputs change
            nameInput.addEventListener('input', updatePreview);
            emailInput.addEventListener('input', updatePreview);
            phoneInput.addEventListener('input', updatePreview);
            cityInput.addEventListener('input', updatePreview);
            provinceInput.addEventListener('input', updatePreview);
            activeRadio.addEventListener('change', updatePreview);
            inactiveRadio.addEventListener('change', updatePreview);

            function updatePreview() {
                // Update name
                document.getElementById('previewName').textContent = nameInput.value || '{{ $customer->name }}';

                // Update email
                document.getElementById('previewEmail').textContent = emailInput.value || '{{ $customer->email }}';

                // Update phone with WhatsApp link
                const phoneValue = phoneInput.value || '{{ $customer->phone }}';
                const phonePreview = document.getElementById('previewPhone');
                if (phoneValue) {
                    const cleanPhone = phoneValue.replace(/[^0-9]/g, '');
                    phonePreview.innerHTML = `
                    <a href="https://wa.me/${cleanPhone}" target="_blank" class="whatsapp-preview">
                        <i class="fab fa-whatsapp"></i>
                        ${phoneValue}
                    </a>
                `;
                } else {
                    phonePreview.innerHTML = '<span class="text-muted">-</span>';
                }

                // Update location
                const city = cityInput.value || '{{ $customer->city }}';
                const province = provinceInput.value || '{{ $customer->province }}';
                const locationPreview = document.getElementById('previewLocation');
                if (city && province) {
                    locationPreview.textContent = `${city}, ${province}`;
                } else if (city) {
                    locationPreview.textContent = city;
                } else if (province) {
                    locationPreview.textContent = province;
                } else {
                    locationPreview.innerHTML = '<span class="text-muted">-</span>';
                }

                // Update status
                const statusPreview = document.getElementById('previewStatus');
                if (activeRadio.checked) {
                    statusPreview.innerHTML =
                        '<span class="status-badge active"><i class="fas fa-check-circle"></i>Active</span>';
                } else {
                    statusPreview.innerHTML =
                        '<span class="status-badge inactive"><i class="fas fa-times-circle"></i>Inactive</span>';
                }
            }

            // Form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Validate form
                if (!validateForm()) {
                    return;
                }

                // Show loading state
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                submitBtn.disabled = true;
                form.classList.add('loading');

                // Submit form
                this.submit();
            });

            // Form validation
            function validateForm() {
                let isValid = true;
                const requiredFields = form.querySelectorAll('[required]');

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                // Email validation
                const email = emailInput.value;
                if (email && !isValidEmail(email)) {
                    emailInput.classList.add('is-invalid');
                    isValid = false;
                }

                return isValid;
            }

            function isValidEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }

            // Phone number formatting
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/[^\d+]/g, '');

                // Ensure it starts with +62
                if (value.startsWith('0')) {
                    value = '+62' + value.substring(1);
                } else if (!value.startsWith('+62') && value.length > 0) {
                    value = '+62' + value;
                }

                e.target.value = value;
            });

            // Reset form confirmation
            window.resetForm = function() {
                Swal.fire({
                    title: 'Reset Form?',
                    text: 'Semua perubahan yang belum disimpan akan hilang',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Reset',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#f59e0b',
                    cancelButtonColor: '#6c757d'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.reset();
                        updatePreview();

                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Form telah direset',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                });
            };

            // Auto-save draft (optional feature)
            let draftTimeout;
            const formInputs = form.querySelectorAll('input, textarea, select');

            formInputs.forEach(input => {
                input.addEventListener('input', function() {
                    clearTimeout(draftTimeout);
                    draftTimeout = setTimeout(saveDraft, 1000);
                });
            });

            function saveDraft() {
                // Implement draft saving logic here if needed
                console.log('Auto-saving draft...');
            }

            // Initialize preview on page load
            updatePreview();
        });

        // Handle page before unload
        window.addEventListener('beforeunload', function(e) {
            const form = document.getElementById('editCustomerForm');
            const formData = new FormData(form);
            let hasChanges = false;

            // Check if form has unsaved changes
            formData.forEach((value, key) => {
                if (value !== '' && key !== '_token' && key !== '_method') {
                    hasChanges = true;
                }
            });

            if (hasChanges) {
                e.preventDefault();
                e.returnValue =
                'Anda memiliki perubahan yang belum disimpan. Yakin ingin meninggalkan halaman ini?';
            }
        });
    </script>

    <style>
        /* SweetAlert2 Custom Styles */
        .swal2-popup {
            border-radius: 16px;
            padding: 2rem;
        }

        /* Animation for form elements */
        [data-aos] {
            transition: all 0.6s ease;
        }

        /* Custom scrollbar */
        .form-body::-webkit-scrollbar {
            width: 6px;
        }

        .form-body::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }

        .form-body::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        .form-body::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Focus states for better accessibility */
        .form-control:focus {
            transform: translateY(-1px);
        }

        /* Hover effects */
        .btn {
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }
    </style>
@endpush
