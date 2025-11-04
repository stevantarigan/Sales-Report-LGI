@extends('layouts.app')

@section('title', 'Customer Details | SuperAdmin')
@section('page-title', 'Customer Details')
@section('page-description', 'View detailed information about the customer')

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

    /* Header Section */
    .customer-header {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
        border-left: 4px solid var(--primary-color);
    }

    .customer-avatar-large {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: var(--gradient-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2.5rem;
        font-weight: 600;
        margin-right: 1.5rem;
        border: 4px solid white;
        box-shadow: 0 8px 25px rgba(79, 70, 229, 0.3);
    }

    .customer-name {
        font-size: 2rem;
        font-weight: 700;
        color: var(--dark-color);
        margin-bottom: 0.5rem;
    }

    .customer-id {
        color: #64748b;
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }

    .customer-join-date {
        color: #64748b;
        font-size: 0.9rem;
    }

    /* Status Badges */
    .status-badge {
        padding: 0.6rem 1.2rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .status-badge.active {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .status-badge.inactive {
        background: rgba(239, 68, 68, 0.1);
        color: var(--error-color);
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    /* Cards */
    .detail-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: var(--card-shadow);
        transition: var(--transition);
    }

    .detail-card:hover {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--dark-color);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-title i {
        color: var(--primary-color);
    }

    /* Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .info-label {
        font-size: 0.8rem;
        color: #64748b;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 1rem;
        color: var(--dark-color);
        font-weight: 600;
    }

    /* Contact Links */
    .contact-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        transition: var(--transition);
        background: rgba(79, 70, 229, 0.05);
        border: 1px solid rgba(79, 70, 229, 0.1);
    }

    .contact-link:hover {
        background: rgba(79, 70, 229, 0.1);
        color: var(--primary-color);
        transform: translateY(-1px);
    }

    .whatsapp-link {
        background: rgba(37, 211, 102, 0.1);
        border: 1px solid rgba(37, 211, 102, 0.2);
        color: #25D366;
    }

    .whatsapp-link:hover {
        background: rgba(37, 211, 102, 0.2);
        color: #128C7E;
    }

    .email-link {
        background: rgba(6, 182, 212, 0.1);
        border: 1px solid rgba(6, 182, 212, 0.2);
        color: var(--info-color);
    }

    .email-link:hover {
        background: rgba(6, 182, 212, 0.2);
        color: #0891b2;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        flex-wrap: wrap;
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
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(79, 70, 229, 0.3);
    }

    .btn-secondary {
        background: rgba(100, 116, 139, 0.1);
        color: #64748b;
        border: 1px solid rgba(100, 116, 139, 0.2);
    }

    .btn-secondary:hover {
        background: rgba(100, 116, 139, 0.2);
        transform: translateY(-2px);
    }

    .btn-success {
        background: var(--gradient-success);
        color: white;
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
    }

    .btn-warning {
        background: var(--gradient-warning);
        color: white;
    }

    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(245, 158, 11, 0.3);
    }

    .btn-danger {
        background: var(--gradient-danger);
        color: white;
    }

    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
    }

    /* Timeline */
    .timeline {
        position: relative;
        padding-left: 2rem;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e2e8f0;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -2rem;
        top: 0.25rem;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: var(--primary-color);
        border: 2px solid white;
        box-shadow: 0 0 0 2px var(--primary-color);
    }

    .timeline-date {
        font-size: 0.8rem;
        color: #64748b;
        margin-bottom: 0.25rem;
    }

    .timeline-content {
        font-size: 0.9rem;
        color: var(--dark-color);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: #64748b;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .empty-state h5 {
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
        color: var(--dark-color);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .customer-header {
            padding: 1.5rem;
        }

        .customer-avatar-large {
            width: 80px;
            height: 80px;
            font-size: 2rem;
            margin-right: 1rem;
        }

        .customer-name {
            font-size: 1.5rem;
        }
    }
</style>
@endpush

