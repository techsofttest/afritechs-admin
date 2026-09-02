<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'customer_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'subtotal',
        'discount_total',
        'tax_total',
        'shipping_total',
        'total',
        'currency',
        'payment_method',
        'payment_status',
        'status',
        'billing_address',
        'shipping_address',
        'notes',
        'placed_at',
        'country',
    ];

    protected $casts = [
        'billing_address' => 'array',
        'shipping_address' => 'array',
        'placed_at' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
