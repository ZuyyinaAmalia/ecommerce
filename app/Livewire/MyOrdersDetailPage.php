<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderItem;

#[Title('Order Detail')]
class MyOrdersDetailPage extends Component{
    public $order_id;

    public function mount($order_id)
    {
        $this->order_id = $order_id;
    }

    public function render()
    {
        $order = Order::with(['user', 'orderItems.product', 'address'])
            ->where('id', $this->order_id)
            ->first();

        return view('livewire.my-orders-detail-page', [
            'order' => $order,
            'order_items' => $order?->orderItems ?? collect(),
            'address' => $order?->address,
        ]);
    }
}
