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

@section('title', 'Edit Transaction | ' . ucfirst(auth()->user()->role))
@section('page-title', 'Edit Transaction')
@section('page-description', 'Edit transaksi penjualan')


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

        .form-container {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: var(--card-shadow);
            margin-bottom: 2rem;
            border-left: 4px solid var(--primary-color);
            position: relative;
            overflow: hidden;
        }

        .form-container::before {
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

        .form-section {
            margin-bottom: 2.5rem;
            padding: 1.5rem;
            background: #f8fafc;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-title i {
            color: var(--primary-color);
            font-size: 1.1rem;
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
            font-size: 0.9rem;
        }

        .form-control,
        .form-select {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.75rem;
            width: 100%;
            transition: var(--transition);
            font-size: 0.9rem;
            background: white;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            outline: none;
            transform: translateY(-1px);
        }

        .form-text {
            font-size: 0.8rem;
            color: #64748b;
            margin-top: 0.25rem;
        }

        .readonly-field {
            background-color: #f8fafc;
            color: #64748b;
            cursor: not-allowed;
            border: 1px solid #e2e8f0;
        }

        /* Products Section Styles */
        .products-section {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
        }

        .product-item {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: var(--transition);
            position: relative;
        }

        .product-item:hover {
            border-color: var(--primary-color);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .product-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .product-number {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 1rem;
        }

        .remove-product {
            background: var(--gradient-danger);
            color: white;
            border: none;
            border-radius: 6px;
            padding: 0.5rem 0.75rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8rem;
        }

        .remove-product:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .add-product-btn {
            background: var(--gradient-success);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            margin-top: 1rem;
        }

        .add-product-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        /* Price Calculator */
        .price-calculator {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 1.5rem;
        }

        .calculation-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e2e8f0;
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

        .calculation-label {
            color: #64748b;
            font-weight: 500;
        }

        .calculation-value {
            font-weight: 600;
            color: var(--dark-color);
        }

        /* Status Badges */
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

        /* Photo Preview */
        .photo-preview {
            margin-top: 1rem;
            text-align: center;
        }

        .photo-preview img {
            max-width: 200px;
            max-height: 200px;
            border-radius: 8px;
            border: 2px solid #e2e8f0;
            transition: var(--transition);
        }

        .photo-preview img:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        /* Map Preview */
        .map-preview {
            margin-top: 1rem;
            height: 200px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            transition: var(--transition);
            cursor: pointer;
        }

        .map-preview.has-coordinates {
            background: #e0f2fe;
            color: var(--info-color);
            border-color: var(--info-color);
        }

        .map-preview.has-coordinates:hover {
            background: #bae6fd;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(6, 182, 212, 0.2);
        }

        /* Buttons */
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

        .btn-outline-secondary {
            background: transparent;
            color: #64748b;
            border: 1px solid #64748b;
        }

        .btn-outline-secondary:hover {
            background: #64748b;
            color: white;
            transform: translateY(-2px);
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e2e8f0;
        }

        /* Transaction Info */
        .transaction-info {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border: 1px solid #bae6fd;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 0.8rem;
            color: #64748b;
            margin-bottom: 0.25rem;
            font-weight: 500;
        }

        .info-value {
            font-weight: 600;
            color: var(--dark-color);
            font-size: 1rem;
        }

        .error-message {
            color: var(--error-color);
            font-size: 0.8rem;
            margin-top: 0.25rem;
            font-weight: 500;
        }

        .is-invalid {
            border-color: var(--error-color) !important;
            box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.1) !important;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .product-header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }

            .form-container {
                padding: 1.5rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="form-container" data-aos="fade-up">
        <!-- Transaction Info -->
        <div class="transaction-info">
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Transaction ID</span>
                    <span class="info-value">TRX-{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Created By</span>
                    <span class="info-value">{{ $transaction->user->name ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Created Date</span>
                    <span class="info-value">{{ $transaction->created_at->format('M j, Y H:i') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Last Updated</span>
                    <span class="info-value">{{ $transaction->updated_at->format('M j, Y H:i') }}</span>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.transactions.update', $transaction) }}" method="POST" enctype="multipart/form-data"
            id="editTransactionForm">
            @csrf
            @method('PUT')

            <!-- Basic Information Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-info-circle"></i>
                    Basic Information
                </h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="user_id" class="form-label">Sales Person *</label>
                        <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror"
                            required>
                            <option value="">Select Sales Person</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('user_id', $transaction->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="customer_id" class="form-label">Customer *</label>
                        <select name="customer_id" id="customer_id"
                            class="form-select @error('customer_id') is-invalid @enderror" required>
                            <option value="">Select Customer</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    {{ old('customer_id', $transaction->customer_id) == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }} ({{ $customer->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Products Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-boxes"></i>
                    Products Details
                    <span class="badge bg-primary ms-2" id="productsCount">1 product</span>
                </h3>

                <div class="products-section">
                    <div id="productsContainer">
                        <!-- Existing products will be loaded here -->
                        @php
                            $productsData = $transaction->getAllProducts();
                        @endphp

                        @foreach ($productsData as $index => $productItem)
                            <div class="product-item" data-index="{{ $index }}">
                                <div class="product-header">
                                    <span class="product-number">Product #{{ $index + 1 }}</span>
                                    @if ($index > 0)
                                        <button type="button" class="remove-product" onclick="removeProduct(this)">
                                            <i class="fas fa-times"></i>
                                            Remove
                                        </button>
                                    @endif
                                </div>
                                <div class="form-grid">
                                    <div class="form-group">
                                        <label for="products[{{ $index }}][product_id]" class="form-label">Product
                                            *</label>
                                        <select name="products[{{ $index }}][product_id]"
                                            class="form-select product-select" onchange="updatePrice(this)" required>
                                            <option value="">Select Product</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                                    {{ $productItem->product_id == $product->id ? 'selected' : '' }}>
                                                    {{ $product->name }} - Rp
                                                    {{ number_format($product->price, 0, ',', '.') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="products[{{ $index }}][quantity]" class="form-label">Quantity
                                            *</label>
                                        <input type="number" name="products[{{ $index }}][quantity]"
                                            class="form-control quantity-input" value="{{ $productItem->quantity }}"
                                            min="1" oninput="calculateTotal()" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="products[{{ $index }}][price]" class="form-label">Price per Unit
                                            *</label>
                                        <input type="number" name="products[{{ $index }}][price]"
                                            class="form-control price-input" value="{{ $productItem->price }}"
                                            min="0" step="0.01" oninput="calculateTotal()" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Subtotal</label>
                                        <input type="text" class="form-control readonly-field subtotal-display"
                                            value="Rp {{ number_format($productItem->subtotal, 0, ',', '.') }}" readonly>
                                        <input type="hidden" class="subtotal-value" value="{{ $productItem->subtotal }}">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" class="add-product-btn" onclick="addProduct()">
                        <i class="fas fa-plus"></i>
                        Add Another Product
                    </button>
                </div>

                <!-- Price Calculator -->
                <div class="price-calculator">
                    <div class="calculation-row">
                        <span class="calculation-label">Total Products:</span>
                        <span class="calculation-value" id="totalProducts">{{ $productsData->count() }} items</span>
                    </div>
                    <div class="calculation-row">
                        <span class="calculation-label">Total Quantity:</span>
                        <span class="calculation-value"
                            id="totalQuantity">{{ $transaction->getTotalQuantityAttribute() }} units</span>
                    </div>
                    <div class="calculation-row">
                        <span class="calculation-label">Total Amount:</span>
                        <span class="calculation-value" id="grandTotal">Rp
                            {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                    </div>
                    <input type="hidden" name="total_price" id="total_price_hidden"
                        value="{{ $transaction->total_price }}">
                </div>
            </div>

            <!-- Status Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-cog"></i>
                    Status & Payment
                </h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="status" class="form-label">Transaction Status *</label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror"
                            required>
                            <option value="pending"
                                {{ old('status', $transaction->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed"
                                {{ old('status', $transaction->status) == 'completed' ? 'selected' : '' }}>Completed
                            </option>
                            <option value="cancelled"
                                {{ old('status', $transaction->status) == 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </select>
                        @error('status')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="payment_status" class="form-label">Payment Status *</label>
                        <select name="payment_status" id="payment_status"
                            class="form-select @error('payment_status') is-invalid @enderror" required>
                            <option value="pending"
                                {{ old('payment_status', $transaction->payment_status) == 'pending' ? 'selected' : '' }}>
                                Pending</option>
                            <option value="paid"
                                {{ old('payment_status', $transaction->payment_status) == 'paid' ? 'selected' : '' }}>Paid
                            </option>
                            <option value="cancelled"
                                {{ old('payment_status', $transaction->payment_status) == 'cancelled' ? 'selected' : '' }}>
                                Cancelled</option>
                        </select>
                        @error('payment_status')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Additional Information Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-map-marker-alt"></i>
                    Additional Information
                </h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="latitude" class="form-label">Latitude</label>
                        <input type="number" name="latitude" id="latitude"
                            class="form-control @error('latitude') is-invalid @enderror"
                            value="{{ old('latitude', $transaction->latitude) }}" step="any"
                            placeholder="e.g., -6.2088">
                        @error('latitude')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="longitude" class="form-label">Longitude</label>
                        <input type="number" name="longitude" id="longitude"
                            class="form-control @error('longitude') is-invalid @enderror"
                            value="{{ old('longitude', $transaction->longitude) }}" step="any"
                            placeholder="e.g., 106.8456">
                        @error('longitude')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="photo" class="form-label">Transaction Photo</label>
                        <input type="file" name="photo" id="photo"
                            class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                        @error('photo')
                            <div class="error-message">{{ $message }}</div>
                        @enderror

                        @if ($transaction->photo)
                            <div class="photo-preview">
                                <p class="form-text">Current Photo:</p>
                                <img src="{{ Storage::url($transaction->photo) }}" alt="Transaction Photo"
                                    onerror="this.style.display='none'">
                                <p class="form-text">Upload new photo to replace current one</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Map Preview -->
                @if ($transaction->latitude && $transaction->longitude)
                    <div class="form-group">
                        <label class="form-label">Location Map</label>
                        <div class="map-preview has-coordinates"
                            onclick="window.open('{{ $transaction->map_link }}', '_blank')">
                            <i class="fas fa-map-marked-alt fa-2x me-2"></i>
                            <span>View on Google Maps</span>
                        </div>
                    </div>
                @else
                    <div class="form-group">
                        <label class="form-label">Location Map</label>
                        <div class="map-preview">
                            <i class="fas fa-map fa-2x me-2"></i>
                            <span>No coordinates available</span>
                        </div>
                    </div>
                @endif

                <div class="form-group">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="3"
                        placeholder="Additional notes about this transaction...">{{ old('notes', $transaction->notes) }}</textarea>
                    @error('notes')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('admin.transactions.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
                <button type="button" class="btn btn-secondary" onclick="resetForm()">
                    <i class="fas fa-undo me-2"></i>Reset
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update Transaction
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        let productIndex = {{ $productsData->count() }};

        document.addEventListener('DOMContentLoaded', function() {
            updateProductsCount();
            calculateTotal();
        });

        function addProduct() {
            const productsContainer = document.getElementById('productsContainer');
            const newProductHtml = `
                <div class="product-item" data-index="${productIndex}">
                    <div class="product-header">
                        <span class="product-number">Product #${productIndex + 1}</span>
                        <button type="button" class="remove-product" onclick="removeProduct(this)">
                            <i class="fas fa-times"></i>
                            Remove
                        </button>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="products[${productIndex}][product_id]" class="form-label">Product *</label>
                            <select name="products[${productIndex}][product_id]" 
                                    class="form-select product-select" 
                                    onchange="updatePrice(this)" required>
                                <option value="">Select Product</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                        {{ $product->name }} - Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="products[${productIndex}][quantity]" class="form-label">Quantity *</label>
                            <input type="number" name="products[${productIndex}][quantity]" 
                                   class="form-control quantity-input" 
                                   value="1" min="1" oninput="calculateTotal()" required>
                        </div>
                        <div class="form-group">
                            <label for="products[${productIndex}][price]" class="form-label">Price per Unit *</label>
                            <input type="number" name="products[${productIndex}][price]" 
                                   class="form-control price-input" 
                                   value="0" min="0" step="0.01" oninput="calculateTotal()" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Subtotal</label>
                            <input type="text" class="form-control readonly-field subtotal-display" 
                                   value="Rp 0" readonly>
                            <input type="hidden" class="subtotal-value" value="0">
                        </div>
                    </div>
                </div>
            `;

            productsContainer.insertAdjacentHTML('beforeend', newProductHtml);
            productIndex++;
            updateProductsCount();
            calculateTotal();
        }

        function removeProduct(button) {
            const productItem = button.closest('.product-item');
            productItem.remove();
            updateProductsCount();
            calculateTotal();
        }

        function updatePrice(selectElement) {
            const price = selectElement.options[selectElement.selectedIndex].getAttribute('data-price');
            const productItem = selectElement.closest('.product-item');
            const priceInput = productItem.querySelector('.price-input');

            if (price) {
                priceInput.value = price;
                calculateTotal();
            }
        }

        function calculateTotal() {
            let totalProducts = 0;
            let totalQuantity = 0;
            let grandTotal = 0;

            document.querySelectorAll('.product-item').forEach((productItem, index) => {
                const quantity = parseInt(productItem.querySelector('.quantity-input').value) || 0;
                const price = parseFloat(productItem.querySelector('.price-input').value) || 0;
                const subtotal = quantity * price;

                // Update subtotal display
                productItem.querySelector('.subtotal-display').value = 'Rp ' + formatNumber(subtotal);
                productItem.querySelector('.subtotal-value').value = subtotal;

                totalProducts++;
                totalQuantity += quantity;
                grandTotal += subtotal;
            });

            // Update summary
            document.getElementById('totalProducts').textContent = totalProducts + ' items';
            document.getElementById('totalQuantity').textContent = totalQuantity + ' units';
            document.getElementById('grandTotal').textContent = 'Rp ' + formatNumber(grandTotal);
            document.getElementById('total_price_hidden').value = grandTotal;
        }

        function formatNumber(number) {
            return number.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function updateProductsCount() {
            const count = document.querySelectorAll('.product-item').length;
            document.getElementById('productsCount').textContent = count + ' product' + (count !== 1 ? 's' : '');
        }

        function resetForm() {
            if (confirm('Are you sure you want to reset the form? All changes will be lost.')) {
                document.getElementById('editTransactionForm').reset();
                // Reset to initial products
                const productsContainer = document.getElementById('productsContainer');
                const initialProducts = productsContainer.querySelectorAll('.product-item');

                // Remove extra products
                for (let i = 1; i < initialProducts.length; i++) {
                    initialProducts[i].remove();
                }

                productIndex = 1;
                updateProductsCount();
                calculateTotal();
            }
        }

        // Form submission handler
        document.getElementById('editTransactionForm').addEventListener('submit', function(e) {
            let hasErrors = false;

            // Validate products
            document.querySelectorAll('.product-item').forEach((productItem, index) => {
                const quantity = parseInt(productItem.querySelector('.quantity-input').value);
                const price = parseFloat(productItem.querySelector('.price-input').value);
                const productSelect = productItem.querySelector('.product-select');

                if (!productSelect.value) {
                    hasErrors = true;
                    productSelect.classList.add('is-invalid');
                } else {
                    productSelect.classList.remove('is-invalid');
                }

                if (quantity <= 0) {
                    hasErrors = true;
                    productItem.querySelector('.quantity-input').classList.add('is-invalid');
                } else {
                    productItem.querySelector('.quantity-input').classList.remove('is-invalid');
                }

                if (price <= 0) {
                    hasErrors = true;
                    productItem.querySelector('.price-input').classList.add('is-invalid');
                } else {
                    productItem.querySelector('.price-input').classList.remove('is-invalid');
                }
            });

            if (hasErrors) {
                e.preventDefault();
                alert(
                    'Please check all product fields. Quantity and Price must be greater than 0, and all products must be selected.');
                return;
            }

            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
            submitBtn.disabled = true;
        });
    </script>
@endpush
