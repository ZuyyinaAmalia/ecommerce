<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    // Nama tabel (opsional kalau sesuai konvensi)
    protected $table = 'carts';

    // Kolom yang boleh diisi mass assignment
    protected $fillable = [
        'user_id',
    ];

    // Jika kamu ingin menonaktifkan timestamps
    // public $timestamps = false;

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
}