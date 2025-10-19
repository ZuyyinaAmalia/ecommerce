@extends('layouts.admin')

@section('title', 'Products')
@section('page-title', 'Products')

@section('content')
<div style="
    font-family: 'Roboto', sans-serif;
    font-size: 14px;
    line-height: 1.5;
    background-color: #fdf4e3;
    min-height: 100vh;
    padding: 30px;
">
    <!-- Header Section -->
    <div style="
        background: linear-gradient(145deg, #c78d4e, #a76b32);
        color: #fff;
        font-weight: bold;
        padding: 12px 16px;
        border-radius: 10px 10px 0 0;
        border: 1px solid #8c5a2b;
        display: flex;
        justify-content: space-between;
        align-items: center;
    ">
        <span>Products</span>
        <a href="{{ route('products.create') }}" 
           style="background-color:#b3733d; color:#fff; text-decoration:none; padding:8px 14px; border-radius:6px; font-weight:bold; border:1px solid #8c5a2b;">
            + Add Product
        </a>
    </div>

    <!-- Table Container -->
    <div style="
        background-color: #fff8ef;
        border: 1px solid #a9793a;
        border-top: none;
        border-radius: 0 0 10px 10px;
        padding: 25px;
        box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        overflow-x: auto;
    ">
        @if(session('success'))
            <div style="background-color:#e6f4ea; border:1px solid #9ccc9c; color:#27632a; padding:10px 14px; border-radius:6px; margin-bottom:15px;">
                {{ session('success') }}
            </div>
        @endif

        <table style="
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #c09055;
            background-color: #fffdf8;
        ">
            <thead style="background-color:#f1e0c3;">
                <tr>
                    <th style="padding:10px; border:1px solid #c09055; text-align:left;">Image</th>
                    <th style="padding:10px; border:1px solid #c09055; text-align:left;">Name</th>
                    <th style="padding:10px; border:1px solid #c09055; text-align:left;">Category</th>
                    <th style="padding:10px; border:1px solid #c09055; text-align:left;">Price</th>
                    <th style="padding:10px; border:1px solid #c09055; text-align:left;">Stock</th>
                    <th style="padding:10px; border:1px solid #c09055; text-align:left;">Active</th>
                    <th style="padding:10px; border:1px solid #c09055; text-align:center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr style="background-color:#fff; border-bottom:1px solid #d8b377; transition:background-color 0.2s;"
                    onmouseover="this.style.backgroundColor='#fff2df'"
                    onmouseout="this.style.backgroundColor='#fff'">
                    <td style="padding:8px; border:1px solid #d8b377;">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="Image" style="width:60px; height:60px; object-fit:cover; border-radius:6px; border:1px solid #c09055;">
                        @else
                            <span style="color:#9c8b72;">No Image</span>
                        @endif
                    </td>
                    <td style="padding:8px; border:1px solid #d8b377;">{{ $product->name }}</td>
                    <td style="padding:8px; border:1px solid #d8b377;">{{ $product->category->name ?? '-' }}</td>
                    <td style="padding:8px; border:1px solid #d8b377;">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                    <td style="padding:8px; border:1px solid #d8b377;">{{ $product->stock }}</td>
                    <td style="padding:8px; border:1px solid #d8b377;">
                        @if($product->is_active)
                            <span style="color:#2b6b2b; font-weight:bold;">Active</span>
                        @else
                            <span style="color:#9b9b9b;">Inactive</span>
                        @endif
                    </td>
                    <td style="padding:8px; border:1px solid #d8b377; text-align:center;">
                        <a href="{{ route('products.edit', $product) }}" 
                           style="color:#4b2e05; text-decoration:none; font-weight:bold; margin-right:10px;">Edit</a>

                        <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this product?')"
                                style="color:#a7342b; background:none; border:none; cursor:pointer; font-weight:bold;">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div style="padding-top:15px;">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection


