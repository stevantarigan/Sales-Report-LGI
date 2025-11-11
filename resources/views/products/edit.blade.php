@php
    $layout = auth()->user()->role === 'adminsales' ? 'layouts.app2' : 'layouts.app';
@endphp

@extends($layout)

@section('title', 'Edit Product | ' . ucfirst(auth()->user()->role))
@section('page-title', 'Edit Product')
@section('page-description', 'Update product information and details')

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

        /* Image Upload Styles */
        .image-upload-container {
            text-align: center;
            padding: 2rem;
            border: 2px dashed #e2e8f0;
            border-radius: 12px;
            background: #f8fafc;
            transition: var(--transition);
            cursor: pointer;
            position: relative;
        }

        .image-upload-container:hover {
            border-color: var(--primary-color);
            background: #f1f5f9;
        }

        .image-upload-container.dragover {
            border-color: var(--primary-color);
            background: rgba(79, 70, 229, 0.05);
        }

        .image-preview {
            max-width: 200px;
            max-height: 200px;
            border-radius: 10px;
            margin: 0 auto 1rem;
            display: block;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .upload-icon {
            font-size: 3rem;
            color: #94a3b8;
            margin-bottom: 1rem;
        }

        /* Specifications Styles */
        .specifications-container {
            margin-top: 1rem;
        }

        .spec-row {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 1rem;
            align-items: end;
            margin-bottom: 1rem;
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

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #e2e8f0;
        }

        /* Stock Alert */
        .stock-alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }

        .stock-alert.low {
            background: rgba(245, 158, 11, 0.1);
            border: 1px solid rgba(245, 158, 11, 0.2);
            color: #d97706;
        }

        .stock-alert.out {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #dc2626;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .spec-row {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }

        /* Price Input */
        .price-input-group {
            position: relative;
        }

        .price-input-group::before {
            content: '$';
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-weight: 500;
        }

        .price-input-group .form-control {
            padding-left: 30px;
        }

        /* Readonly fields */
        .readonly-field {
            background: #f8fafc;
            border-color: #e2e8f0;
            color: #64748b;
        }

        /* Debug Info */
        .debug-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #4f46e5;
            margin-bottom: 20px;
        }

        .debug-info h5 {
            margin-top: 0;
            color: #4f46e5;
        }

        .debug-info p {
            margin-bottom: 5px;
            font-size: 0.875rem;
        }
    </style>
@endpush

