<?php

namespace App\Livewire;
use LiveWire\Attributes\Title;
use Livewire\Component;
use App\Models\Category; 

#[Title('Categories - Batik Mania')]
class CategoriesPage extends Component
{
    public function render()
    {
        $categories = Category::get();
        return view('livewire.categories-page', [
            'categories' => $categories,
        ]);
    }
}
