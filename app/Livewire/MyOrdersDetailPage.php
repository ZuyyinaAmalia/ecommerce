<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderItem;

#[Title('Order Detail')]
class MyOrdersDetailPage extends Component
{
    public $order_id;

    public function mount($order_id)
    {
        $this->order_id = $order_id;
    }

    public function render()
    {
        // Ambil order beserta user dan item produknya
        $order = Order::with(['user', 'orderItems.product'])
            ->where('id', $this->order_id)
            ->first();

        // Ambil nilai unit_amount dari price dan total_amount dari subtotal
        $order_items = $order?->orderItems->map(function ($item) {
            $item->unit_amount = $item->price ?? 0;      // harga satuan
            $item->total_amount = $item->subtotal ?? 0; 
            $item->qty = $item->qty ?? 1; // total untuk item tsb
            return $item;
        }) ?? collect();

        return view('livewire.my-orders-detail-page', [
            'order' => $order,
            'order_items' => $order_items,
            'address' => $order?->address_text ?? '-',
            'phone' => $order?->telp ?? '-',  
            'total' => $order?->total ?? 0,              // total dari tabel orders
        ]);
    }
}

