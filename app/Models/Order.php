<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address',
        'payment_method',
        'notes',
        'transaction_number',
        'total',
        'unique_code',
        'status',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}

