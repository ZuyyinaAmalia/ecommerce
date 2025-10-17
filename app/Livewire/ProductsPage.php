<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use LiveWire\Attributes\Title;
use LiveWire\Attributes\Url;
use App\Models\Product;
use App\Models\Category;
use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use Jantinnerezo\LivewireAlert\LivewireAlert;

#[Title('Products - Batik Mania')]
class ProductsPage extends Component {

    use LivewireAlert;

    use WithPagination;

    #[Url]
    public $selected_categories = [];

    // add product to cart method
    public function addToCart($product_id){
        $total_count = CartManagement::addItemToCart($product_id);

        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);

        $this->alert('success', 'Product added to cart successfully!', [
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true,
        ]);
    }

    public function render() {
        $productQuery = Product::query()->where('is_active', 1);

        if (!empty($this->selected_categories)) {
            $productQuery->whereIn('category_id', $this->selected_categories);
        }

        return view('livewire.products-page', [
            'products' => $productQuery->paginate(9),
            'categories' => Category::all(),
        ]);
    }
}