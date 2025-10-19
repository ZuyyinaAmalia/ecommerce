<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;

class SuccessPage extends Component
{
    public $order;

    public function mount()
    {
        $this->order = Order::latest()->where('user_id', auth()->id())->first();
    }

    public function render()
    {
        return view('livewire.success-page', [
            'order' => $this->order
        ]);
    }
}



