@extends('layouts.admin')

@section('content')
<div style="font-family:'Roboto',sans-serif;font-size:14px;line-height:1.5;
            max-width:1280px;margin:0 auto;padding:2rem;">

    {{-- HEADER --}}
    <div style="display:flex;align-items:center;gap:1.5rem;margin-bottom:2rem;">
        <a href="{{ route('details.index') }}"
           style="width:56px;height:56px;background:#f4d7a1;
                  border:2px solid #c58b4e;border-radius:12px;
                  display:flex;align-items:center;justify-content:center;
                  box-shadow:0 2px 6px rgba(0,0,0,0.1);
                  color:#5c3b1e;font-size:24px;text-decoration:none;">
            ←
        </a>
        <div>
            <div style="display:flex;align-items:center;gap:0.75rem;">
                <span style="font-size:36px;">📋</span>
                <h1 style="font-size:36px;font-weight:700;color:#2c1810;margin:0;">
                    Detail Pesanan
                </h1>
            </div>
            <p style="margin-top:0.5rem;color:#5a4639;">
                Order #{{ $details->id }} - {{ $details->created_at->format('d F Y') }}
            </p>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(360px,1fr));gap:2rem;">

        {{-- LEFT CARD --}}
        <div style="background:linear-gradient(to bottom right,#f4d7a1,#eac18c);
                    border:2px solid #c58b4e;border-radius:1rem;
                    box-shadow:0 6px 12px rgba(0,0,0,0.1);
                    padding:2.5rem;display:flex;flex-direction:column;gap:1.5rem;">

            <h2 style="font-weight:700;font-size:22px;color:#2c1810;
                       border-bottom:2px solid #c58b4e;padding-bottom:1rem;">
                Informasi Order
            </h2>

            <div>
                <p style="font-size:12px;color:#5a4639;text-transform:uppercase;font-weight:700;">Order ID</p>
                <p style="font-weight:700;font-size:18px;color:#2c1810;margin-left:0.25rem;">{{ $details->id }}</p>
            </div>

            <div>
                <p style="font-size:12px;color:#5a4639;text-transform:uppercase;font-weight:700;">Tanggal Pemesanan</p>
                <p style="font-weight:600;color:#2c1810;margin-left:0.25rem;">{{ $details->created_at->format('d F Y') }}</p>
            </div>

            @if(isset($details->shipping_method))
            <div>
                <p style="font-size:12px;color:#5a4639;text-transform:uppercase;font-weight:700;">Metode Pengiriman</p>
                <p style="font-weight:600;color:#2c1810;margin-left:0.25rem;">{{ $details->shipping_method }}</p>
            </div>
            @endif

            <div>
                <p style="font-size:12px;color:#5a4639;text-transform:uppercase;font-weight:700;">Nama & Alamat Pemesan</p>
                <div style="background:rgba(255,255,255,0.7);border:1px solid #d9b77b;
                            border-radius:0.75rem;padding:1.25rem;">
                    <p style="font-weight:700;color:#2c1810;margin-bottom:0.5rem;">
                        {{ $details->user->name ?? '-' }}
                    </p>
                    <p style="font-size:13px;color:#3b2f2f;">{{ $details->address_text }}</p>
                    @if(isset($details->user->phone))
                    <p style="font-size:13px;color:#3b2f2f;margin-top:0.5rem;">
                        {{ $details->user->phone }}
                    </p>
                    @endif
                </div>
            </div>

            @if(isset($details->subtotal))
            <div>
                <p style="font-size:12px;color:#5a4639;text-transform:uppercase;font-weight:700;">Total Pembelian</p>
                <p style="font-weight:700;font-size:18px;color:#2c1810;margin-left:0.25rem;">
                    IDR {{ number_format($details->subtotal, 0, ',', '.') }}
                </p>
            </div>
            @endif

            @if(isset($details->shipping_cost))
            <div>
                <p style="font-size:12px;color:#5a4639;text-transform:uppercase;font-weight:700;">Ongkos Kirim</p>
                <p style="font-weight:700;font-size:18px;color:#2c1810;margin-left:0.25rem;">
                    IDR {{ number_format($details->shipping_cost, 0, ',', '.') }}
                </p>
            </div>
            @endif

            <div style="padding-top:1.25rem;border-top:2px solid #c58b4e;">
                <p style="font-size:12px;color:#5a4639;text-transform:uppercase;font-weight:700;">Jumlah Terbayar</p>
                <p style="font-weight:700;font-size:28px;color:#8b4513;margin-left:0.25rem;">
                    IDR {{ number_format($details->total, 0, ',', '.') }}
                </p>
            </div>

            <div>
                <p style="font-size:12px;color:#5a4639;text-transform:uppercase;font-weight:700;">Status</p>
                <span style="
                    display:inline-block;padding:0.6rem 1.2rem;border-radius:0.75rem;
                    font-weight:700;font-size:14px;
                    @if($details->status==='completed') background:#d4edda;border:2px solid #5cb85c;color:#27632a;
                    @elseif($details->status==='pending') background:#fff3cd;border:2px solid #ffc107;color:#856404;
                    @elseif($details->status==='processing') background:#d1ecf1;border:2px solid #17a2b8;color:#0c5460;
                    @elseif($details->status==='cancelled') background:#f8d7da;border:2px solid #dc3545;color:#721c24;
                    @endif">
                    {{ ucfirst($details->status) }} Order
                </span>
            </div>

            @if(isset($details->notes) && $details->notes)
            <div>
                <p style="font-size:12px;color:#5a4639;text-transform:uppercase;font-weight:700;">Catatan</p>
                <div style="background:rgba(255,255,255,0.7);border:1px solid #d9b77b;
                            border-radius:0.75rem;padding:1.25rem;">
                    <p style="font-size:13px;color:#3b2f2f;">{{ $details->notes }}</p>
                </div>
            </div>
            @endif
        </div>

        {{-- RIGHT CARD --}}
        <div style="background:linear-gradient(to bottom right,#f4d7a1,#eac18c);
                    border:2px solid #c58b4e;border-radius:1rem;
                    box-shadow:0 6px 12px rgba(0,0,0,0.1);
                    overflow:hidden;">
            <div style="padding:1.5rem 2rem;border-bottom:2px solid #c58b4e;">
                <h2 style="font-weight:700;font-size:20px;color:#2c1810;">Daftar Item</h2>
            </div>

            <div style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;">
                    <thead>
                        <tr style="background:rgba(244,215,161,0.5);border-bottom:2px solid #c58b4e;">
                            <th style="padding:1rem 2rem;text-align:left;font-size:12px;font-weight:700;color:#3b2f2f;text-transform:uppercase;">Deskripsi Item</th>
                            <th style="padding:1rem;text-align:center;font-size:12px;font-weight:700;color:#3b2f2f;text-transform:uppercase;width:120px;">Jumlah</th>
                            <th style="padding:1rem 2rem;text-align:right;font-size:12px;font-weight:700;color:#3b2f2f;text-transform:uppercase;width:160px;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($details->items as $item)
                        <tr style="border-bottom:1px solid #d9b77b;">
                            <td style="padding:1rem 2rem;">
                                <div style="display:flex;align-items:start;gap:1rem;">
                                    <div style="width:80px;height:80px;background:#fff;
                                                border:1px solid #d9b77b;border-radius:0.75rem;
                                                display:flex;align-items:center;justify-content:center;
                                                overflow:hidden;box-shadow:0 1px 4px rgba(0,0,0,0.05);">
                                        @if($item->product->image ?? false)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                 alt="{{ $item->product->name }}" 
                                                 style="width:100%;height:100%;object-fit:contain;">
                                        @else
                                            <span style="font-size:28px;">📦</span>
                                        @endif
                                    </div>
                                    <div style="flex:1;min-width:0;">
                                        <h3 style="font-weight:700;color:#2c1810;margin-bottom:0.25rem;">{{ $item->product->name ?? '-' }}</h3>
                                        <p style="color:#8b4513;font-weight:600;">IDR {{ number_format($item->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </td>
                            <td style="text-align:center;">
                                <span style="background:#fff3cd;border:1px solid #c58b4e;
                                             padding:0.5rem 1rem;border-radius:0.5rem;
                                             font-weight:700;color:#2c1810;">
                                    {{ $item->qty }}
                                </span>
                            </td>
                            <td style="text-align:right;padding-right:2rem;">
                                <span style="font-weight:700;color:#2c1810;">
                                    IDR {{ number_format($item->price * $item->qty, 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="padding:1.5rem 2rem;background:linear-gradient(to right,#f4d7a1,#eac18c);
                        border-top:2px solid #c58b4e;display:flex;justify-content:space-between;align-items:center;">
                <span style="font-weight:700;font-size:18px;color:#2c1810;">Grand Total</span>
                <span style="font-weight:700;font-size:28px;color:#8b4513;">
                    IDR {{ number_format($details->total, 0, ',', '.') }}
                </span>
            </div>
        </div>
    </div>
</div>
@endsection

