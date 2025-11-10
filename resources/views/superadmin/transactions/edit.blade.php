@extends('layouts.app')

@section('title', 'Edit Transaction | SuperAdmin')
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
        }

        .form-section {
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #f1f5f9;
            display: flex;
            align-items: center;
            gap: 0.5rem;
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
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.1);
            outline: none;
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
        }

        .price-calculator {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1rem;
        }

        .calculation-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .calculation-row:last-child {
            border-bottom: none;
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--primary-color);
        }

        .calculation-label {
            color: #64748b;
        }

        .calculation-value {
            font-weight: 600;
            color: var(--dark-color);
        }

        .photo-preview {
            margin-top: 1rem;
            text-align: center;
        }

        .photo-preview img {
            max-width: 200px;
            max-height: 200px;
            border-radius: 8px;
            border: 2px solid #e2e8f0;
        }

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
        }

        .map-preview.has-coordinates {
            background: #e0f2fe;
            color: var(--info-color);
            cursor: pointer;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
        }

        .btn-primary {
            background: var(--gradient-primary);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.4);
        }

        .btn-secondary {
            background: #64748b;
            color: white;
        }

        .btn-secondary:hover {
            background: #475569;
            transform: translateY(-2px);
        }

        .btn-outline-secondary {
            background: transparent;
            color: #64748b;
            border: 1px solid #64748b;
        }

        .btn-outline-secondary:hover {
            background: #64748b;
            color: white;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e2e8f0;
        }

        .transaction-info {
            background: #f0f9ff;
            border: 1px solid #e0f2fe;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
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
        }

        .info-value {
            font-weight: 600;
            color: var(--dark-color);
        }

        .badge {
            padding: 0.3rem 0.6rem;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .badge-success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
        }

        .badge-warning {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning-color);
        }

        .badge-danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error-color);
        }

        .badge-secondary {
            background: rgba(100, 116, 139, 0.1);
            color: #64748b;
        }

        .error-message {
            color: var(--error-color);
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }

        .is-invalid {
            border-color: var(--error-color) !important;
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

        <form action="{{ route('admin.transactions.update', $transaction) }}" method="POST" enctype="multipart/form-data" id="editTransactionForm">
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
                        <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                            <option value="">Select Sales Person</option>
                            @foreach($users as $user)
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
                        <select name="customer_id" id="customer_id" class="form-select @error('customer_id') is-invalid @enderror" required>
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
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

                    <div class="form-group">
                        <label for="product_id" class="form-label">Product *</label>
                        <select name="product_id" id="product_id" class="form-select @error('product_id') is-invalid @enderror" required>
                            <option value="">Select Product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" 
                                    data-price="{{ $product->price }}"
                                    {{ old('product_id', $transaction->product_id) == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} - Rp {{ number_format($product->price, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Transaction Details Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-receipt"></i>
                    Transaction Details
                </h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="quantity" class="form-label">Quantity *</label>
                        <input type="number" name="quantity" id="quantity" 
                               class="form-control @error('quantity') is-invalid @enderror"
                               value="{{ old('quantity', $transaction->quantity) }}" 
                               min="1" required>
                        @error('quantity')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="price" class="form-label">Price per Unit *</label>
                        <input type="number" name="price" id="price" 
                               class="form-control @error('price') is-invalid @enderror"
                               value="{{ old('price', $transaction->price) }}" 
                               min="0" step="0.01" required>
                        @error('price')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Total Price</label>
                        <input type="text" id="total_price" class="form-control readonly-field" 
                               value="Rp {{ number_format($transaction->total_price, 0, ',', '.') }}" readonly>
                        <input type="hidden" name="total_price" id="total_price_hidden" value="{{ $transaction->total_price }}">
                    </div>
                </div>

                <!-- Price Calculator -->
                <div class="price-calculator">
                    <div class="calculation-row">
                        <span class="calculation-label">Quantity:</span>
                        <span class="calculation-value" id="calcQuantity">{{ $transaction->quantity }} pcs</span>
                    </div>
                    <div class="calculation-row">
                        <span class="calculation-label">Price per Unit:</span>
                        <span class="calculation-value" id="calcPrice">Rp {{ number_format($transaction->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="calculation-row">
                        <span class="calculation-label">Total Amount:</span>
                        <span class="calculation-value" id="calcTotal">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                    </div>
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
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="pending" {{ old('status', $transaction->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ old('status', $transaction->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ old('status', $transaction->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="payment_status" class="form-label">Payment Status *</label>
                        <select name="payment_status" id="payment_status" class="form-select @error('payment_status') is-invalid @enderror" required>
                            <option value="pending" {{ old('payment_status', $transaction->payment_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ old('payment_status', $transaction->payment_status) == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="cancelled" {{ old('payment_status', $transaction->payment_status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
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
                               value="{{ old('latitude', $transaction->latitude) }}" 
                               step="any" placeholder="e.g., -6.2088">
                        @error('latitude')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="longitude" class="form-label">Longitude</label>
                        <input type="number" name="longitude" id="longitude" 
                               class="form-control @error('longitude') is-invalid @enderror"
                               value="{{ old('longitude', $transaction->longitude) }}" 
                               step="any" placeholder="e.g., 106.8456">
                        @error('longitude')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="photo" class="form-label">Transaction Photo</label>
                        <input type="file" name="photo" id="photo" 
                               class="form-control @error('photo') is-invalid @enderror"
                               accept="image/*">
                        @error('photo')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                        
                        @if($transaction->photo)
                            <div class="photo-preview">
                                <p class="form-text">Current Photo:</p>
                                <img src="{{ asset('storage/' . $transaction->photo) }}" 
                                     alt="Transaction Photo" 
                                     onerror="this.style.display='none'">
                                <p class="form-text">Upload new photo to replace current one</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Map Preview -->
                @if($transaction->latitude && $transaction->longitude)
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
                    <textarea name="notes" id="notes" 
                              class="form-control @error('notes') is-invalid @enderror"
                              rows="3" placeholder="Additional notes about this transaction...">{{ old('notes', $transaction->notes) }}</textarea>
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
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInput = document.getElementById('quantity');
            const priceInput = document.getElementById('price');
            const productSelect = document.getElementById('product_id');
            const calcQuantity = document.getElementById('calcQuantity');
            const calcPrice = document.getElementById('calcPrice');
            const calcTotal = document.getElementById('calcTotal');
            const totalPriceInput = document.getElementById('total_price');
            const totalPriceHidden = document.getElementById('total_price_hidden');

            // Auto-calculate total price
            function calculateTotal() {
                const quantity = parseInt(quantityInput.value) || 0;
                const price = parseFloat(priceInput.value) || 0;
                const total = quantity * price;

                // Update display
                calcQuantity.textContent = quantity + ' pcs';
                calcPrice.textContent = 'Rp ' + formatNumber(price);
                calcTotal.textContent = 'Rp ' + formatNumber(total);
                totalPriceInput.value = 'Rp ' + formatNumber(total);
                totalPriceHidden.value = total;
            }

            // Format number with thousand separators
            function formatNumber(number) {
                return number.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            // Auto-fill price when product is selected
            productSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const price = selectedOption.getAttribute('data-price');
                
                if (price) {
                    priceInput.value = price;
                    calculateTotal();
                }
            });

            // Recalculate when quantity or price changes
            quantityInput.addEventListener('input', calculateTotal);
            priceInput.addEventListener('input', calculateTotal);

            // Initialize calculation
            calculateTotal();

            // Form reset function
            window.resetForm = function() {
                if (confirm('Are you sure you want to reset the form? All changes will be lost.')) {
                    document.getElementById('editTransactionForm').reset();
                    calculateTotal(); // Recalculate with reset values
                }
            };

            // Form submission handler
            document.getElementById('editTransactionForm').addEventListener('submit', function(e) {
                const quantity = parseInt(quantityInput.value);
                const price = parseFloat(priceInput.value);

                if (quantity <= 0) {
                    e.preventDefault();
                    alert('Quantity must be greater than 0');
                    quantityInput.focus();
                    return;
                }

                if (price <= 0) {
                    e.preventDefault();
                    alert('Price must be greater than 0');
                    priceInput.focus();
                    return;
                }

                // Show loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
                submitBtn.disabled = true;
            });
        });
    </script>
@endpush