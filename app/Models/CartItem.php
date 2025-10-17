<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $table = 'cart_items';

    protected $fillable = [
        'cart_id',
        'product_id',
        'qty',
    ];

    /**
     * Relasi ke Cart (banyak item milik satu cart)
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Relasi ke Product (setiap item mengacu ke satu produk)
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
