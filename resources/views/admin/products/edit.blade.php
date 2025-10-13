@extends('layouts.admin')

@section('content')
<div style="font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 1.5; padding: 40px; display: flex; justify-content: center;">
    <div style="background: #ffffff; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 100%; max-width: 1200px; padding: 40px;">

        <h1 style="font-size: 22px; font-weight: bold; color: #a5682a; margin-bottom: 25px; display: flex; align-items: center;">
            ✏️ <span style="margin-left: 10px;">Edit Product</span>
        </h1>

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" style="width: 100%;">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 24px;">

                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 6px;">Name</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" 
                           style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 8px;">
                </div>

                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 6px;">Price</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" 
                           style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 8px;">
                </div>

                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 6px;">Stock</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" 
                           style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 8px;">
                </div>

                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 6px;">Category</label>
                    <select name="category_id" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 8px;">
                        <option value="">-- Select Category --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="grid-column: span 2;">
                    <label style="display: block; font-weight: 600; margin-bottom: 6px;">Current Image</label>
                    @if ($product->image)
                        <img src="{{ $product->image_url }}" alt="Current image" 
                             style="width: 150px; height: 150px; object-fit: cover; border-radius: 10px; margin-bottom: 10px; border: 1px solid #ddd;">
                    @else
                        <p style="color: #888; font-size: 13px;">No image uploaded</p>
                    @endif
                    <input type="file" name="image" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 8px;">
                </div>

                <div style="grid-column: span 2; display: flex; align-items: center; margin-top: 10px;">
                    <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }} style="margin-right: 8px;">
                    <label>Active</label>
                </div>
            </div>

            <div style="text-align: right; margin-top: 30px;">
                <button type="submit" 
                        style="background-color: #a5682a; color: #fff; border: none; padding: 10px 28px; border-radius: 8px; cursor: pointer; font-weight: 500;">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection



