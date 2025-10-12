<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use LiveWire\Attributes\Title;

#[Title('Home Page - Batik Mania')]
class HomePage extends Component
{
    public function render()
    {
        $categories = Category::get();
        return view('livewire.home-page', [
            'categories' => $categories
        ]);
    }
}
