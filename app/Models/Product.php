<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'sku',
        'description',
        'price',
        'cost_price',
        'stock_quantity',
        'min_stock',
        'category',
        'brand',
        'supplier',
        'image',
        'specifications',
        'is_active',
        'is_featured'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'min_stock' => 'integer',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'specifications' => 'array'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->sku)) {
                $product->sku = static::generateSku();
            }
        });
    }

    public static function generateSku()
    {
        $prefix = 'PROD';
        $date = now()->format('ymd');
        $random = strtoupper(substr(uniqid(), -6));

        return $prefix . $date . $random;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeLowStock($query)
    {
        return $query->whereRaw('stock_quantity <= min_stock');
    }

    public function getStockStatusAttribute()
    {
        if ($this->stock_quantity == 0) {
            return 'out_of_stock';
        } elseif ($this->stock_quantity <= $this->min_stock) {
            return 'low_stock';
        } else {
            return 'in_stock';
        }
    }

    // Ganti match dengan switch untuk PHP 7.3
    public function getStockStatusColorAttribute()
    {
        switch ($this->stock_status) {
            case 'out_of_stock':
                return 'danger';
            case 'low_stock':
                return 'warning';
            case 'in_stock':
                return 'success';
            default:
                return 'secondary';
        }
    }

    public function getProfitMarginAttribute()
    {
        if (!$this->cost_price) {
            return null;
        }

        return (($this->price - $this->cost_price) / $this->cost_price) * 100;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Tambahkan relationship ke SalesTransaction
    public function salesTransactions()
    {
        return $this->hasMany(SalesTransaction::class, 'product_id');
    }

    // Relationship untuk menghitung total terjual
    public function getTotalSoldAttribute()
    {
        return $this->salesTransactions()->sum('quantity');
    }
}