<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description', // tambahkan ini     
        'price',
        'stock',
        'category_id',
        'is_active',
        'image', // TAMBAHKAN INI
    ];

    protected $casts = [
        'price' => 'decimal:2', // Tambahkan ini juga
        'stock' => 'integer',   // Tambahkan ini juga
        'is_active' => 'boolean',
        'image' => 'json'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function orderItems(){
        return $this->hasMany(OrderItems::class); // Perbaiki huruf kapital
    }

    public function getImageUrlsAttribute()
    {
        if (!$this->image) {
            return [];
        }

        return array_map(function ($imagePath) {
            return asset('storage/' . $imagePath);
        }, $this->image);
    }

    public function getImageAttribute($value)
    {
        // Jika value berupa JSON string, decode jadi array
        $decoded = json_decode($value, true);

        // Jika hasil decode valid array, kembalikan array
        if (is_array($decoded)) {
            return $decoded;
        }

        // Jika bukan array (misal hanya "products/1.png"), jadikan array tunggal
        return $value ? [$value] : [];
    }
}