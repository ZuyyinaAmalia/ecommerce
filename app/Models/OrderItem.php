<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'price',
        'subtotal',
    ];

    protected static function boot()
    {
        parent::boot();

        // otomatis hitung subtotal sebelum disimpan
        static::creating(function ($item) {
            $item->subtotal = $item->qty * $item->price;
        });

        static::updating(function ($item) {
            $item->subtotal = $item->qty * $item->price;
        });
    }

    // Relasi ke Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relasi ke Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

