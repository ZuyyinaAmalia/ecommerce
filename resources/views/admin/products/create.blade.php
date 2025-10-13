@extends('layouts.admin')

@section('title', 'Add New Product')

@section('content')
<div style="
    font-family: 'Roboto', sans-serif;
    font-size: 14px;
    line-height: 1.5;
    background-color: #fdf4e3;
    min-height: 100vh;
    padding: 40px;
">
    <!-- Header Section -->
    <div style="
        background: linear-gradient(145deg, #c78d4e, #a76b32);
        color: #fff;
        font-weight: bold;
        padding: 12px 16px;
        border-radius: 10px 10px 0 0;
        border: 1px solid #8c5a2b;
    ">
        ➕ Add New Product
    </div>

    <!-- Form Container -->
    <div style="
        background-color: #fff8ef;
        border: 1px solid #a9793a;
        border-top: none;
        border-radius: 0 0 10px 10px;
        padding: 25px 30px;
        box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        max-width: 100%;
    ">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Product Name -->
            <div style="margin-bottom: 16px;">
                <label style="display:block; font-weight:600; margin-bottom:4px;">Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    style="width:100%; border:1px solid #c7a46c; border-radius:6px; padding:8px; background-color:#fffdf8;">
            </div>

            <!-- Price -->
            <div style="margin-bottom: 16px;">
                <label style="display:block; font-weight:600; margin-bottom:4px;">Price</label>
                <input type="number" name="price" value="{{ old('price') }}"
                    style="width:100%; border:1px solid #c7a46c; border-radius:6px; padding:8px; background-color:#fffdf8;">
            </div>

            <!-- Stock -->
            <div style="margin-bottom: 16px;">
                <label style="display:block; font-weight:600; margin-bottom:4px;">Stock</label>
                <input type="number" name="stock" value="{{ old('stock') }}"
                    style="width:100%; border:1px solid #c7a46c; border-radius:6px; padding:8px; background-color:#fffdf8;">
            </div>

            <!-- Category -->
            <div style="margin-bottom: 16px;">
                <label style="display:block; font-weight:600; margin-bottom:4px;">Category</label>
                <select name="category_id"
                    style="width:100%; border:1px solid #c7a46c; border-radius:6px; padding:8px; background-color:#fffdf8;">
                    <option value="">-- Select Category --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Image -->
            <div style="margin-bottom: 16px;">
                <label style="display:block; font-weight:600; margin-bottom:4px;">Image</label>
                <input type="file" name="image"
                    style="width:100%; border:1px solid #c7a46c; border-radius:6px; padding:6px; background-color:#fffdf8;">
            </div>

            <!-- Active -->
            <div style="margin-bottom: 20px;">
                <label style="display:flex; align-items:center; gap:8px;">
                    <input type="checkbox" name="is_active" value="1" checked
                        style="width:16px; height:16px; accent-color:#a76b32;">
                    <span style="font-weight:500;">Active</span>
                </label>
            </div>

            <!-- Submit Button -->
            <div style="text-align:right;">
                <button type="submit"
                    style="background-color:#b3733d; color:#fff; padding:10px 18px; border:none; border-radius:6px; font-weight:bold; cursor:pointer; border:1px solid #8c5a2b;"
                    onmouseover="this.style.backgroundColor='#a46330'"
                    onmouseout="this.style.backgroundColor='#b3733d'">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

