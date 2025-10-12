@extends('layouts.admin')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap');
    
    .roboto-font {
        font-family: 'Roboto', sans-serif;
        font-size: 14px;
        line-height: 1.5;
    }
    
    .roboto-font h1 { font-size: 36px; font-weight: 700; line-height: 1.5; }
    .roboto-font h2 { font-size: 22px; font-weight: 700; line-height: 1.5; }
    .roboto-font h3 { font-size: 18px; font-weight: 700; line-height: 1.5; }
    .roboto-font .text-xs { font-size: 12px; line-height: 1.5; }
    .roboto-font .text-sm { font-size: 13px; line-height: 1.5; }
    .roboto-font .text-base { font-size: 14px; line-height: 1.5; }
    .roboto-font .text-lg { font-size: 16px; line-height: 1.5; }
    .roboto-font .text-xl { font-size: 18px; line-height: 1.5; }
    .roboto-font .text-2xl { font-size: 22px; line-height: 1.5; }
    .roboto-font .text-3xl { font-size: 26px; line-height: 1.5; }
    .roboto-font .text-4xl { font-size: 36px; line-height: 1.5; }
    
    .roboto-font p,
    .roboto-font span,
    .roboto-font div { line-height: 1.5; }
</style>

<div class="roboto-font space-y-8 max-w-7xl mx-auto p-8">
    {{-- Header with Back Button --}}
    <div class="flex items-center gap-6 mb-4">
        <a href="{{ route('details.index') }}" 
           class="w-14 h-14 bg-amber-100 rounded-xl shadow-md flex items-center justify-center hover:bg-amber-200 transition-colors border-2 border-amber-300">
            <span class="text-2xl text-amber-800">←</span>
        </a>
        <div>
            <div class="flex items-center gap-3">
                <span class="text-4xl">📋</span>
                <h1 class="text-4xl font-bold text-gray-900">Detail Pesanan</h1>
            </div>
            <p class="text-base text-gray-600 mt-3">Order #{{ $details->id }} - {{ $details->created_at->format('d F Y') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Left Column - Informasi Order --}}
        <div class="lg:col-span-1">
            <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl shadow-lg border-2 border-amber-300 p-10 space-y-8">
                <h2 class="font-bold text-2xl text-gray-900 mb-8 pb-4 border-b-2 border-amber-300">Informasi Order</h2>
                
                {{-- Order ID --}}
                <div class="space-y-3">
                    <p class="text-sm text-gray-600 uppercase font-bold tracking-wide">Order ID</p>
                    <p class="font-bold text-xl text-gray-900 ml-1">{{ $details->id }}</p>
                </div>

                {{-- Tanggal Pemesanan --}}
                <div class="space-y-3">
                    <p class="text-sm text-gray-600 uppercase font-bold tracking-wide">Tanggal Pemesanan</p>
                    <p class="font-semibold text-base text-gray-900 ml-1">{{ $details->created_at->format('d F Y') }}</p>
                </div>

                {{-- Metode Pengiriman (jika ada) --}}
                @if(isset($details->shipping_method))
                <div class="space-y-3">
                    <p class="text-sm text-gray-600 uppercase font-bold tracking-wide">Metode Pengiriman</p>
                    <p class="font-semibold text-base text-gray-900 ml-1">{{ $details->shipping_method }}</p>
                </div>
                @endif

                {{-- Nama & Alamat Pemesan --}}
                <div class="space-y-3">
                    <p class="text-sm text-gray-600 uppercase font-bold tracking-wide">Nama & Alamat Pemesan</p>
                    <div class="bg-white/70 rounded-xl p-6 border border-amber-200">
                        <p class="font-bold text-base text-gray-900 mb-3">{{ $details->user->name ?? '-' }}</p>
                        <p class="text-sm text-gray-700 leading-relaxed">{{ $details->address_text }}</p>
                        @if(isset($details->user->phone))
                        <p class="text-sm text-gray-700 mt-2">{{ $details->user->phone }}</p>
                        @endif
                    </div>
                </div>

                {{-- Total Pembelian --}}
                @if(isset($details->subtotal))
                <div class="space-y-3">
                    <p class="text-sm text-gray-600 uppercase font-bold tracking-wide">Total Pembelian</p>
                    <p class="font-bold text-xl text-gray-900 ml-1">IDR {{ number_format($details->subtotal, 0, ',', '.') }}</p>
                </div>
                @endif

                {{-- Ongkos Kirim (jika ada) --}}
                @if(isset($details->shipping_cost))
                <div class="space-y-3">
                    <p class="text-sm text-gray-600 uppercase font-bold tracking-wide">Ongkos Kirim</p>
                    <p class="font-bold text-xl text-gray-900 ml-1">IDR {{ number_format($details->shipping_cost, 0, ',', '.') }}</p>
                </div>
                @endif

                {{-- Jumlah Terbayar --}}
                <div class="pt-8 border-t-2 border-amber-300 space-y-3">
                    <p class="text-sm text-gray-600 uppercase font-bold tracking-wide">Jumlah Terbayar</p>
                    <p class="font-bold text-3xl text-amber-700 ml-1">IDR {{ number_format($details->total, 0, ',', '.') }}</p>
                </div>

                {{-- Status --}}
                <div class="space-y-3">
                    <p class="text-sm text-gray-600 uppercase font-bold tracking-wide">Status</p>
                    <span class="inline-flex items-center px-5 py-3 rounded-xl text-base font-bold
                        {{ $details->status === 'completed' ? 'bg-green-100 text-green-800 border-2 border-green-400' : '' }}
                        {{ $details->status === 'pending' ? 'bg-yellow-100 text-yellow-800 border-2 border-yellow-400' : '' }}
                        {{ $details->status === 'processing' ? 'bg-blue-100 text-blue-800 border-2 border-blue-400' : '' }}
                        {{ $details->status === 'cancelled' ? 'bg-red-100 text-red-800 border-2 border-red-400' : '' }}">
                        {{ ucfirst($details->status) }} Order
                    </span>
                </div>

                {{-- Catatan (jika ada) --}}
                @if(isset($details->notes) && $details->notes)
                <div class="space-y-3">
                    <p class="text-sm text-gray-600 uppercase font-bold tracking-wide">Catatan</p>
                    <div class="bg-white/70 rounded-xl p-6 border border-amber-200">
                        <p class="text-sm text-gray-700 leading-loose">{{ $details->notes }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Right Column - Daftar Item --}}
        <div class="lg:col-span-2">
            <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl shadow-lg border border-amber-200 overflow-hidden">
                <div class="px-8 py-6 border-b-2 border-amber-200">
                    <h2 class="font-bold text-xl text-gray-900">Daftar Item</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-amber-100/50 border-b-2 border-amber-200">
                                <th class="px-8 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wide">Deskripsi Item</th>
                                <th class="px-8 py-5 text-center text-xs font-bold text-gray-700 uppercase tracking-wide w-28">Jumlah</th>
                                <th class="px-8 py-5 text-right text-xs font-bold text-gray-700 uppercase tracking-wide w-44">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-amber-200">
                            @foreach($details->items as $item)
                            <tr class="hover:bg-amber-100/30 transition-colors">
                                <td class="px-8 py-6">
                                    <div class="flex items-start gap-5">
                                        {{-- Product Image --}}
                                        <div class="w-20 h-20 bg-white rounded-xl flex items-center justify-center flex-shrink-0 overflow-hidden shadow-sm p-2 border border-amber-200">
                                            @if($item->product->image ?? false)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                     alt="{{ $item->product->name }}" 
                                                     class="w-full h-full object-contain">
                                            @else
                                                <span class="text-3xl">📦</span>
                                            @endif
                                        </div>
                                        
                                        {{-- Product Info --}}
                                        <div class="flex-1 min-w-0 py-1">
                                            <h3 class="font-bold text-gray-900 mb-2 text-base leading-snug">{{ $item->product->name ?? '-' }}</h3>
                                            <p class="text-sm text-orange-700 font-semibold">IDR {{ number_format($item->price, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <span class="inline-block bg-amber-100 px-4 py-2 rounded-lg font-bold text-gray-900 border border-amber-300">{{ $item->qty }}</span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <span class="font-bold text-lg text-gray-900">IDR {{ number_format($item->price * $item->qty, 0, ',', '.') }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Grand Total --}}
                <div class="px-8 py-6 bg-gradient-to-r from-amber-100 to-orange-100 border-t-2 border-amber-300">
                    <div class="flex justify-between items-center">
                        <span class="text-xl font-bold text-gray-900">Grand Total</span>
                        <span class="text-3xl font-bold text-amber-700">IDR {{ number_format($details->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
