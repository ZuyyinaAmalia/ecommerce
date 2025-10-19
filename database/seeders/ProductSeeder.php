<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'iPhone 15 Pro',
                'price' => 25000000,
                'stock' => 10,
                'category_id' => 1, // pastikan category_id = ada di tabel categories
                'is_active' => true,
                'image' => 'https://store.storeimages.cdn-apple.com/iphone15.jpg',
                'created_at' => now(),
            ],
            [
                'name' => 'Samsung Galaxy S24',
                'price' => 20000000,
                'stock' => 15,
                'category_id' => 1,
                'is_active' => true,
                'image' => 'https://images.samsung.com/s24.jpg',
                'created_at' => now(),
            ],
            [
                'name' => 'Asus ROG Laptop',
                'price' => 30000000,
                'stock' => 5,
                'category_id' => 2,
                'is_active' => true,
                'image' => 'https://rog.asus.com/laptop.jpg',
                'created_at' => now(),
            ],
            [
                'name' => 'Sony WH-1000XM5 Headphones',
                'price' => 6000000,
                'stock' => 20,
                'category_id' => 3,
                'is_active' => true,
                'image' => 'https://sony.com/wh1000xm5.jpg',
                'created_at' => now(),
            ],
            [
                'name' => 'Logitech MX Master 3S Mouse',
                'price' => 1500000,
                'stock' => 25,
                'category_id' => 3,
                'is_active' => true,
                'image' => 'https://logitech.com/mxmaster3s.jpg',
                'created_at' => now(),
            ],
        ];

        DB::table('products')->insert($products);
    }
}


