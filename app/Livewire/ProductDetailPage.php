<?php

namespace App\Livewire;

use Livewire\Component;
use LiveWire\Attributes\Title;
use App\Models\Product;

#[Title('Product Detail - Batik Mania')]
class ProductDetailPage extends Component
{

    public $product;

    public function mount($id)
    {
        $this->product = Product::findOrFail($id);
    }
    
    public function render()
    {
        return view('livewire.product-detail-page', [
            'product' => $this->product,
        ]);
    }
}
