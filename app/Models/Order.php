<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * [REFACTOR] Semua kolom yang bisa di-mass assign.
     * Ditambahkan: payment_channel_id, va_number, bank
     */
    protected $fillable = [
        'user_id',
        'xendit_invoice_id',
        'external_id',
        'total_amount',
        'status',
        'payment_method',
        'payment_channel_id',  // [FIX] Ditambahkan — menyimpan QR string / VA number
        'va_number',           // [FIX] Ditambahkan — nomor Virtual Account
        'bank',                // [FIX] Ditambahkan — kode bank (BCA, BNI, dll)
        'invoice_url',
        'paid_at',
    ];

    /**
     * [REFACTOR] Cast paid_at ke datetime agar bisa dipakai sebagai Carbon instance
     */
    protected $casts = [
        'paid_at' => 'datetime',
    ];

    /**
     * Relasi: Order dimiliki oleh satu User.
     * [REFACTOR] Ditambahkan relasi user() yang sebelumnya tidak ada
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Order memiliki banyak OrderItem.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
