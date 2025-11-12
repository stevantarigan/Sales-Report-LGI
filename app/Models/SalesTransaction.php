<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_id',
        'product_id',
        'quantity',
        'price',
        'total_price',
        'products_data',
        'payment_status',
        'photo',
        'latitude',
        'longitude',
        'map_link',
        'status'
    ];

    protected $casts = [
        'products_data' => 'array'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Method untuk mendapatkan semua produk - PERBAIKI INI
    public function getAllProducts()
    {
        // Prioritaskan products_data jika ada
        if ($this->products_data && !empty($this->products_data)) {
            return collect($this->products_data)->map(function ($item) {
                return (object) [
                    'product_id' => $item['product_id'] ?? null,
                    'quantity' => $item['quantity'] ?? 0,
                    'price' => $item['price'] ?? 0,
                    'subtotal' => ($item['quantity'] ?? 0) * ($item['price'] ?? 0)
                ];
            });
        }

        // Fallback ke product utama untuk data lama
        return collect([
            (object) [
                'product_id' => $this->product_id,
                'quantity' => $this->quantity,
                'price' => $this->price,
                'subtotal' => $this->total_price
            ]
        ]);
    }

    // Accessor untuk total quantity
    public function getTotalQuantityAttribute()
    {
        if ($this->products_data && !empty($this->products_data)) {
            return collect($this->products_data)->sum('quantity');
        }
        return $this->quantity;
    }

    // Accessor untuk calculated total (untuk validasi)
    public function getCalculatedTotalAttribute()
    {
        return $this->getAllProducts()->sum('subtotal');
    }

    // Method untuk cek apakah transaksi multi-produk
    public function getIsMultiProductAttribute()
    {
        return $this->products_data && count($this->products_data) > 1;
    }
}