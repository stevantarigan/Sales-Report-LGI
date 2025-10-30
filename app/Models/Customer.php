<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'city',
        'province',
        'is_active'
    ];

    public function transactions()
    {
        return $this->hasMany(SalesTransaction::class);
    }
}
