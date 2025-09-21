<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada user, kalau tidak buat dummy
        $user1 = User::firstOrCreate(
            ['email' => 'user1@example.com'],
            ['name' => 'User Satu', 'password' => bcrypt('password')]
        );

        $user2 = User::firstOrCreate(
            ['email' => 'user2@example.com'],
            ['name' => 'User Dua', 'password' => bcrypt('password')]
        );

        // Insert orders
        Order::insert([
            [
                'user_id' => $user1->id,
                'status' => 'pending',
                'address_text' => 'Jl. Sudirman No. 45, Jakarta',
                'total' => 45000000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => $user2->id,
                'status' => 'processing',
                'address_text' => 'Jl. Diponegoro No. 10, Bandung',
                'total' => 30000000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => $user1->id,
                'status' => 'completed',
                'address_text' => 'Jl. Gajah Mada No. 5, Semarang',
                'total' => 6000000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}



