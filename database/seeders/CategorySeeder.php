<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Smartphone',
                'created_at' => now(),
            ],
            [
                'name' => 'Laptop',
                'created_at' => now(),
            ],
            [
                'name' => 'Accessories',
                'created_at' => now(),
            ],
        ];

        DB::table('categories')->insert($categories);
    }
}
