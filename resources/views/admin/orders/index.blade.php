@extends('layouts.admin')

@section('title','Orders')
@section('page-title','Order Management')

@section('content')
<div style="font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 1.5; background-color: #fffaf0; padding: 40px;">

    <div style="background-color: #fffdf7; border: 2px solid #d6a15f; border-radius: 16px; box-shadow: 0 4px 10px rgba(0,0,0,0.08); overflow: hidden;">

        {{-- Header --}}
        <div style="padding: 20px 32px; background: linear-gradient(to right, #fff3d6, #ffe9c8); border-bottom: 2px solid #d6a15f;">
            <h2 style="font-size: 20px; font-weight: bold; color: #3b2f22; margin-bottom: 6px;">Daftar Pesanan</h2>
            <p style="color: #6b5b4a; font-size: 13px;">Kelola pesanan dan update status</p>
        </div>

        {{-- Table --}}
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #fff6e4; border-bottom: 2px solid #d6a15f;">
                        <th style="padding: 14px 24px; text-align: left; font-weight: bold; color: #3b2f22; width: 60px;">#</th>
                        <th style="padding: 14px 24px; text-align: left; font-weight: bold; color: #3b2f22;">Customer</th>
                        <th style="padding: 14px 24px; text-align: left; font-weight: bold; color: #3b2f22;">Total</th>
                        <th style="padding: 14px 24px; text-align: left; font-weight: bold; color: #3b2f22; width: 180px;">Status</th>
                        <th style="padding: 14px 24px; text-align: left; font-weight: bold; color: #3b2f22;">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr style="border-bottom: 1px solid #e0c79d; background-color: #fff; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#fff5e1'" onmouseout="this.style.backgroundColor='#fff'">
                        <td style="padding: 16px 24px; font-weight: 600; color: #3b2f22;">{{ $order->id }}</td>
                        <td style="padding: 16px 24px;">
                            <div style="font-weight: 600; color: #3b2f22;">{{ $order->user->name }}</div>
                            <div style="font-size: 13px; color: #6b5b4a;">{{ $order->user->email }}</div>
                        </td>
                        <td style="padding: 16px 24px; font-weight: bold; color: #3b2f22;">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        </td>
                        <td style="padding: 16px 24px;">
                            <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" style="
                                    width: 100%;
                                    padding: 8px 12px;
                                    border: 2px solid #d1b27b;
                                    border-radius: 8px;
                                    font-weight: 600;
                                    font-size: 13px;
                                    cursor: pointer;
                                    background-color:
                                        {{ $order->status == 'pending' ? '#fff9e6' : 
                                           ($order->status == 'processing' ? '#e7f1ff' : 
                                           ($order->status == 'completed' ? '#e6ffee' : '#ffeaea')) }};
                                    color:
                                        {{ $order->status == 'pending' ? '#a67c00' : 
                                           ($order->status == 'processing' ? '#1a5fb4' : 
                                           ($order->status == 'completed' ? '#0b7a3e' : '#b91c1c')) }};
                                    border-color:
                                        {{ $order->status == 'pending' ? '#f4c84a' : 
                                           ($order->status == 'processing' ? '#87b6ff' : 
                                           ($order->status == 'completed' ? '#8ad8a1' : '#f18a8a')) }};
                                ">
                                    <option value="pending" {{ $order->status=='pending'?'selected':'' }}>Pending</option>
                                    <option value="processing" {{ $order->status=='processing'?'selected':'' }}>Processing</option>
                                    <option value="completed" {{ $order->status=='completed'?'selected':'' }}>Completed</option>\
                                </select>
                            </form>
                        </td>
                        <td style="padding: 16px 24px; color: #3b2f22;">
                            {{ $order->created_at->format('d M Y') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 60px; text-align: center; color: #8b7765;">
                            <div style="font-size: 40px; margin-bottom: 8px;">📦</div>
                            Belum ada pesanan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div style="padding: 18px 32px; background-color: #fff6e4; border-top: 2px solid #d6a15f;">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection


