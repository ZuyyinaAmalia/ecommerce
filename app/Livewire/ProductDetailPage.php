<?php

namespace App\Livewire;

use Livewire\Component;
use LiveWire\Attributes\Title;
use App\Models\Product;
use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;

#[Title('Product Detail - Batik Mania')]
class ProductDetailPage extends Component
{

    public $product;

    public $quantity = 1;

    public function mount($id){
        $this->product = Product::findOrFail($id);
    }

    public function increaseQty() {
        $this->quantity++;
    }

    public function decreaseQty() {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart($product_id) {
        $total_count = CartManagement::addItemToCartWithQty($product_id, $this->quantity);

        $this->dispatch('update-cart-count',  total_count: $total_count)->to(Navbar::class);
    }
    public function render() {
        return view('livewire.product-detail-page', [
            'product' => $this->product,
        ]);
    }
}
