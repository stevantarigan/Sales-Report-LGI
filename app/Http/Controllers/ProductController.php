<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status')) {
            switch ($request->status) {
                case 'active':
                    $query->active();
                    break;
                case 'inactive':
                    $query->where('is_active', false);
                    break;
                case 'featured':
                    $query->featured();
                    break;
                case 'low_stock':
                    $query->lowStock();
                    break;
                case 'out_of_stock':
                    $query->where('stock_quantity', 0);
                    break;
            }
        }

        // Filter by category
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }

        // Sort functionality
        $sort = $request->get('sort', 'created_at');
        $order = $request->get('order', 'desc');
        $query->orderBy($sort, $order);

        $products = $query->paginate(15);

        // Get statistics
        $totalProducts = Product::count();
        $activeProducts = Product::active()->count();
        $lowStockProducts = Product::lowStock()->count();
        $outOfStockProducts = Product::where('stock_quantity', 0)->count();
        $categories = Product::distinct()->pluck('category')->filter();

        return view('products.index', compact(
            'products',
            'categories',
            'totalProducts',
            'activeProducts',
            'lowStockProducts',
            'outOfStockProducts'
        ));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|unique:products,sku',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'category' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'supplier' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        // Handle specifications
        if ($request->has('specifications')) {
            $specs = [];
            foreach ($request->specifications as $key => $value) {
                if (!empty($key) && !empty($value)) {
                    $specs[$key] = $value;
                }
            }
            $validated['specifications'] = $specs;
        }

        $product = Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'category' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'supplier' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        // Handle specifications
        if ($request->has('specifications')) {
            $specs = [];
            foreach ($request->specifications as $key => $value) {
                if (!empty($key) && !empty($value)) {
                    $specs[$key] = $value;
                }
            }
            $validated['specifications'] = $specs;
        }

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // Delete image if exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function bulkAction(Request $request)
    {
        $action = $request->action;
        $productIds = $request->product_ids;

        if (empty($productIds)) {
            return back()->with('error', 'No products selected.');
        }

        switch ($action) {
            case 'activate':
                Product::whereIn('id', $productIds)->update(['is_active' => true]);
                $message = 'Selected products activated successfully.';
                break;
            case 'deactivate':
                Product::whereIn('id', $productIds)->update(['is_active' => false]);
                $message = 'Selected products deactivated successfully.';
                break;
            case 'feature':
                Product::whereIn('id', $productIds)->update(['is_featured' => true]);
                $message = 'Selected products featured successfully.';
                break;
            case 'unfeature':
                Product::whereIn('id', $productIds)->update(['is_featured' => false]);
                $message = 'Selected products unfeatured successfully.';
                break;
            case 'delete':
                Product::whereIn('id', $productIds)->delete();
                $message = 'Selected products deleted successfully.';
                break;
            default:
                return back()->with('error', 'Invalid action.');
        }

        return back()->with('success', $message);
    }

    public function updateStock(Request $request, Product $product)
    {
        $request->validate([
            'stock_quantity' => 'required|integer|min:0',
            'adjustment_type' => 'required|in:set,add,subtract',
            'reason' => 'nullable|string|max:255'
        ]);

        $newQuantity = $request->stock_quantity;
        $adjustmentType = $request->adjustment_type;

        if ($adjustmentType === 'add') {
            $newQuantity = $product->stock_quantity + $request->stock_quantity;
        } elseif ($adjustmentType === 'subtract') {
            $newQuantity = $product->stock_quantity - $request->stock_quantity;
        }

        $product->update(['stock_quantity' => max(0, $newQuantity)]);

        // Here you can log the stock adjustment
        // StockAdjustment::create([...]);

        return back()->with('success', 'Stock updated successfully.');
    }
}