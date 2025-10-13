@extends('layouts.admin')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

    body {
        font-family: 'Roboto', sans-serif;
        font-size: 14px;
        line-height: 1.5;
        color: #1f2937;
    }

    /* Card order */
    .order-card {
        margin-bottom: 2rem;
        border-width: 2px; /* lebih tebal */
        border-radius: 1rem; /* tumpul */
        padding: 1.5rem; /* beri ruang dalam */
        background: linear-gradient(to bottom right, #f7e0b2, #e5b982);
    }

    /* Form Search */
    .search-form {
        background-color: white;
        border: 2px solid #fbbf24;
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 2.5rem; /* jarak dengan card order */
        box-shadow: 0 4px 10px rgba(251, 191, 36, 0.2);
    }

    .search-form input[type="text"] {
        height: 56px; /* lebih tinggi */
        font-size: 15px;
        padding: 0 1.5rem;
        flex: 1;
        min-width: 340px;
    }

    .search-form select {
        height: 56px;
        font-size: 15px;
        padding: 0 1rem;
    }

    .search-form button {
        height: 56px;
        font-size: 15px;
        font-weight: bold;
        padding: 0 2rem;
    }

    /* Ukuran gambar produk diperkecil */
    .product-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 0.75rem;
    }
</style>

<div class="space-y-6 p-6">
    {{-- Header --}}
    <div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">🧾 Order History</h1>
        <p class="text-base text-gray-600">Lihat dan kelola riwayat pesanan Anda</p>
    </div>

    {{-- Search & Filter --}}
    <form method="GET" action="{{ route('details.index') }}" class="search-form">
        <div class="flex flex-wrap items-center gap-4">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}" 
                   placeholder="🔍 Search by Order ID or Product..."
                   class="border border-gray-300 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 focus:bg-white shadow-sm transition-all">

            <select name="status" 
                    class="border border-gray-300 bg-gray-50 rounded-xl font-semibold focus:outline-none focus:ring-2 focus:ring-amber-400 shadow-sm min-w-[200px] cursor-pointer transition-all">
                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>📋 All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>🔄 Processing</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>✅ Completed</option>
            </select>

            <button type="submit" 
                    class="bg-gradient-to-br from-amber-400 via-amber-500 to-orange-500 text-gray-900 rounded-xl hover:from-amber-500 hover:via-amber-600 hover:to-orange-600 transition-all duration-300 shadow-lg hover:shadow-amber-500/50 hover:scale-105 border border-amber-600">
                🔍 SEARCH
            </button>
        </div>
    </form>

    {{-- Order List --}}
    <div>
        @forelse($orders as $order)
        <div class="order-card !bg-gradient-to-br !from-amber-200 !to-orange-100 shadow-lg border border-amber-400 overflow-hidden">
            {{-- Header Info --}}
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 p-6 bg-gradient-to-r from-amber-200 to-orange-200 border-b border-amber-400 rounded-t-xl">
                <div>
                    <p class="text-base text-gray-700 mb-1 font-bold">📅 {{ $order->created_at->format('d F Y') }}</p>
                    <p class="text-lg text-gray-900 font-extrabold">Order #{{ $order->id }}</p>
                    <p class="text-sm text-gray-700 mt-1 font-semibold">Status: {{ strtoupper(substr($order->status, 0, 2)) }}</p>
                </div>
                
                <div>
                    <p class="text-sm text-gray-700 mb-2 font-bold tracking-wide">STATUS</p>
                    <span class="inline-block px-4 py-1.5 rounded-lg text-sm font-bold shadow-sm
                        {{ $order->status === 'completed' ? 'bg-green-200 text-green-900 border border-green-400' : '' }}
                        {{ $order->status === 'pending' ? 'bg-yellow-200 text-yellow-900 border border-yellow-400' : '' }}
                        {{ $order->status === 'processing' ? 'bg-blue-200 text-blue-900 border border-blue-400' : '' }}
                        {{ $order->status === 'cancelled' ? 'bg-red-200 text-red-900 border border-red-400' : '' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                
                <div>
                    <p class="text-sm text-gray-700 mb-2 font-bold tracking-wide">PAYMENT LEFT</p>
                    <p class="text-lg font-extrabold text-gray-900">IDR {{ number_format($order->total, 0, ',', '.') }}</p>
                </div>
                
                <div>
                    <p class="text-sm text-gray-700 mb-2 font-bold tracking-wide">ITEMS COUNT</p>
                    <p class="text-lg font-extrabold text-gray-900">{{ $order->items->count() }} Item</p>
                </div>
                
                <div class="flex items-start justify-end">
                    <a href="{{ route('details.show', $order->id) }}" 
                        class="px-5 py-2 bg-gradient-to-br from-amber-300 via-amber-400 to-orange-400 
                                text-amber-950 font-semibold text-sm rounded-lg 
                                border border-amber-500 shadow-sm 
                                hover:from-amber-400 hover:via-amber-500 hover:to-orange-500 
                                hover:shadow-[0_0_10px_rgba(251,191,36,0.5)] 
                                hover:scale-105 active:scale-95 transition-all duration-300">
                            📋 DETAILS
                    </a>
                </div>
            </div>

            {{-- Product Items --}}
            <div class="p-8 space-y-4">
                @foreach($order->items as $item)
                <div class="flex gap-6 items-start pb-4 {{ !$loop->last ? 'border-b border-amber-200' : '' }}">
                    <div class="bg-white flex items-center justify-center rounded-xl overflow-hidden flex-shrink-0 shadow-md border border-gray-200">
                        @if($item->product->image ?? false)
                            <img src="{{ asset('storage/' . $item->product->image) }}" 
                                 alt="{{ $item->product->name }}" 
                                 class="product-image">
                        @else
                            <span class="text-4xl">📦</span>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-amber-700 text-lg mb-1">
                            {{ $item->product->name ?? 'Produk tidak tersedia' }}
                        </h4>
                        <p class="text-gray-900 font-bold text-base mb-1">IDR {{ number_format($item->price, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-800 font-semibold">
                            Quantity: <span class="font-bold text-gray-900">{{ $item->quantity }} Item</span>
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @empty
        <div class="bg-gradient-to-br from-amber-50/80 to-orange-50/60 rounded-2xl shadow-lg p-12 text-center border border-amber-200/50">
            <div class="text-gray-400 text-5xl mb-3">📦</div>
            <p class="text-gray-600 text-base font-semibold">Belum ada pesanan</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="flex justify-center mt-6">
        {{ $orders->links() }}
    </div>
</div>
@endsection









