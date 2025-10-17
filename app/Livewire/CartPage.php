<?php

namespace App\Livewire;

use App\Livewire\Partials\Navbar;
use App\Helpers\CartManagement;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Cart - Batik Mania')]
class CartPage extends Component
{
    public $cart_items = [];
    public $grand_total;

    public function mount()
    {
        // ✅ Ambil cart baik dari DB (kalau login) atau cookie (kalau guest)
        $this->cart_items = CartManagement::getCartItems();
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);
    }

    public function removeItem($product_id)
    {
        $this->cart_items = CartManagement::removeItemFromCart($product_id);
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);

        // Update jumlah di navbar
        $this->dispatch('update-cart-count', total_count: count($this->cart_items))
            ->to(Navbar::class);
    }

    public function increaseQty($product_id)
    {
        $this->cart_items = CartManagement::incrementQuantity($product_id);
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);
    }

    public function decreaseQty($product_id)
    {
        $this->cart_items = CartManagement::decrementQuantity($product_id);
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);
    }

    public function placeOrder()
    {
        // ✅ Pindah ke halaman checkout
        return redirect()->to('/checkout');
    }

    public function render()
    {
        return view('livewire.cart-page');
    }
}

