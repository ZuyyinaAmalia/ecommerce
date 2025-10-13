<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Tampilkan isi cart
    public function index()
    {
        // Ambil cart user beserta item dan produk
        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();

        return view('cart.index', compact('cart'));
    }

    // Tambah produk ke cart
    public function add(Product $product)
    {
        // Ambil cart user, kalau belum ada buat baru
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        // Tambahkan produk ke cart
        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'qty' => 1
        ]);

        return redirect('/cart');
    }
}
