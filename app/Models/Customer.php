<?php
// app/Models/Customer.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'phone_secondary',
        'email',
        'address',
        'city',
        'province',
        'postal_code',
        'country',
        'company',
        'notes',
        'is_active',
        'customer_type'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Customer type constants
    const TYPE_KONTRAKTOR = 'KONTRAKTOR';
    const TYPE_ARSITEK = 'ARSITEK';
    const TYPE_TUKANG = 'TUKANG';
    const TYPE_OWNER = 'OWNER';
    const TYPE_UNDEFINED = 'UNDEFINED';

    public static function getCustomerTypes()
    {
        return [
            self::TYPE_KONTRAKTOR => 'Kontraktor',
            self::TYPE_ARSITEK => 'Arsitek',
            self::TYPE_TUKANG => 'Tukang',
            self::TYPE_OWNER => 'Owner',
            self::TYPE_UNDEFINED => 'Undefined',
        ];
    }

    public static function getCustomerTypeColors()
    {
        return [
            self::TYPE_KONTRAKTOR => 'primary',
            self::TYPE_ARSITEK => 'info',
            self::TYPE_TUKANG => 'warning',
            self::TYPE_OWNER => 'success',
            self::TYPE_UNDEFINED => 'secondary',
        ];
    }

    public function transactions()
    {
        return $this->hasMany(SalesTransaction::class);
    }

    // Scope for customer type
    public function scopeByType($query, $type)
    {
        return $query->where('customer_type', $type);
    }

    // Scope for active customers
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessor for formatted customer type
    public function getFormattedTypeAttribute()
    {
        return self::getCustomerTypes()[$this->customer_type] ?? $this->customer_type;
    }

    // Accessor for type color
    public function getTypeColorAttribute()
    {
        return self::getCustomerTypeColors()[$this->customer_type] ?? 'secondary';
    }

    // Check if customer is specific type
    public function isKontraktor()
    {
        return $this->customer_type === self::TYPE_KONTRAKTOR;
    }

    public function isArsitek()
    {
        return $this->customer_type === self::TYPE_ARSITEK;
    }

    public function isTukang()
    {
        return $this->customer_type === self::TYPE_TUKANG;
    }

    public function isOwner()
    {
        return $this->customer_type === self::TYPE_OWNER;
    }

    public function isUndefined()
    {
        return $this->customer_type === self::TYPE_UNDEFINED;
    }

    // Get customers by type for statistics
    public static function getStatsByType()
    {
        return [
            'KONTRAKTOR' => self::where('customer_type', 'KONTRAKTOR')->count(),
            'ARSITEK' => self::where('customer_type', 'ARSITEK')->count(),
            'TUKANG' => self::where('customer_type', 'TUKANG')->count(),
            'OWNER' => self::where('customer_type', 'OWNER')->count(),
            'UNDEFINED' => self::where('customer_type', 'UNDEFINED')->count(),
        ];
    }
}