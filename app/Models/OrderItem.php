<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'price',
        'qty',
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

    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }

}
