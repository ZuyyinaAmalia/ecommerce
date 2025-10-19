<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'totalProducts' => Product::count(),
            'lowStock' => Product::where('stock', '<', 5)->count(),
            'latestProducts' => Product::latest()->take(5)->get(),
        ]);
    }
}
