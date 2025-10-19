@extends('layouts.admin')

@section('title','Dashboard - E-Commerce')
@section('page-title','Overview')

@section('content')
<!-- Import Roboto -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

<div style="font-family:'Roboto',sans-serif; padding:30px;">

    {{-- CARD: Categories --}}
    <div class="order-card shadow-lg border overflow-hidden"
         style="background: linear-gradient(to bottom right, #d3a76b, #ffdeb6ff);
                border:1px solid #b5783c;
                border-radius: 16px;
                box-shadow: 0 4px 14px rgba(0,0,0,0.15);
                padding: 28px 32px;
                width: 100%;
                font-family: 'Roboto', sans-serif;
                line-height: 1.5;
                margin: 0 auto;">

        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
            <h2 style="color:#3b240a; font-weight:700; font-size:20px; display:flex; align-items:center;">
                📂 <span style="margin-left:8px;">Categories</span>
            </h2>
            <a href="{{ route('categories.create') }}"
               style="background-color:#8b5e34;
                      color:#fff;
                      padding:10px 20px;
                      border-radius:8px;
                      font-weight:500;
                      text-decoration:none;
                      transition:0.2s;">
                + New Category
            </a>
        </div>

        <table style="width:100%; border-collapse:collapse; font-size:15px; color:#2e1a05;">
            <thead style="background-color:rgba(255,255,255,0.2);">
                <tr>
                    <th style="padding:12px 10px; text-align:left;">#</th>
                    <th style="padding:12px 10px; text-align:left;">Name</th>
                    <th style="padding:12px 10px; text-align:left;">Created At</th>
                    <th style="padding:12px 10px; text-align:left;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $index => $category)
                <tr style="border-top:1px solid rgba(255,255,255,0.25);">
                    <td style="padding:10px 10px;">{{ $index + 1 }}</td>
                    <td style="padding:10px 10px;">{{ $category->name }}</td>
                    <td style="padding:10px 10px;">{{ $category->created_at->format('Y-m-d') }}</td>
                    <td style="padding:10px 10px;">
                        <a href="{{ route('categories.edit', $category->id) }}"
                           style="color:#4b2e05; font-weight:500; margin-right:10px; text-decoration:none;">Edit</a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    style="color:#7a4a2b; font-weight:500; border:none; background:none; cursor:pointer;">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
@endsection







