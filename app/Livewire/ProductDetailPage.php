<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Product;
use App\Helpers\CartManagement;

#[Title('Product Detail - Batik Mania')]
class ProductDetailPage extends Component
{
    public $product;
    public $quantity = 1;

    public function mount($id)
    {
        $this->product = Product::findOrFail($id);
    }

    public function increment()
    {
        $this->quantity++;
    }

    public function decrement()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart()
    {
        for ($i = 0; $i < $this->quantity; $i++) {
            CartManagement::addItemToCart($this->product->id);
        }

        $this->dispatch('cart-updated');

        session()->flash('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function render()
    {
        return view('livewire.product-detail-page', [
            'product' => $this->product,
        ]);
    }
}

