@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">✏️ Edit Product</h1>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5 bg-white p-6 rounded-lg shadow">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-medium mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block font-medium mb-1">Price</label>
            <input type="number" name="price" value="{{ old('price', $product->price) }}" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block font-medium mb-1">Stock</label>
            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block font-medium mb-1">Category</label>
            <select name="category_id" class="w-full border rounded p-2">
                <option value="">-- Select Category --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-medium mb-1">Current Image</label>
            @if ($product->image)
                <img src="{{ $product->image_url }}" alt="Current image" class="w-32 h-32 object-cover rounded mb-2">
            @else
                <p class="text-gray-500 text-sm">No image uploaded</p>
            @endif
            <input type="file" name="image" class="w-full border rounded p-2">
        </div>

        <div class="flex items-center space-x-2">
            <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }}>
            <label>Active</label>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
        </div>
    </form>
</div>
@endsection

