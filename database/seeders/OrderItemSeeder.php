<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrderItem;
use Carbon\Carbon;

class OrderItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['order_id' => 1, 'product_id' => 1, 'qty' => 1, 'price' => 25000000],
            ['order_id' => 1, 'product_id' => 2, 'qty' => 1, 'price' => 20000000],
            ['order_id' => 2, 'product_id' => 3, 'qty' => 1, 'price' => 30000000],
            ['order_id' => 3, 'product_id' => 4, 'qty' => 1, 'price' => 6000000],
        ];

        foreach ($items as $item) {
            OrderItem::create([
                'order_id'   => $item['order_id'],
                'product_id' => $item['product_id'],
                'qty'        => $item['qty'],
                'price'      => $item['price'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}

