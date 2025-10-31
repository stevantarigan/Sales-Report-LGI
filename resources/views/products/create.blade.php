@extends('layouts.app')

@section('title', 'Add New Product')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add New Product</h3>
                    <div class="card-tools">
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Products
                        </a>
                    </div>
                </div>
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header bg-primary">
                                        <h4 class="card-title">Basic Information</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="name">Product Name *</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" value="{{ old('name') }}" required>
                                            @error('name')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="sku">SKU</label>
                                            <input type="text" class="form-control @error('sku') is-invalid @enderror" 
                                                   id="sku" name="sku" value="{{ old('sku') }}" 
                                                   placeholder="Leave empty to auto-generate">
                                            @error('sku')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                            <small class="form-text text-muted">
                                                SKU will be auto-generated if left empty
                                            </small>
                                        </div>

                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                                      id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                            @error('description')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="category">Category *</label>
                                                    <input type="text" class="form-control @error('category') is-invalid @enderror" 
                                                           id="category" name="category" value="{{ old('category') }}" required>
                                                    @error('category')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="brand">Brand</label>
                                                    <input type="text" class="form-control @error('brand') is-invalid @enderror" 
                                                           id="brand" name="brand" value="{{ old('brand') }}">
                                                    @error('brand')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="supplier">Supplier</label>
                                            <input type="text" class="form-control @error('supplier') is-invalid @enderror" 
                                                   id="supplier" name="supplier" value="{{ old('supplier') }}">
                                            @error('supplier')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Pricing Information -->
                                <div class="card mt-3">
                                    <div class="card-header bg-info">
                                        <h4 class="card-title">Pricing Information</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="price">Selling Price *</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Rp</span>
                                                        </div>
                                                        <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                                                               id="price" name="price" value="{{ old('price') }}" required min="0">
                                                    </div>
                                                    @error('price')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="cost_price">Cost Price</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Rp</span>
                                                        </div>
                                                        <input type="number" step="0.01" class="form-control @error('cost_price') is-invalid @enderror" 
                                                               id="cost_price" name="cost_price" value="{{ old('cost_price') }}" min="0">
                                                    </div>
                                                    @error('cost_price')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Stock Information -->
                                <div class="card mt-3">
                                    <div class="card-header bg-warning">
                                        <h4 class="card-title">Stock Information</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="stock_quantity">Stock Quantity *</label>
                                                    <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror" 
                                                           id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" required min="0">
                                                    @error('stock_quantity')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="min_stock">Minimum Stock *</label>
                                                    <input type="number" class="form-control @error('min_stock') is-invalid @enderror" 
                                                           id="min_stock" name="min_stock" value="{{ old('min_stock', 5) }}" required min="0">
                                                    @error('min_stock')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                    <small class="form-text text-muted">
                                                        Low stock alert will trigger when stock reaches this level
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Specifications -->
                                <div class="card mt-3">
                                    <div class="card-header bg-secondary">
                                        <h4 class="card-title">Specifications</h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="specifications-container">
                                            <div class="specification-row row mb-2">
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="specifications[key][]" placeholder="Specification name">
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="specifications[value][]" placeholder="Specification value">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-danger remove-specification" disabled>
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-success" id="add-specification">
                                            <i class="fas fa-plus"></i> Add Specification
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Sidebar -->
                            <div class="col-md-4">
                                <!-- Image Upload -->
                                <div class="card">
                                    <div class="card-header bg-success">
                                        <h4 class="card-title">Product Image</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="image">Product Image</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input @error('image') is-invalid @enderror" 
                                                       id="image" name="image" accept="image/*">
                                                <label class="custom-file-label" for="image">Choose file</label>
                                            </div>
                                            @error('image')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                            <small class="form-text text-muted">
                                                Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB
                                            </small>
                                        </div>
                                        <div class="text-center mt-3">
                                            <img id="image-preview" src="https://via.placeholder.com/300x300?text=Product+Image" 
                                                 class="img-fluid" style="max-height: 200px; display: none;">
                                        </div>
                                    </div>
                                </div>

                                <!-- Status Settings -->
                                <div class="card mt-3">
                                    <div class="card-header bg-dark">
                                        <h4 class="card-title">Status Settings</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" checked>
                                                <label class="custom-control-label" for="is_active">Active Product</label>
                                            </div>
                                            <small class="form-text text-muted">
                                                Inactive products won't be shown to customers
                                            </small>
                                        </div>

                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="is_featured" name="is_featured" value="1">
                                                <label class="custom-control-label" for="is_featured">Featured Product</label>
                                            </div>
                                            <small class="form-text text-muted">
                                                Featured products may be highlighted on the website
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="card mt-3">
                                    <div class="card-body">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            <i class="fas fa-save"></i> Save Product
                                        </button>
                                        <a href="{{ route('products.index') }}" class="btn btn-secondary btn-block">
                                            <i class="fas fa-times"></i> Cancel
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image preview
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('image-preview');
    const fileLabel = document.querySelector('.custom-file-label');

    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            }
            reader.readAsDataURL(file);
            fileLabel.textContent = file.name;
        } else {
            imagePreview.style.display = 'none';
            fileLabel.textContent = 'Choose file';
        }
    });

    // Specifications management
    const specsContainer = document.getElementById('specifications-container');
    const addSpecBtn = document.getElementById('add-specification');

    addSpecBtn.addEventListener('click', function() {
        const newRow = document.createElement('div');
        newRow.className = 'specification-row row mb-2';
        newRow.innerHTML = `
            <div class="col-md-5">
                <input type="text" class="form-control" name="specifications[key][]" placeholder="Specification name">
            </div>
            <div class="col-md-5">
                <input type="text" class="form-control" name="specifications[value][]" placeholder="Specification value">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-specification">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        specsContainer.appendChild(newRow);
        updateRemoveButtons();
    });

    function updateRemoveButtons() {
        const removeButtons = document.querySelectorAll('.remove-specification');
        removeButtons.forEach(button => {
            button.disabled = removeButtons.length === 1;
            button.addEventListener('click', function() {
                if (removeButtons.length > 1) {
                    this.closest('.specification-row').remove();
                    updateRemoveButtons();
                }
            });
        });
    }

    // Initialize remove buttons
    updateRemoveButtons();

    // Auto-calculate profit margin if both prices are filled
    const priceInput = document.getElementById('price');
    const costPriceInput = document.getElementById('cost_price');

    function calculateProfitMargin() {
        const price = parseFloat(priceInput.value) || 0;
        const costPrice = parseFloat(costPriceInput.value) || 0;
        
        if (costPrice > 0 && price > 0) {
            const margin = ((price - costPrice) / costPrice) * 100;
            // You can display this somewhere if needed
            console.log('Profit Margin:', margin.toFixed(2) + '%');
        }
    }

    priceInput.addEventListener('input', calculateProfitMargin);
    costPriceInput.addEventListener('input', calculateProfitMargin);
});
</script>

<style>
.specification-row {
    align-items: center;
}
.card-header h4 {
    margin-bottom: 0;
    color: white;
}
</style>
@endpush