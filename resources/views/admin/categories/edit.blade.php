@extends('layouts.admin')

@section('title', 'Edit Category')
@section('page-title', 'Edit Category')

@section('content')
<div style="
    font-family: 'Roboto', sans-serif;
    font-size: 14px;
    line-height: 1.5;
    background-color: #fdf4e3;
    min-height: 80vh;
    padding: 30px;
    display: flex;
    justify-content: center;
">
    <div style="width: 90%; max-width: 1000px;">
        <!-- Header -->
        <div style="
            background: linear-gradient(145deg, #c78d4e, #a76b32);
            color: #fff;
            font-weight: bold;
            padding: 14px 18px;
            border-radius: 12px 12px 0 0;
            border: 1px solid #8c5a2b;
            font-size: 16px;
        ">
            Edit Category
        </div>

        <!-- Form -->
        <div style="
            background-color: #fff8ef;
            border: 1px solid #a9793a;
            border-top: none;
            border-radius: 0 0 12px 12px;
            padding: 35px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        ">
            <form action="{{ route('categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div style="margin-bottom: 20px;">
                    <label style="display:block; font-weight:bold; margin-bottom:8px;">Category Name <span style="color:red;">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                        style="width:100%; padding:12px 14px; border:1px solid #b07a3f; border-radius:8px; background-color:#fff; font-size:15px;">
                </div>

                <!-- Slug -->
                <div style="margin-bottom: 20px;">
                    <label style="display:block; font-weight:bold; margin-bottom:8px;">Slug (Optional)</label>
                    <input type="text" name="slug" value="{{ old('slug', $category->slug) }}"
                        placeholder="auto-generated if empty"
                        style="width:100%; padding:12px 14px; border:1px solid #b07a3f; border-radius:8px; background-color:#fff; font-size:15px;">
                </div>

                <!-- Is Active -->
                <div style="margin-bottom: 20px;">
                    <label style="display:block; font-weight:bold; margin-bottom:8px;">Is Active</label>
                    <input type="checkbox" name="is_active" {{ $category->is_active ? 'checked' : '' }} style="accent-color:#a76b32; transform: scale(1.2);">
                </div>

                <!-- Buttons -->
                <div style="display:flex; gap:12px;">
                    <button type="submit"
                        style="background-color:#b3733d; color:#fff; border:none; padding:10px 18px; border-radius:8px; cursor:pointer; font-weight:bold;">
                        Update
                    </button>

                    <a href="{{ route('categories.index') }}"
                        style="background-color:#d2b48c; color:#4b2e05; text-decoration:none; padding:10px 18px; border-radius:8px; border:1px solid #a9793a; font-weight:bold;">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


