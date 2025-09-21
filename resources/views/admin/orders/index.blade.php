@extends('layouts.admin')

@section('title','Orders')
@section('page-title','Order Management')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-lg font-semibold mb-4">Daftar Pesanan</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="border-b">
                    <th class="px-3 py-2">#</th>
                    <th class="px-3 py-2">Customer</th>
                    <th class="px-3 py-2">Total</th>
                    <th class="px-3 py-2">Status</th>
                    <th class="px-3 py-2">Tanggal</th>
                    <th class="px-3 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-3 py-2">{{ $order->id }}</td>
                    <td class="px-3 py-2">{{ $order->user->name }}</td>
                    <td class="px-3 py-2">Rp {{ number_format($order->total,0,',','.') }}</td>
                    <td class="px-3 py-2">
                        <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="border rounded px-2 py-1 text-sm">
                                <option value="pending" {{ $order->status=='pending'?'selected':'' }}>Pending</option>
                                <option value="processing" {{ $order->status=='processing'?'selected':'' }}>Processing</option>
                                <option value="completed" {{ $order->status=='completed'?'selected':'' }}>Completed</option>
                                <option value="cancelled" {{ $order->status=='cancelled'?'selected':'' }}>Cancelled</option>
                            </select>
                        </form>
                    </td>
                    <td class="px-3 py-2">{{ $order->created_at->format('d M Y') }}</td>
                    <td class="px-3 py-2">
                        <a href="{{ route('orders.show',$order->id) }}" class="text-emerald-600 hover:underline">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection
