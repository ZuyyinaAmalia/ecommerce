<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Nama tabel (opsional, karena defaultnya plural)
    protected $table = 'products';

    // Kolom yang bisa diisi mass-assignment
    protected $fillable = [
        'name',
        'price',
        'stock',
        'category_id',
        'is_active',
        'image',
    ];

    /**
     * Relasi ke Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi ke OrderItems
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Scope produk aktif saja
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    /**
     * Getter otomatis untuk format harga
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Getter untuk path gambar (otomatis cek apakah URL atau file lokal)
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/no-image.png'); // fallback default
        }

        return str_starts_with($this->image, 'http')
            ? $this->image
            : asset('storage/' . $this->image);
    }
}
