<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use App\Models\Product;
use App\Models\Category;
use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;

#[Title('Products - Batik Mania')]
class ProductsPage extends Component
{
    use WithPagination;

    #[Url]
    public $selected_categories = [];

    #[Url]
    public $sort = 'latest';

    #[Url]
    public $search = '';

    // add product to cart method
    
    public function addToCart($product_id) {
        $total_count = CartManagement::addItemToCart($product_id);

        $this->dispatch('update-cart-count',  total_count: $total_count)->to(Navbar::class);

        // notif
        // $this->dispatch('product-added', message: 'Produk berhasil ditambahkan ke keranjang!');

    }

    public function render()
    {
        $productQuery = Product::query()->where('is_active', 1);

        // Search by name
        if ($this->search !== '') {
            $productQuery->where('name', 'like', '%' . $this->search . '%');
        }

        if (!empty($this->selected_categories)) {
            $productQuery->whereIn('category_id', $this->selected_categories);
        }

        if ($this->sort == 'latest') {
            $productQuery->latest();
        }

        if ($this->sort == 'price') {
            $productQuery->orderBy('price');
        }

        return view('livewire.products-page', [
            'products' => $productQuery->paginate(9),
            'categories' => Category::all(),
        ]);
    }
}
