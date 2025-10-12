<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
    ];

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function getImageUrlsAttribute()
    {
        if (!$this->image) {
            return [];
        }

        // handle kalau image disimpan sebagai string (bukan array)
        if (is_string($this->image)) {
            return [asset('storage/' . $this->image)];
        }

        // kalau suatu saat jadi array
        return array_map(fn($path) => asset('storage/' . $path), $this->image);
    }

}