@section('content')
    <div class="form-container" data-aos="fade-up">

        {{-- <!-- Debug Information Section -->
        <div class="debug-info">
            <h5><i class="fas fa-bug me-2"></i>Debug Information</h5>
            <p><strong>Current Image Path:</strong> {{ $product->image ?? 'No image' }}</p>
            <p><strong>Storage Exists:</strong>
                @if ($product->image)
                    {{ Storage::disk('public')->exists($product->image) ? 'Yes' : 'No' }}
                @else
                    N/A
                @endif
            </p>
            <p><strong>Full URL:</strong>
                @if ($product->image && Storage::disk('public')->exists($product->image))
                    {{ asset('storage/' . $product->image) }}
                @else
                    No image available
                @endif
            </p>
            <p><strong>Form Action:</strong> {{ route('products.update', $product) }}</p>
            <p><strong>Form Method:</strong> PUT</p>
            <p><strong>Has File Input:</strong> <span id="hasFileInfo">No file selected</span></p>
        </div> --}}

        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" id="productForm">
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
                        <label for="name" class="form-label">Product Name *</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name', $product->name) }}" required>
                        @error('name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="sku" class="form-label">SKU</label>
                        <input type="text" class="form-control readonly-field" id="sku" value="{{ $product->sku }}"
                            readonly>
                        <div class="form-text">SKU is automatically generated and cannot be changed</div>
                    </div>

                    <div class="form-group">
                        <label for="category" class="form-label">Category *</label>
                        <input type="text" class="form-control" id="category" name="category"
                            value="{{ old('category', $product->category) }}" required>
                        @error('category')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="brand" class="form-label">Brand</label>
                        <input type="text" class="form-control" id="brand" name="brand"
                            value="{{ old('brand', $product->brand) }}">
                        @error('brand')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Pricing Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-tag"></i>
                    Pricing Information
                </h3>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="price" class="form-label">Selling Price *</label>
                        <div class="price-input-group">
                            <input type="number" class="form-control" id="price" name="price" step="0.01"
                                min="0" value="{{ old('price', $product->price) }}" required>
                        </div>
                        @error('price')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="cost_price" class="form-label">Cost Price</label>
                        <div class="price-input-group">
                            <input type="number" class="form-control" id="cost_price" name="cost_price" step="0.01"
                                min="0" value="{{ old('cost_price', $product->cost_price) }}">
                        </div>
                        @error('cost_price')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Profit Margin</label>
                        <input type="text" class="form-control readonly-field"
                            value="{{ $product->cost_price ? number_format($product->getProfitMarginAttribute(), 2) . '%' : 'N/A' }}"
                            readonly>
                        <div class="form-text">Automatically calculated</div>
                    </div>
                </div>
            </div>

            <!-- Inventory Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-boxes"></i>
                    Inventory Management
                </h3>

                <!-- Stock Alerts -->
                @if ($product->stock_quantity == 0)
                    <div class="stock-alert out">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        This product is currently out of stock.
                    </div>
                @elseif($product->stock_quantity <= $product->min_stock)
                    <div class="stock-alert low">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        This product is running low on stock.
                    </div>
                @endif

                <div class="form-grid">
                    <div class="form-group">
                        <label for="stock_quantity" class="form-label">Current Stock *</label>
                        <input type="number" class="form-control" id="stock_quantity" name="stock_quantity"
                            min="0" value="{{ old('stock_quantity', $product->stock_quantity) }}" required>
                        @error('stock_quantity')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="min_stock" class="form-label">Minimum Stock Level *</label>
                        <input type="number" class="form-control" id="min_stock" name="min_stock" min="0"
                            value="{{ old('min_stock', $product->min_stock) }}" required>
                        @error('min_stock')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="supplier" class="form-label">Supplier</label>
                        <input type="text" class="form-control" id="supplier" name="supplier"
                            value="{{ old('supplier', $product->supplier) }}">
                        @error('supplier')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Image Upload Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-image"></i>
                    Product Image
                </h3>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Current Image</label>
                        @if ($product->image && Storage::disk('public')->exists($product->image))
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                class="image-preview">
                            <div class="mt-2 text-center">
                                <small class="text-muted">Current image: {{ $product->image }}</small>
                            </div>
                        @else
                            <div style="text-align: center; color: #64748b;">
                                <i class="fas fa-image fa-3x mb-2"></i>
                                <p>No image uploaded</p>
                                @if ($product->image)
                                    <small class="text-danger">Image not found: {{ $product->image }}</small>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="image" class="form-label">Update Image</label>
                        <div class="image-upload-container" onclick="document.getElementById('image').click()">
                            <i class="fas fa-cloud-upload-alt upload-icon"></i>
                            <p>Click to upload new image</p>
                            <p class="form-text">Recommended: 500x500px, JPG, PNG, or GIF (Max: 2MB)</p>
                            <input type="file" id="image" name="image" accept="image/*" style="display: none;"
                                onchange="previewImage(this)">
                        </div>
                        @error('image')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror

                        <!-- Current image info (hidden input to preserve if no new image uploaded) -->
                        @if ($product->image)
                            <input type="hidden" name="current_image" value="{{ $product->image }}">
                        @endif
                    </div>
                </div>
            </div>

            <!-- Specifications Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-list-alt"></i>
                    Product Specifications
                </h3>

                <div class="specifications-container" id="specificationsContainer">
                    @php
                        // Handle specifications data
                        $specifications = old('specifications', []);

                        // Jika tidak ada old input, gunakan data dari product
                        if (empty($specifications) && !empty($product->specifications)) {
                            $specifications = $product->specifications;
                        }

                        // Pastikan $specifications adalah array
                        $specifications = is_array($specifications) ? $specifications : [];
                    @endphp

                    @if (count($specifications) > 0)
                        @foreach ($specifications as $index => $spec)
                            <div class="spec-row">
                                <div class="form-group">
                                    <input type="text" class="form-control"
                                        name="specifications[{{ $index }}][key]" placeholder="Specification name"
                                        value="{{ $spec['key'] ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control"
                                        name="specifications[{{ $index }}][value]"
                                        placeholder="Specification value" value="{{ $spec['value'] ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeSpecRow(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="spec-row">
                            <div class="form-group">
                                <input type="text" class="form-control" name="specifications[0][key]"
                                    placeholder="Specification name">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="specifications[0][value]"
                                    placeholder="Specification value">
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeSpecRow(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>

                <button type="button" class="btn btn-secondary" onclick="addSpecRow()">
                    <i class="fas fa-plus me-2"></i>Add Specification
                </button>
            </div>

            <!-- Status Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-cog"></i>
                    Product Status
                </h3>

                <div class="checkbox-group">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
                            {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active Product</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured"
                            value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">Featured Product</label>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Products
                </a>
                <button type="button" class="btn btn-danger" onclick="resetForm()">
                    <i class="fas fa-undo me-2"></i>Reset
                </button>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-2"></i>Update Product
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let specCounter = {{ count($specifications) > 0 ? count($specifications) : 1 }};

        // Image preview functionality
        function previewImage(input) {
            const container = input.closest('.image-upload-container');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    // Remove existing preview or placeholder
                    const existingImg = container.querySelector('img');
                    const existingPlaceholder = container.querySelector('.upload-icon');
                    const existingText = container.querySelector('p');

                    if (existingImg) {
                        existingImg.src = e.target.result;
                    } else {
                        // Create new image preview
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'image-preview';
                        img.style.display = 'block';
                        img.style.margin = '0 auto 1rem';

                        // Replace upload icon with image preview
                        if (existingPlaceholder) {
                            existingPlaceholder.style.display = 'none';
                        }
                        if (existingText) {
                            existingText.style.display = 'none';
                        }
                        container.insertBefore(img, container.firstChild);
                    }
                }

                reader.readAsDataURL(input.files[0]);
                container.classList.add('dragover');

                // Update debug info
                document.getElementById('hasFileInfo').textContent = 'File selected: ' + input.files[0].name;

                // Remove dragover class after 2 seconds
                setTimeout(() => {
                    container.classList.remove('dragover');
                }, 2000);
            }
        }

        // Drag and drop functionality
        document.addEventListener('DOMContentLoaded', function() {
            const uploadContainer = document.querySelector('.image-upload-container');
            const fileInput = document.getElementById('image');

            if (uploadContainer) {
                // Prevent default drag behaviors
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    uploadContainer.addEventListener(eventName, preventDefaults, false);
                    document.body.addEventListener(eventName, preventDefaults, false);
                });

                // Highlight drop area when item is dragged over it
                ['dragenter', 'dragover'].forEach(eventName => {
                    uploadContainer.addEventListener(eventName, highlight, false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    uploadContainer.addEventListener(eventName, unhighlight, false);
                });

                // Handle dropped files
                uploadContainer.addEventListener('drop', handleDrop, false);
            }

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            function highlight() {
                uploadContainer.classList.add('dragover');
            }

            function unhighlight() {
                uploadContainer.classList.remove('dragover');
            }

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                fileInput.files = files;
                previewImage(fileInput);
            }

            // Debug file input
            document.getElementById('image').addEventListener('change', function(e) {
                const fileInfo = document.getElementById('hasFileInfo');
                if (this.files.length > 0) {
                    fileInfo.textContent = 'File selected: ' + this.files[0].name;
                } else {
                    fileInfo.textContent = 'No file selected';
                }
            });
        });

        // Specifications functionality
        function addSpecRow() {
            const container = document.getElementById('specificationsContainer');
            const newRow = document.createElement('div');
            newRow.className = 'spec-row';
            newRow.innerHTML = `
                <div class="form-group">
                    <input type="text" class="form-control" 
                           name="specifications[${specCounter}][key]" 
                           placeholder="Specification name">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" 
                           name="specifications[${specCounter}][value]" 
                           placeholder="Specification value">
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeSpecRow(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
            container.appendChild(newRow);
            specCounter++;
        }

        function removeSpecRow(button) {
            const row = button.closest('.spec-row');
            const container = document.getElementById('specificationsContainer');
            const rows = container.querySelectorAll('.spec-row');

            if (rows.length > 1) {
                row.remove();
                // Re-index remaining rows
                reindexSpecRows();
            } else {
                // If it's the last row, just clear the inputs
                const inputs = row.querySelectorAll('input');
                inputs.forEach(input => input.value = '');
            }
        }

        function reindexSpecRows() {
            const container = document.getElementById('specificationsContainer');
            const rows = container.querySelectorAll('.spec-row');

            rows.forEach((row, index) => {
                const keyInput = row.querySelector('input[name*="[key]"]');
                const valueInput = row.querySelector('input[name*="[value]"]');

                keyInput.name = `specifications[${index}][key]`;
                valueInput.name = `specifications[${index}][value]`;
            });

            specCounter = rows.length;
        }

        // Form reset functionality
        function resetForm() {
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
                    document.getElementById('productForm').reset();

                    // Reset specifications to one empty row
                    const container = document.getElementById('specificationsContainer');
                    container.innerHTML = `
                        <div class="spec-row">
                            <div class="form-group">
                                <input type="text" class="form-control" name="specifications[0][key]" 
                                       placeholder="Specification name">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="specifications[0][value]" 
                                       placeholder="Specification value">
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeSpecRow(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    `;
                    specCounter = 1;

                    // Reset debug info
                    document.getElementById('hasFileInfo').textContent = 'No file selected';

                    Swal.fire({
                        icon: 'success',
                        title: 'Form Reset!',
                        text: 'The form has been reset to its original state.',
                        confirmButtonColor: '#10b981'
                    });
                }
            });
        }

        // Form submission handling
        document.getElementById('productForm').addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
            submitBtn.disabled = true;

            // Log form submission for debugging
            const imageInput = document.getElementById('image');
            console.log('Form submitted. File selected:', imageInput.files.length > 0);
        });

        // Auto-calculate profit margin when prices change
        document.getElementById('price').addEventListener('input', updateProfitMargin);
        document.getElementById('cost_price').addEventListener('input', updateProfitMargin);

        function updateProfitMargin() {
            const price = parseFloat(document.getElementById('price').value) || 0;
            const costPrice = parseFloat(document.getElementById('cost_price').value) || 0;

            if (costPrice > 0 && price > 0) {
                const profitMargin = ((price - costPrice) / costPrice) * 100;
                document.querySelector('input[readonly][value*="%"]').value = profitMargin.toFixed(2) + '%';
            }
        }
    </script>
@endpush
