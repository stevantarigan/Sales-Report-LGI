<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesTransaction extends Model
{
    use HasFactory;

    // Status Transaksi
    const STATUS_FIRST_MEET = 'first_meet';
    const STATUS_FOLLOW_UP = 'follow_up';
    const STATUS_OFFERING = 'offering';
    const STATUS_NEGOTIATE = 'negotiate';
    const STATUS_COMPLETED = 'completed';

    // Status Pembayaran
    const PAYMENT_DP = 'dp';
    const PAYMENT_SECOND = 'second_payment';
    const PAYMENT_THIRD = 'third_payment';
    const PAYMENT_COMPLETED = 'completed';

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

    // Method untuk mendapatkan semua produk
    public function getAllProducts()
    {
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

    // Accessor untuk calculated total
    public function getCalculatedTotalAttribute()
    {
        return $this->getAllProducts()->sum('subtotal');
    }

    // Method untuk cek apakah transaksi multi-produk
    public function getIsMultiProductAttribute()
    {
        return $this->products_data && count($this->products_data) > 1;
    }

    // Get available status options
    public static function getStatusOptions()
    {
        return [
            self::STATUS_FIRST_MEET => 'FIRST MEET',
            self::STATUS_FOLLOW_UP => 'FOLLOW UP',
            self::STATUS_OFFERING => 'OFFERING',
            self::STATUS_NEGOTIATE => 'NEGOTIATE',
            self::STATUS_COMPLETED => 'COMPLETED',
        ];
    }

    // Get available payment status options
    public static function getPaymentStatusOptions()
    {
        return [
            self::PAYMENT_DP => 'DP',
            self::PAYMENT_SECOND => 'SECOND PAYMENT',
            self::PAYMENT_THIRD => 'THIRD PAYMENT',
            self::PAYMENT_COMPLETED => 'COMPLETED',
        ];
    }

    // Get status label
    public function getStatusLabelAttribute()
    {
        return self::getStatusOptions()[$this->status] ?? $this->status;
    }

    // Get payment status label
    public function getPaymentStatusLabelAttribute()
    {
        return self::getPaymentStatusOptions()[$this->payment_status] ?? $this->payment_status;
    }

    // Check if transaction is completed
    public function getIsCompletedAttribute()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    // Check if payment is completed
    public function getIsPaymentCompletedAttribute()
    {
        return $this->payment_status === self::PAYMENT_COMPLETED;
    }

    // Get status badge color
    public function getStatusBadgeAttribute()
    {
        $colors = [
            self::STATUS_FIRST_MEET => 'bg-primary',
            self::STATUS_FOLLOW_UP => 'bg-info',
            self::STATUS_OFFERING => 'bg-warning',
            self::STATUS_NEGOTIATE => 'bg-orange',
            self::STATUS_COMPLETED => 'bg-success',
        ];

        return $colors[$this->status] ?? 'bg-secondary';
    }

    // Get payment status badge color
    public function getPaymentStatusBadgeAttribute()
    {
        $colors = [
            self::PAYMENT_DP => 'bg-primary',
            self::PAYMENT_SECOND => 'bg-info',
            self::PAYMENT_THIRD => 'bg-warning',
            self::PAYMENT_COMPLETED => 'bg-success',
        ];

        return $colors[$this->payment_status] ?? 'bg-secondary';
    }
}