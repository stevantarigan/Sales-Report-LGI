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
        'products_data', // TAMBAH INI
        'payment_status',
        'photo',
        'latitude',
        'longitude',
        'map_link',
        'status'
    ];

    // Tambahkan casting untuk products_data
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

    // Method untuk mendapatkan semua produk
    public function getAllProducts()
    {
        if ($this->products_data) {
            return collect($this->products_data)->map(function ($item) {
                return (object) [
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['quantity'] * $item['price']
                ];
            });
        }

        // Fallback ke product utama
        return collect([
            (object) [
                'product_id' => $this->product_id,
                'quantity' => $this->quantity,
                'price' => $this->price,
                'subtotal' => $this->total_price
            ]
        ]);
    }

    // Method untuk mendapatkan total quantity semua produk
    public function getTotalQuantityAttribute()
    {
        if ($this->products_data) {
            return collect($this->products_data)->sum('quantity');
        }
        return $this->quantity;
    }
}