@section('content')
    <!-- Header Section -->
    <div class="customer-header" data-aos="fade-up">
        <div class="d-flex align-items-start flex-wrap gap-3">
            <div class="customer-avatar-large">
                {{ strtoupper(substr($customer->name, 0, 1)) }}
            </div>
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                    <div>
                        <div class="customer-name">{{ $customer->name }}</div>
                        <div class="customer-id">ID: {{ $customer->id }}</div>
                        <div class="customer-join-date">
                            Member since {{ $customer->created_at->format('F j, Y') }}
                            • {{ $customer->created_at->diffForHumans() }}
                        </div>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <span class="status-badge {{ $customer->is_active ? 'active' : 'inactive' }}">
                            <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>
                            {{ $customer->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column - Customer Details -->
        <div class="col-lg-8">
            <!-- Contact Information -->
            <div class="detail-card" data-aos="fade-up" data-aos-delay="100">
                <h5 class="card-title">
                    <i class="fas fa-address-book"></i>
                    Contact Information
                </h5>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Email Address</span>
                        <div class="d-flex flex-column gap-2">
                            <a href="mailto:{{ $customer->email }}" class="contact-link email-link">
                                <i class="fas fa-envelope"></i>
                                {{ $customer->email }}
                            </a>
                        </div>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Phone Numbers</span>
                        <div class="d-flex flex-column gap-2">
                            @if($customer->phone)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $customer->phone) }}" 
                                   target="_blank" 
                                   class="contact-link whatsapp-link">
                                    <i class="fab fa-whatsapp"></i>
                                    {{ $customer->phone }}
                                </a>
                            @endif
                            @if($customer->phone_secondary)
                                <span class="contact-link">
                                    <i class="fas fa-phone"></i>
                                    {{ $customer->phone_secondary }}
                                </span>
                            @endif
                            @if(!$customer->phone && !$customer->phone_secondary)
                                <span class="text-muted">No phone numbers available</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Location Information -->
            <div class="detail-card" data-aos="fade-up" data-aos-delay="200">
                <h5 class="card-title">
                    <i class="fas fa-map-marker-alt"></i>
                    Location Information
                </h5>
                <div class="info-grid">
                    @if($customer->address)
                        <div class="info-item">
                            <span class="info-label">Full Address</span>
                            <span class="info-value">{{ $customer->address }}</span>
                        </div>
                    @endif
                    
                    <div class="info-grid">
                        @if($customer->city)
                            <div class="info-item">
                                <span class="info-label">City</span>
                                <span class="info-value">{{ $customer->city }}</span>
                            </div>
                        @endif
                        
                        @if($customer->province)
                            <div class="info-item">
                                <span class="info-label">Province</span>
                                <span class="info-value">{{ $customer->province }}</span>
                            </div>
                        @endif
                        
                        @if($customer->postal_code)
                            <div class="info-item">
                                <span class="info-label">Postal Code</span>
                                <span class="info-value">{{ $customer->postal_code }}</span>
                            </div>
                        @endif
                        
                        @if($customer->country)
                            <div class="info-item">
                                <span class="info-label">Country</span>
                                <span class="info-value">{{ $customer->country }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            @if($customer->company || $customer->notes)
                <div class="detail-card" data-aos="fade-up" data-aos-delay="300">
                    <h5 class="card-title">
                        <i class="fas fa-info-circle"></i>
                        Additional Information
                    </h5>
                    <div class="info-grid">
                        @if($customer->company)
                            <div class="info-item">
                                <span class="info-label">Company</span>
                                <span class="info-value">{{ $customer->company }}</span>
                            </div>
                        @endif
                        
                        @if($customer->notes)
                            <div class="info-item" style="grid-column: 1 / -1;">
                                <span class="info-label">Notes</span>
                                <div class="info-value" style="font-weight: normal; line-height: 1.5;">
                                    {{ $customer->notes }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Right Column - Stats & Actions -->
        <div class="col-lg-4">
            <!-- Customer Stats -->
            <div class="detail-card" data-aos="fade-up" data-aos-delay="400">
                <h5 class="card-title">
                    <i class="fas fa-chart-bar"></i>
                    Customer Statistics
                </h5>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Total Transactions</span>
                        <span class="info-value">{{ $customer->transactions_count ?? 0 }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Member For</span>
                        <span class="info-value">{{ $customer->created_at->diffForHumans(null, true) }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Last Updated</span>
                        <span class="info-value">{{ $customer->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Contact Preference</span>
                        <span class="info-value">
                            @if($customer->phone)
                                <i class="fab fa-whatsapp text-success"></i> WhatsApp
                            @else
                                <i class="fas fa-envelope text-primary"></i> Email
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Customer Timeline -->
            <div class="detail-card" data-aos="fade-up" data-aos-delay="500">
                <h5 class="card-title">
                    <i class="fas fa-history"></i>
                    Customer Timeline
                </h5>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-date">
                            {{ $customer->created_at->format('M j, Y g:i A') }}
                        </div>
                        <div class="timeline-content">
                            Customer account created
                        </div>
                    </div>
                    
                    @if($customer->created_at != $customer->updated_at)
                        <div class="timeline-item">
                            <div class="timeline-date">
                                {{ $customer->updated_at->format('M j, Y g:i A') }}
                            </div>
                            <div class="timeline-content">
                                Profile last updated
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="detail-card" data-aos="fade-up" data-aos-delay="600">
                <h5 class="card-title">
                    <i class="fas fa-bolt"></i>
                    Quick Actions
                </h5>
                <div class="action-buttons">
                    @if($customer->phone)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $customer->phone) }}" 
                           target="_blank" 
                           class="btn btn-success">
                            <i class="fab fa-whatsapp me-1"></i>WhatsApp
                        </a>
                    @endif
                    
                    <a href="mailto:{{ $customer->email }}" class="btn btn-primary">
                        <i class="fas fa-envelope me-1"></i>Email
                    </a>
                </div>
            </div>

            <!-- Management Actions -->
            <div class="detail-card" data-aos="fade-up" data-aos-delay="700">
                <h5 class="card-title">
                    <i class="fas fa-cog"></i>
                    Management Actions
                </h5>
                <div class="action-buttons">
                    <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i>Edit Customer
                    </a>
                    
                    <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Back to List
                    </a>

                    @if($customer->is_active)
                        <form action="{{ route('admin.customers.update', $customer) }}" method="POST" class="w-100">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="is_active" value="0">
                            <button type="submit" class="btn btn-warning w-100">
                                <i class="fas fa-pause me-1"></i>Deactivate
                            </button>
                        </form>
                    @else
                        <form action="{{ route('admin.customers.update', $customer) }}" method="POST" class="w-100">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="is_active" value="1">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-play me-1"></i>Activate
                            </button>
                        </form>
                    @endif

                    <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" class="w-100">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="btn btn-danger w-100" 
                                onclick="return confirm('Are you sure you want to delete this customer? This action cannot be undone.')">
                            <i class="fas fa-trash me-1"></i>Delete Customer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // WhatsApp confirmation
        const whatsappLinks = document.querySelectorAll('.whatsapp-link');
        whatsappLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.href;
                const customerName = '{{ $customer->name }}';
                
                Swal.fire({
                    title: 'Open WhatsApp?',
                    html: `You are about to start a conversation with <strong>${customerName}</strong> on WhatsApp.`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Open WhatsApp',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#25D366',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.open(url, '_blank');
                    }
                });
            });
        });

        // Initialize AOS animations
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 800,
                once: true,
                offset: 100
            });
        }

        // Copy email to clipboard
        const emailLinks = document.querySelectorAll('.email-link');
        emailLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                if (!e.ctrlKey && !e.metaKey) {
                    e.preventDefault();
                    const email = '{{ $customer->email }}';
                    
                    navigator.clipboard.writeText(email).then(() => {
                        Swal.fire({
                            title: 'Copied!',
                            text: 'Email address copied to clipboard',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false,
                            toast: true,
                            position: 'top-end'
                        });
                    });
                }
            });
        });
    });

    // Handle form submissions with loading states
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Processing...';
                submitBtn.disabled = true;
            }
        });
    });
</script>

<style>
    /* SweetAlert2 Custom Styles */
    .swal2-popup {
        border-radius: 16px;
        padding: 2rem;
    }

    /* Hover effects */
    .contact-link, .btn {
        position: relative;
        overflow: hidden;
    }

    .contact-link::before, .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s;
    }

    .contact-link:hover::before, .btn:hover::before {
        left: 100%;
    }
</style>
@endpush