<?php

namespace App\Livewire;

use Livewire\Component;
use App\Helpers\CartManagement;

class CartPage extends Component
{
    public $cart_items = [];

    public function mount()
    {
        // Ambil isi keranjang dari cookie
        $this->cart_items = CartManagement::getCartItemsFromCookie();
    }

    public function render()
    {
        $grand_total = CartManagement::calculateGrandTotal($this->cart_items);

        return view('livewire.cart-page', [
            'cart_items' => $this->cart_items,
            'grand_total' => $grand_total,
        ]);
    }
}
