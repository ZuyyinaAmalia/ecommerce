<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // tambah ini supaya bisa pakai model Product

class ProductController extends Controller
{
    public function index()
    {
        // Ambil semua produk aktif dari database
        $products = Product::where('is_active', true)->get();

        // Kirim data produk ke view
        return view('products.index', compact('products'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('q');

        // Ambil produk yang namanya mengandung keyword
        $products = Product::where('name', 'like', "%{$keyword}%")->get();

        return view('products.index', compact('products'));
    }
}
