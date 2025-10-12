<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use LiveWire\Attributes\Title;
use LiveWire\Attributes\Url;
use App\Models\Product;
use App\Models\Category;

#[Title('Products - Batik Mania')]
class ProductsPage extends Component
{
    use WithPagination;

    #[Url]
    public $selected_categories = [];

    public function render()
    {
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
