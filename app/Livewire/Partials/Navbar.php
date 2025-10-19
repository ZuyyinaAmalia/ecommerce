<?php

namespace App\Livewire\Partials;
use App\Helpers\CartManagement;
use Livewire\Attributes\on;
use Livewire\Component;

class Navbar extends Component
{
    public $total_count;

    // protected $listeners = [
    //     'update-cart-count' => 'updateCartCount', // 🟢 pastikan ini ada
    // ];

    public function mount() {
        $this->total_count = count(CartManagement::getCartItemsFromCookie());
    }

    #[On('update-cart-count')]
    public function updateCartCount($total_count) {
        $this->total_count = $total_count;
    }

    public function render()
    {
        return view('livewire.partials.navbar');
    }
}
