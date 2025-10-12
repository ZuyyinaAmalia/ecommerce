@extends('layouts.admin')

@section('title','Orders')
@section('page-title','Order Management')

@section('content')
<div class="bg-amber-50/50 rounded-2xl shadow-lg overflow-hidden border border-amber-200/50">
    {{-- Header --}}
    <div class="px-8 py-6 bg-gradient-to-r from-amber-100/60 to-orange-100/40 border-b border-amber-200">
        <h2 class="text-xl font-bold text-gray-900">Daftar Pesanan</h2>
        <p class="text-sm text-gray-600 mt-1">Kelola pesanan dan update status</p>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-orange-50/30 border-b-2 border-amber-200">
                    <th class="px-8 py-4 text-left text-sm font-bold text-gray-700 w-24">#</th>
                    <th class="px-8 py-4 text-left text-sm font-bold text-gray-700">Customer</th>
                    <th class="px-8 py-4 text-left text-sm font-bold text-gray-700">Total</th>
                    <th class="px-8 py-4 text-left text-sm font-bold text-gray-700 w-52">Status</th>
                    <th class="px-8 py-4 text-left text-sm font-bold text-gray-700">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr class="hover:bg-amber-100/50 transition-colors duration-150 border-b border-amber-200/50">
                    <td class="px-8 py-5">
                        <span class="font-semibold text-gray-900">{{ $order->id }}</span>
                    </td>
                    <td class="px-8 py-5">
                        <p class="font-semibold text-gray-900">{{ $order->user->name }}</p>
                        <p class="text-sm text-gray-500 mt-0.5">{{ $order->user->email }}</p>
                    </td>
                    <td class="px-8 py-5">
                        <span class="font-bold text-gray-900">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </td>
                    <td class="px-8 py-5">
                        <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" 
                                class="w-full text-sm font-semibold rounded-lg px-4 py-2.5 border-2 cursor-pointer focus:outline-none focus:ring-2 focus:ring-amber-500
                                {{ $order->status == 'pending' ? 'border-yellow-300 bg-yellow-50 text-yellow-800' : '' }}
                                {{ $order->status == 'processing' ? 'border-blue-300 bg-blue-50 text-blue-800' : '' }}
                                {{ $order->status == 'completed' ? 'border-green-300 bg-green-50 text-green-800' : '' }}
                                {{ $order->status == 'cancelled' ? 'border-red-300 bg-red-50 text-red-800' : '' }}">
                                <option value="pending" {{ $order->status=='pending'?'selected':'' }}>Pending</option>
                                <option value="processing" {{ $order->status=='processing'?'selected':'' }}>Processing</option>
                                <option value="completed" {{ $order->status=='completed'?'selected':'' }}>Completed</option>
                                <option value="cancelled" {{ $order->status=='cancelled'?'selected':'' }}>Cancelled</option>
                            </select>
                        </form>
                    </td>
                    <td class="px-8 py-5 text-gray-700">
                        {{ $order->created_at->format('d M Y') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-16 text-center">
                        <div class="text-gray-400 text-5xl mb-3">📦</div>
                        <p class="text-gray-500">Belum ada pesanan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="px-8 py-5 bg-orange-50/30 border-t border-amber-200">
        {{ $orders->links() }}
    </div>
</div>
@endsection

