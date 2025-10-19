<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Tampilkan daftar produk
     */
    public function index()
    {
        $products = Product::with('category')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Form tambah produk
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Simpan produk baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string|max:1000',
            'category_id' => 'nullable|exists:categories,id',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        try {
            $validated['is_active'] = $request->has('is_active') ? 1 : 0;

            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('products', 'public');
            }

            Product::create($validated);

            return redirect()->route('products.index')
                ->with('success', 'Produk berhasil ditambahkan!');
                
        } catch (\Exception $e) {
            if (isset($validated['image']) && Storage::disk('public')->exists($validated['image'])) {
                Storage::disk('public')->delete($validated['image']);
            }

            return redirect()->back()
                ->with('error', 'Gagal menambahkan produk: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string|max:1000',
            'category_id' => 'nullable|exists:categories,id',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        try {
            $validated['is_active'] = $request->has('is_active') ? 1 : 0;

            $oldImage = $product->image;

            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('products', 'public');

                if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
            } else {
                $validated['image'] = $oldImage;
            }

            $product->update($validated);

            return redirect()->route('products.index')
                ->with('success', 'Produk berhasil diupdate!');
        } catch (\Exception $e) {
            if (isset($validated['image']) && $validated['image'] !== $product->image && Storage::disk('public')->exists($validated['image'])) {
                Storage::disk('public')->delete($validated['image']);
            }

            return redirect()->back()
                ->with('error', 'Gagal mengupdate produk: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Product $product)
    {
        try {
            $hasActiveOrders = $product->orderItems()
                ->whereHas('order', function($query) {
                    $query->whereIn('status', ['pending', 'processing']);
                })
                ->exists();

            if ($hasActiveOrders) {
                return redirect()->back()
                    ->with('error', 'Produk tidak bisa dihapus karena masih ada pesanan aktif!');
            }

            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();

            return redirect()->route('products.index')
                ->with('success', 'Produk berhasil dihapus!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }

    public function toggleStatus(Product $product)
    {
        try {
            $product->update([
                'is_active' => !$product->is_active
            ]);

            $status = $product->is_active ? 'diaktifkan' : 'dinonaktifkan';

            return redirect()->back()
                ->with('success', "Produk berhasil {$status}!");
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengubah status produk!');
        }
    }

    public function search(Request $request)
    {
        $keyword = $request->input('q');

        $products = Product::where('name', 'like', "%{$keyword}%")->get();

        return view('products.index', compact('products'));
    }
}


 