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
use Jantinnerezo\LivewireAlert\LivewireAlert;

#[Title('Products - Batik Mania')]
class ProductsPage extends Component
{
    use LivewireAlert, WithPagination;

    protected $paginationTheme = 'tailwind';

    #[Url]
    public $selected_categories = [];

    #[Url]
    public $search = '';

    #[Url]
    public $sort = 'latest';

   
    public function updated($propertyName)
    {
        if (in_array($propertyName, ['search', 'sort', 'selected_categories'])) {
            $this->resetPage();
        }
    }

    
    public function addToCart($product_id)
    {
        $total_count = CartManagement::addItemToCart($product_id);

        // Update navbar cart count
        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);

        // Alert sukses
        $this->alert('success', 'Product added to cart successfully!', [
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true,
        ]);
    }

    
    public function render()
    {
        $productQuery = Product::query()->where('is_active', 1);

        if ($this->search !== '') {
            $productQuery->where('name', 'like', '%' . $this->search . '%');
        }

        if (!empty($this->selected_categories)) {
            $productQuery->whereIn('category_id', $this->selected_categories);
        }

        match ($this->sort) {
            'price_asc' => $productQuery->orderBy('price', 'asc'),
            'price_desc' => $productQuery->orderBy('price', 'desc'),
            default => $productQuery->latest(),
        };

        return view('livewire.products-page', [
            'products' => $productQuery->paginate(9),
            'categories' => Category::all(),
        ]);
    }
    
}




