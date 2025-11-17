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

@section('title', 'Transaction Details | ' . ucfirst(auth()->user()->role))
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
            position: relative;
            overflow: hidden;
        }

        .transaction-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 150px;
            height: 150px;
            background: var(--gradient-primary);
            opacity: 0.05;
            border-radius: 50%;
            transform: translate(50%, -50%);
        }

        .transaction-id {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .transaction-id i {
            color: var(--primary-color);
        }

        .transaction-date {
            color: #64748b;
            font-size: 0.95rem;
        }

        /* Modern Badge Styles - PERBAIKAN untuk @ Paid yang jelek */
        .status-pill,
        .payment-pill {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.7rem 1.2rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
            backdrop-filter: blur(10px);
            border: 1px solid;
            transition: var(--transition);
        }

        .status-pill.completed {
            background: rgba(16, 185, 129, 0.15);
            color: var(--success-color);
            border-color: rgba(16, 185, 129, 0.3);
        }

        .status-pill.pending {
            background: rgba(245, 158, 11, 0.15);
            color: var(--warning-color);
            border-color: rgba(245, 158, 11, 0.3);
        }

        .status-pill.cancelled {
            background: rgba(239, 68, 68, 0.15);
            color: var(--error-color);
            border-color: rgba(239, 68, 68, 0.3);
        }

        .payment-pill.paid {
            background: rgba(139, 92, 246, 0.15);
            color: #8B5CF6;
            border-color: rgba(139, 92, 246, 0.3);
        }

        .payment-pill.pending {
            background: rgba(245, 158, 11, 0.15);
            color: var(--warning-color);
            border-color: rgba(245, 158, 11, 0.3);
        }

        .payment-pill.cancelled {
            background: rgba(239, 68, 68, 0.15);
            color: var(--error-color);
            border-color: rgba(239, 68, 68, 0.3);
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        .status-pill.completed .status-dot {
            background: var(--success-color);
            box-shadow: 0 0 0 rgba(16, 185, 129, 0.4);
        }

        .status-pill.pending .status-dot {
            background: var(--warning-color);
            box-shadow: 0 0 0 rgba(245, 158, 11, 0.4);
        }

        .payment-icon {
            font-size: 0.9rem;
        }

        /* Modern Badge Alternatif */
        .modern-badge {
            padding: 0.8rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            backdrop-filter: blur(10px);
            border: 2px solid transparent;
            background: linear-gradient(135deg, white, #f8fafc);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: var(--transition);
        }

        .modern-badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .modern-badge.status-completed {
            color: var(--success-color);
            border-color: rgba(16, 185, 129, 0.3);
        }

        .modern-badge.status-pending {
            color: var(--warning-color);
            border-color: rgba(245, 158, 11, 0.3);
        }

        .modern-badge.payment-paid {
            color: #8B5CF6;
            border-color: rgba(139, 92, 246, 0.3);
        }

        .modern-badge.payment-pending {
            color: var(--warning-color);
            border-color: rgba(245, 158, 11, 0.3);
        }

        /* Animasi */
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4);
            }

            70% {
                box-shadow: 0 0 0 6px rgba(16, 185, 129, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }

        /* Cards */
        .detail-card {
            background: white;
            border-radius: 16px;
            padding: 1.8rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            border: 1px solid #f1f5f9;
        }

        .detail-card:hover {
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #f1f5f9;
        }

        .card-title i {
            color: var(--primary-color);
            font-size: 1.1rem;
        }

        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 12px;
            border-left: 4px solid var(--primary-color);
        }

        .info-label {
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            font-size: 1.1rem;
            color: var(--dark-color);
            font-weight: 700;
        }

        .info-subtext {
            font-size: 0.85rem;
            color: #94a3b8;
        }

        /* Products Table */
        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .products-table th {
            background: var(--gradient-primary);
            color: white;
            padding: 1.2rem 1rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .products-table td {
            padding: 1.2rem 1rem;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .products-table tbody tr {
            transition: var(--transition);
        }

        .products-table tbody tr:hover {
            background: #f8fafc;
            transform: scale(1.01);
        }

        .products-table tbody tr:last-child td {
            border-bottom: none;
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .product-avatar {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .product-details {
            flex: 1;
        }

        .product-name {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.25rem;
            font-size: 1rem;
        }

        .product-sku {
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 500;
        }

        .quantity-badge {
            background: rgba(79, 70, 229, 0.1);
            color: var(--primary-color);
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .price {
            font-weight: 700;
            color: var(--dark-color);
            font-size: 1rem;
        }

        .subtotal {
            font-weight: 700;
            color: var(--success-color);
            font-size: 1.1rem;
        }

        .table-total {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            font-weight: 700;
        }

        .table-total td {
            padding: 1.5rem 1rem;
            font-size: 1.2rem;
            color: var(--dark-color);
            border-top: 2px solid #e2e8f0;
        }

        /* Price Section */
        .price-section {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 1.5rem;
            border: 1px solid #e2e8f0;
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
            font-size: 1.3rem;
            color: var(--primary-color);
            padding-top: 1rem;
            margin-top: 0.5rem;
            border-top: 2px solid rgba(79, 70, 229, 0.1);
        }

        /* Photo Section */
        .photo-container {
            text-align: center;
            margin-top: 1rem;
        }

        .transaction-photo {
            max-width: 100%;
            max-height: 300px;
            border-radius: 16px;
            border: 2px solid #e2e8f0;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: var(--transition);
        }

        .transaction-photo:hover {
            transform: scale(1.02);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
        }

        .no-photo {
            padding: 3rem 2rem;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: 2px dashed #e2e8f0;
            border-radius: 16px;
            color: #64748b;
            text-align: center;
        }

        .no-photo i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        /* Map Section */
        .map-container {
            margin-top: 1rem;
            border-radius: 16px;
            overflow: hidden;
            border: 2px solid #e2e8f0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .map-placeholder {
            padding: 3rem 2rem;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
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
            padding: 0.9rem 1.8rem;
            border-radius: 12px;
            font-weight: 600;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.95rem;
            flex: 1;
            min-width: 160px;
            justify-content: center;
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

        .btn-success {
            background: var(--gradient-success);
            color: white;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        }

        .btn-warning {
            background: var(--gradient-warning);
            color: white;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }

        .btn-warning:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
        }

        .btn-danger {
            background: var(--gradient-danger);
            color: white;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        .btn-danger:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
        }

        /* Timeline */
        .timeline {
            position: relative;
            padding-left: 2.5rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 1rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, var(--primary-color), #e2e8f0);
        }

        .timeline-item {
            position: relative;
            margin-bottom: 2rem;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -2.5rem;
            top: 0.25rem;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--primary-color);
            border: 4px solid white;
            box-shadow: 0 0 0 2px var(--primary-color);
        }

        .timeline-date {
            font-size: 0.85rem;
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .timeline-content {
            font-size: 0.95rem;
            color: var(--dark-color);
            background: #f8fafc;
            padding: 1rem;
            border-radius: 8px;
            border-left: 3px solid var(--primary-color);
        }

        /* Stats Cards */
        .stats-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: var(--card-shadow);
            border: 1px solid #f1f5f9;
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
            color: white;
        }

        .stats-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .stats-label {
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 500;
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
                min-width: auto;
            }

            .transaction-header {
                padding: 1.5rem;
            }

            .products-table {
                font-size: 0.8rem;
            }

            .products-table th,
            .products-table td {
                padding: 0.8rem 0.5rem;
            }

            .product-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .product-avatar {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .transaction-id {
                font-size: 1.4rem;
            }

            .detail-card {
                padding: 1.2rem;
            }

            .card-title {
                font-size: 1.1rem;
            }
        }

        /* Payment Button Styles */
        .btn-payment {
            background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);
            color: white;
            border: none;
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-payment:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(139, 92, 246, 0.4);
            background: linear-gradient(135deg, #7C3AED 0%, #6D28D9 100%);
        }

        .btn-payment::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-payment:hover::before {
            left: 100%;
        }

        /* Status Indicators */
        .status-indicator,
        .payment-indicator {
            padding: 0.9rem 1.8rem;
            border-radius: 12px;
            font-weight: 600;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            font-size: 0.95rem;
            border: 2px solid;
        }

        .status-indicator.completed {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
            border-color: rgba(16, 185, 129, 0.2);
        }

        .status-indicator.cancelled {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error-color);
            border-color: rgba(239, 68, 68, 0.2);
        }

        .payment-indicator.paid {
            background: rgba(139, 92, 246, 0.1);
            color: #8B5CF6;
            border-color: rgba(139, 92, 246, 0.2);
        }

        .payment-indicator.cancelled {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error-color);
            border-color: rgba(239, 68, 68, 0.2);
        }

        /* Action Button Animations */
        .status-action-btn,
        .payment-action-btn,
        .delete-btn {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .status-action-btn::after,
        .payment-action-btn::after,
        .delete-btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.3s, height 0.3s;
        }

        .status-action-btn:active::after,
        .payment-action-btn:active::after,
        .delete-btn:active::after {
            width: 100px;
            height: 100px;
        }

        /* Button Icons Animation */
        .btn i {
            transition: transform 0.3s ease;
        }

        .btn:hover i {
            transform: scale(1.1);
        }

        /* Specific button improvements */
        .btn-success {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
        }

        .btn-warning {
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #D97706 0%, #B45309 100%);
        }

        .btn-danger {
            background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #DC2626 0%, #B91C1C 100%);
        }

        /* Responsive adjustments for action buttons */
        @media (max-width: 768px) {

            .status-indicator,
            .payment-indicator {
                padding: 0.8rem 1rem;
                font-size: 0.9rem;
            }

            .btn-payment {
                font-size: 0.9rem;
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
                    <i class="fas fa-receipt"></i>
                    TRX-{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}
                </div>
                <div class="transaction-date">
                    <i class="fas fa-calendar me-1"></i>
                    Created on {{ $transaction->created_at->format('F j, Y \a\t g:i A') }}
                </div>
                @if ($transaction->created_at != $transaction->updated_at)
                    <div class="transaction-date">
                        <i class="fas fa-sync-alt me-1"></i>
                        Last updated on {{ $transaction->updated_at->format('F j, Y \a\t g:i A') }}
                    </div>
                @endif
            </div>
            <div class="d-flex gap-3 flex-wrap">
                <div class="modern-badge status-{{ $transaction->status }}">
                    <i
                        class="fas fa-{{ $transaction->status == 'completed' ? 'check' : ($transaction->status == 'pending' ? 'clock' : 'times') }} me-2"></i>
                    <strong>{{ ucfirst($transaction->status) }}</strong>
                </div>
                <div class="modern-badge payment-{{ $transaction->payment_status }}">
                    <i
                        class="fas fa-{{ $transaction->payment_status == 'paid' ? 'credit-card' : ($transaction->payment_status == 'pending' ? 'hourglass-half' : 'ban') }} me-2"></i>
                    <strong>{{ ucfirst($transaction->payment_status) }}</strong>
                </div>
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
                        <span class="info-subtext">{{ $transaction->user->role ?? '' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Customer</span>
                        <span class="info-value">{{ $transaction->customer->name ?? 'N/A' }}</span>
                        <span class="info-subtext">{{ $transaction->customer->email ?? '' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Total Products</span>
                        <span class="info-value">{{ $transaction->getAllProducts()->count() }} items</span>
                        <span class="info-subtext">{{ $transaction->getTotalQuantityAttribute() }} total units</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Transaction Date</span>
                        <span class="info-value">{{ $transaction->created_at->format('M j, Y') }}</span>
                        <span class="info-subtext">{{ $transaction->created_at->format('g:i A') }}</span>
                    </div>
                </div>
            </div>

            <!-- Products Details -->
            <div class="detail-card" data-aos="fade-up" data-aos-delay="200">
                <h5 class="card-title">
                    <i class="fas fa-boxes"></i>
                    Products Details
                    <span class="badge bg-primary ms-2">{{ $transaction->getAllProducts()->count() }} products</span>
                </h5>

                <div class="table-responsive">
                    <table class="products-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $products = $transaction->getAllProducts();
                                $totalQuantity = 0;
                                $totalPrice = 0;
                            @endphp

                            @foreach ($products as $productItem)
                                @php
                                    $product = \App\Models\Product::find($productItem->product_id);
                                    $totalQuantity += $productItem->quantity;
                                    $totalPrice += $productItem->subtotal;
                                @endphp
                                <tr>
                                    <td>
                                        <div class="product-info">
                                            <div class="product-avatar">
                                                <i
                                                    class="fas fa-{{ $product->category == 'Electronics' ? 'mobile-alt' : ($product->category == 'Fashion' ? 'tshirt' : 'cube') }}"></i>
                                            </div>
                                            <div class="product-details">
                                                <div class="product-name">
                                                    {{ $product->name ?? 'Product Not Found' }}
                                                </div>
                                                @if ($product)
                                                    <div class="product-sku">
                                                        SKU: {{ $product->sku }} | Category: {{ $product->category }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="quantity-badge">
                                            <i class="fas fa-layer-group"></i>
                                            {{ $productItem->quantity }} pcs
                                        </span>
                                    </td>
                                    <td>
                                        <span class="price">Rp
                                            {{ number_format($productItem->price, 0, ',', '.') }}</span>
                                    </td>
                                    <td>
                                        <span class="subtotal">Rp
                                            {{ number_format($productItem->subtotal, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-total">
                                <td colspan="3" class="text-end">
                                    <strong>Total:</strong>
                                </td>
                                <td>
                                    <strong>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</strong>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Summary Stats -->
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="stats-card">
                            <div class="stats-icon" style="background: var(--gradient-primary);">
                                <i class="fas fa-box"></i>
                            </div>
                            <div class="stats-value">{{ $products->count() }}</div>
                            <div class="stats-label">Total Products</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stats-card">
                            <div class="stats-icon" style="background: var(--gradient-success);">
                                <i class="fas fa-layer-group"></i>
                            </div>
                            <div class="stats-value">{{ $totalQuantity }}</div>
                            <div class="stats-label">Total Quantity</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stats-card">
                            <div class="stats-icon" style="background: var(--gradient-warning);">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div class="stats-value">Rp {{ number_format($totalPrice, 0, ',', '.') }}</div>
                            <div class="stats-label">Total Amount</div>
                        </div>
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
                        <div class="mt-3 text-center">
                            <a href="{{ $transaction->map_link }}" target="_blank" class="btn btn-outline-primary">
                                <i class="fas fa-external-link-alt me-2"></i>Open in Google Maps
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
                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="fas fa-expand me-1"></i>Click to enlarge
                            </small>
                        </div>
                    @else
                        <div class="no-photo">
                            <i class="fas fa-camera"></i>
                            <p class="mb-0 mt-2">No photo available</p>
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
                            <i class="fas fa-plus-circle me-1 text-success"></i>
                            Transaction created successfully
                        </div>
                    </div>
                    @if ($transaction->created_at != $transaction->updated_at)
                        <div class="timeline-item">
                            <div class="timeline-date">
                                {{ $transaction->updated_at->format('M j, Y g:i A') }}
                            </div>
                            <div class="timeline-content">
                                <i class="fas fa-edit me-1 text-primary"></i>
                                Transaction information updated
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
                    <a href="{{ route('admin.transactions.edit', $transaction) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit Transaction
                    </a>
                    <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
                    </a>

                    <!-- Status Actions -->
                    @if ($transaction->status == 'pending')
                        <form action="{{ route('admin.transactions.update', $transaction) }}" method="POST"
                            class="w-100">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" class="btn btn-success w-100 status-action-btn">
                                <i class="fas fa-check-circle me-2"></i>Complete Order
                            </button>
                        </form>
                    @elseif ($transaction->status == 'completed')
                        <div class="status-indicator completed w-100">
                            <i class="fas fa-check-circle me-2"></i>Order Completed
                        </div>
                    @else
                        <div class="status-indicator cancelled w-100">
                            <i class="fas fa-times-circle me-2"></i>Order Cancelled
                        </div>
                    @endif

                    <!-- Payment Actions -->
                    @if ($transaction->payment_status == 'pending')
                        <form action="{{ route('admin.transactions.update', $transaction) }}" method="POST"
                            class="w-100">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="payment_status" value="paid">
                            <button type="submit" class="btn btn-payment w-100 payment-action-btn">
                                <i class="fas fa-credit-card me-2"></i>Mark as Paid
                            </button>
                        </form>
                    @elseif ($transaction->payment_status == 'paid')
                        <div class="payment-indicator paid w-100">
                            <i class="fas fa-check-circle me-2"></i>Payment Received
                        </div>
                    @else
                        <div class="payment-indicator cancelled w-100">
                            <i class="fas fa-times-circle me-2"></i>Payment Cancelled
                        </div>
                    @endif

                    <!-- Delete Button -->
                    <form action="{{ route('admin.transactions.destroy', $transaction) }}" method="POST"
                        class="w-100">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100 delete-btn"
                            onclick="return confirm('Are you sure you want to delete this transaction? This action cannot be undone.')">
                            <i class="fas fa-trash me-2"></i>Delete Transaction
                        </button>
                    </form>
                </div>
            </div>

            <!-- Photo Modal -->
            <div class="modal fade" id="photoModal" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="fas fa-camera me-2"></i>
                                Transaction Photo
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img id="modalPhoto" src="" alt="Transaction Photo"
                                style="max-width: 100%; max-height: 70vh; border-radius: 8px;">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Close
                            </button>
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
