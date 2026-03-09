<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'xendit_invoice_id',
        'external_id',
        'total_amount',
        'status',
        'payment_method',
        'invoice_url',
        'paid_at',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}