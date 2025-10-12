@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">➕ Add New Product</h1>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5 bg-white p-6 rounded-lg shadow">
        @csrf

        <div>
            <label class="block font-medium mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block font-medium mb-1">Price</label>
            <input type="number" name="price" value="{{ old('price') }}" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block font-medium mb-1">Stock</label>
            <input type="number" name="stock" value="{{ old('stock') }}" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block font-medium mb-1">Category</label>
            <select name="category_id" class="w-full border rounded p-2">
                <option value="">-- Select Category --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-medium mb-1">Image</label>
            <input type="file" name="image" class="w-full border rounded p-2">
        </div>

        <div class="flex items-center space-x-2">
            <input type="checkbox" name="is_active" value="1" checked>
            <label>Active</label>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
        </div>
    </form>
</div>
@endsection
