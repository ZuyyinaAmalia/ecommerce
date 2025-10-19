<?php

namespace App\Livewire;

use App\Livewire\Partials\Navbar;
use App\Helpers\CartManagement;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Product;


#[Title('Cart - Batik Mania')]
class CartPage extends Component
{
    public $cart_items = [];
    public $total;

    public function mount()
    {
        $this->cart_items = CartManagement::getCartItemsFromCookie();
        $this->total = CartManagement::calculateTotal($this->cart_items);
    }

    public function removeItem($product_id)
    {
        $this->cart_items = CartManagement::removeCartItem($product_id);
        $this->total = CartManagement::calculateTotal($this->cart_items);

        // Update jumlah di navbar
        $this->dispatch('update-cart-count', total_count: count($this->cart_items))
            ->to(Navbar::class);
    }

    public function increaseQty($product_id)
    {
        $this->cart_items = CartManagement::incrementQuantityToCartItem($product_id);
        $this->total = CartManagement::calculateTotal($this->cart_items);
    }

    public function decreaseQty($product_id)
    {
        $this->cart_items = CartManagement::decrementQuantityToCartItem($product_id);
        $this->total = CartManagement::calculateTotal($this->cart_items);
    }

    // public function placeOrder()
    // {
    //     // ✅ Pindah ke halaman checkout
    //     return redirect()->to('/checkout');
    // }

    public function render()
    {
        return view('livewire.cart-page');
    }
}
