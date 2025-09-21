@extends('layouts.admin')

@section('title','Order Detail')
@section('page-title','Detail Pesanan #'.$order->id)

@section('content')
<div class="bg-white shadow rounded-lg p-6 space-y-4">

    <div>
        <h3 class="font-semibold">Customer</h3>
        <p>{{ $order->user->name }} ({{ $order->user->email }})</p>
    </div>

    <div>
        <h3 class="font-semibold">Produk</h3>
        <table class="min-w-full text-sm">
            <thead>
                <tr class="border-b">
                    <th class="px-3 py-2">Produk</th>
                    <th class="px-3 py-2">Harga</th>
                    <th class="px-3 py-2">Qty</th>
                    <th class="px-3 py-2">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr class="border-b">
                    <td class="px-3 py-2">{{ $item->product->name }}</td>
                    <td class="px-3 py-2">Rp {{ number_format($item->price,0,',','.') }}</td>
                    <td class="px-3 py-2">{{ $item->quantity }}</td>
                    <td class="px-3 py-2">Rp {{ number_format($item->price * $item->quantity,0,',','.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div>
        <h3 class="font-semibold">Total</h3>
        <p class="text-lg font-bold">Rp {{ number_format($order->total,0,',','.') }}</p>
    </div>

</div>
@endsection
