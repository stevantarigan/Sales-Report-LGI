@extends('layouts.app')

@section('title', 'Transaction Details | SuperAdmin')
@section('page-title', 'Transaction Details')
@section('page-description', 'View detailed information about the transaction')

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
        .transaction-header {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
            border-left: 4px solid var(--primary-color);
        }

        .transaction-id {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .transaction-date {
            color: #64748b;
            font-size: 0.9rem;
        }

        /* Status Badges */
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .status-badge.completed {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .status-badge.pending {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning-color);
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        .status-badge.cancelled {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error-color);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .payment-badge.paid {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .payment-badge.pending {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning-color);
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        .payment-badge.cancelled {
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

        /* Price Section */
        .price-section {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 1rem;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .price-row:last-child {
            border-bottom: none;
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--primary-color);
        }

        /* Photo Section */
        .photo-container {
            text-align: center;
            margin-top: 1rem;
        }

        .transaction-photo {
            max-width: 100%;
            max-height: 400px;
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .no-photo {
            padding: 3rem;
            background: #f8fafc;
            border: 2px dashed #e2e8f0;
            border-radius: 12px;
            color: #64748b;
        }

        /* Map Section */
        .map-container {
            margin-top: 1rem;
            border-radius: 12px;
            overflow: hidden;
            border: 2px solid #e2e8f0;
        }

        .map-placeholder {
            padding: 3rem;
            background: #f8fafc;
            text-align: center;
            color: #64748b;
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

            .transaction-header {
                padding: 1.5rem;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Header Section -->
    <div class="transaction-header" data-aos="fade-up">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
            <div>
                <div class="transaction-id">
                    TRX-{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}
                </div>
                <div class="transaction-date">
                    Created on {{ $transaction->created_at->format('F j, Y \a\t g:i A') }}
                </div>
                @if ($transaction->created_at != $transaction->updated_at)
                    <div class="transaction-date">
                        Last updated on {{ $transaction->updated_at->format('F j, Y \a\t g:i A') }}
                    </div>
                @endif
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <span class="status-badge {{ $transaction->status }}">
                    {{ ucfirst($transaction->status) }}
                </span>
                <span class="payment-badge {{ $transaction->payment_status }}">
                    {{ ucfirst($transaction->payment_status) }}
                </span>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column - Transaction Details -->
        <div class="col-lg-8">
            <!-- Transaction Information -->
            <div class="detail-card" data-aos="fade-up" data-aos-delay="100">
                <h5 class="card-title">
                    <i class="fas fa-info-circle"></i>
                    Transaction Information
                </h5>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Sales Person</span>
                        <span class="info-value">{{ $transaction->user->name ?? 'N/A' }}</span>
                        <small class="text-muted">{{ $transaction->user->role ?? '' }}</small>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Customer</span>
                        <span class="info-value">{{ $transaction->customer->name ?? 'N/A' }}</span>
                        <small class="text-muted">{{ $transaction->customer->email ?? '' }}</small>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Product</span>
                        <span class="info-value">{{ $transaction->product->name ?? 'N/A' }}</span>
                        <small class="text-muted">SKU: {{ $transaction->product->sku ?? 'N/A' }}</small>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Transaction Date</span>
                        <span class="info-value">{{ $transaction->created_at->format('M j, Y') }}</span>
                        <small class="text-muted">{{ $transaction->created_at->format('g:i A') }}</small>
                    </div>
                </div>
            </div>

            <!-- Product & Pricing Details -->
            <div class="detail-card" data-aos="fade-up" data-aos-delay="200">
                <h5 class="card-title">
                    <i class="fas fa-shopping-cart"></i>
                    Product & Pricing Details
                </h5>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Product Name</span>
                        <span class="info-value">{{ $transaction->product->name ?? 'N/A' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Category</span>
                        <span class="info-value">{{ $transaction->product->category ?? 'N/A' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Quantity</span>
                        <span class="info-value">{{ $transaction->quantity }} units</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Unit Price</span>
                        <span class="info-value">Rp {{ number_format($transaction->price, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Price Calculation -->
                <div class="price-section">
                    <div class="price-row">
                        <span>Quantity × Unit Price:</span>
                        <span>{{ $transaction->quantity }} × Rp
                            {{ number_format($transaction->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="price-row">
                        <span>Total Amount:</span>
                        <span>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Location Information -->
            @if ($transaction->latitude && $transaction->longitude)
                <div class="detail-card" data-aos="fade-up" data-aos-delay="300">
                    <h5 class="card-title">
                        <i class="fas fa-map-marker-alt"></i>
                        Location Information
                    </h5>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Latitude</span>
                            <span class="info-value">{{ $transaction->latitude }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Longitude</span>
                            <span class="info-value">{{ $transaction->longitude }}</span>
                        </div>
                    </div>
                    @if ($transaction->map_link)
                        <div class="map-container">
                            <iframe
                                src="https://maps.google.com/maps?q={{ $transaction->latitude }},{{ $transaction->longitude }}&z=15&output=embed"
                                width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy">
                            </iframe>
                        </div>
                        <div class="mt-2 text-center">
                            <a href="{{ $transaction->map_link }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-external-link-alt me-1"></i>Open in Google Maps
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Right Column - Photos & Actions -->
        <div class="col-lg-4">
            <!-- Transaction Photo -->
            <div class="detail-card" data-aos="fade-up" data-aos-delay="400">
                <h5 class="card-title">
                    <i class="fas fa-camera"></i>
                    Transaction Photo
                </h5>
                <div class="photo-container">
                    @if ($transaction->photo)
                        <img src="{{ Storage::url($transaction->photo) }}" alt="Transaction Photo"
                            class="transaction-photo" onclick="openPhotoModal('{{ Storage::url($transaction->photo) }}')"
                            style="cursor: pointer;">
                        <div class="mt-2">
                            <small class="text-muted">Click to enlarge</small>
                        </div>
                    @else
                        <div class="no-photo">
                            <i class="fas fa-camera fa-3x mb-3"></i>
                            <p>No photo available</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Transaction Timeline -->
            <div class="detail-card" data-aos="fade-up" data-aos-delay="500">
                <h5 class="card-title">
                    <i class="fas fa-history"></i>
                    Transaction Timeline
                </h5>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-date">
                            {{ $transaction->created_at->format('M j, Y g:i A') }}
                        </div>
                        <div class="timeline-content">
                            Transaction created
                        </div>
                    </div>
                    @if ($transaction->created_at != $transaction->updated_at)
                        <div class="timeline-item">
                            <div class="timeline-date">
                                {{ $transaction->updated_at->format('M j, Y g:i A') }}
                            </div>
                            <div class="timeline-content">
                                Last updated
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="detail-card" data-aos="fade-up" data-aos-delay="600">
                <h5 class="card-title">
                    <i class="fas fa-cog"></i>
                    Actions
                </h5>
                <div class="action-buttons">
                    <a href="{{ route('admin.transactions.edit', $transaction) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i>Edit Transaction
                    </a>
                    <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Back to List
                    </a>
                    @if ($transaction->status == 'pending')
                        <form action="{{ route('admin.transactions.update', $transaction) }}" method="POST"
                            class="w-100">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-check me-1"></i>Mark as Completed
                            </button>
                        </form>
                    @endif

                    @if ($transaction->payment_status == 'pending')
                        <form action="{{ route('admin.transactions.update', $transaction) }}" method="POST"
                            class="w-100">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="payment_status" value="paid">
                            <button type="submit" class="btn btn-warning w-100">
                                <i class="fas fa-dollar-sign me-1"></i>Mark as Paid
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Photo Modal -->
    <div class="modal fade" id="photoModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Transaction Photo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalPhoto" src="" alt="Transaction Photo"
                        style="max-width: 100%; max-height: 70vh;">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function openPhotoModal(photoUrl) {
            document.getElementById('modalPhoto').src = photoUrl;
            new bootstrap.Modal(document.getElementById('photoModal')).show();
        }

        // Initialize AOS animations
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 800,
                    once: true,
                    offset: 100
                });
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
    </script>
@endpush
