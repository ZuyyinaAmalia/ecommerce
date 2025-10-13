@extends('layouts.admin')

@section('title', 'Dashboard - E-Commerce')
@section('page-title', 'Overview Dashboard')

@section('content')

{{-- STYLE GLOBAL --}}
<style>
    .dashboard-page {
        font-family: 'Roboto', sans-serif;
        font-size: 14px;
        line-height: 1.5;
        background-color: #4b2e05;
        padding: 20px;
    }

    .card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    }

    /* ubah hanya elemen di dalam konten dashboard, bukan di navbar */
    .dashboard-page h3,
    .dashboard-page h4,
    .dashboard-page p,
    .dashboard-page th,
    .dashboard-page td,
    .dashboard-page span {
        color: #333;
    }



    .grid {
        display: grid;
        gap: 20px;
    }

    .section-title {
        font-weight: bold;
        font-size: 16px;
        color: #222;
        margin-bottom: 10px;
    }

    .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th, td {
        padding: 10px 12px;
        border-bottom: 1px solid #eee;
    }

    th {
        background-color: #fafafa;
        text-align: left;
        font-weight: 600;
    }

    tr:hover {
        background-color: #fefce8;
    }
</style>

<div class="grid" style="grid-template-columns: 2fr 1fr; gap: 24px;">

    {{-- LEFT MAIN CONTENT --}}
    <div>

        {{-- KPI CARDS --}}
        <div class="grid" style="grid-template-columns: repeat(auto-fit,minmax(250px,1fr)); gap: 20px;">
            {{-- Revenue --}}
            <div class="card" style="border-left: 4px solid #fbbf24;">
                <div class="card-header">
                    <div>
                        <p>Total Pendapatan</p>
                        <h3 style="font-size:20px;font-weight:700;">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</h3>
                        <p style="font-size:12px;color:#777;">Bulan ini</p>
                    </div>
                    <div style="background:#fef3c7;padding:10px;border-radius:10px;">💰</div>
                </div>
            </div>

            {{-- Orders --}}
            <div class="card" style="border-left: 4px solid #3b82f6;">
                <div class="card-header">
                    <div>
                        <p>Total Pesanan</p>
                        <h3 style="font-size:20px;font-weight:700;">{{ $totalOrder ?? 0 }}</h3>
                        <p style="font-size:12px;color:#777;">Pesanan aktif</p>
                    </div>
                    <div style="background:#dbeafe;padding:10px;border-radius:10px;">🛍️</div>
                </div>
            </div>

            {{-- Customers --}}
            <div class="card" style="border-left: 4px solid #22c55e;">
                <div class="card-header">
                    <div>
                        <p>Total Pelanggan</p>
                        <h3 style="font-size:20px;font-weight:700;">{{ $totalCustomer ?? 0 }}</h3>
                        <p style="font-size:12px;color:#777;">Pelanggan terdaftar</p>
                    </div>
                    <div style="background:#dcfce7;padding:10px;border-radius:10px;">👥</div>
                </div>
            </div>
        </div>

        {{-- Sales Chart --}}
        <div class="card rounded-2xl p-6 shadow-lg bg-white">
            <div class="flex justify-between items-center mb-6">
                <div class="space-y-1">
                    <h3 class="text-lg font-bold text-gray-900">Analisis Penjualan</h3>
                    <p class="text-sm text-gray-600">Statistik penjualan bulanan</p>
                </div>
                <span class="bg-amber-100 text-amber-800 px-3 py-1.5 rounded-lg text-sm font-semibold">
                    {{ now()->translatedFormat('M Y') }}
                </span>
            </div>
            <div style="height: 280px; width: 100%; position: relative; overflow: hidden;">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        {{-- Produk Terlaris --}}
        <div class="card">
            <div class="card-header">
                <h3 class="section-title">Produk Terlaris</h3>
                <span>🔥</span>
            </div>
            <div style="max-height:280px;overflow-y:auto;">
                @forelse($topSelling as $index => $product)
                    <div style="display:flex;align-items:center;gap:12px;border:1px solid #eee;padding:10px;border-radius:10px;margin-bottom:10px;">
                        <div style="background:#fef3c7;width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:8px;font-weight:600;color:#92400e;">
                            {{ $index + 1 }}
                        </div>
                        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" style="width:50px;height:50px;object-fit:cover;border-radius:8px;">
                        <div style="flex:1;">
                            <div style="font-weight:600;">{{ Str::limit($product->name,20) }}</div>
                            <div style="font-size:13px;color:#555;">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        </div>
                        <div style="font-weight:700;color:#d97706;">{{ $product->total_sold ?? 0 }} terjual</div>
                    </div>
                @empty
                    <p style="text-align:center;color:#777;">Belum ada data penjualan</p>
                @endforelse
            </div>
        </div>

        {{-- Produk Terbaru --}}
        <div class="card">
            <div class="card-header">
                <h3 class="section-title">Produk Terbaru</h3>
                <a href="{{ route('products.index') }}" style="font-size:13px;color:#f59e0b;text-decoration:none;">Lihat semua →</a>
            </div>
            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\Product::latest()->take(5)->get() as $product)
                        <tr>
                            <td style="display:flex;align-items:center;gap:10px;">
                                <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" style="width:40px;height:40px;object-fit:cover;border-radius:6px;">
                                <span>{{ Str::limit($product->name,25) }}</span>
                            </td>
                            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td>
                                @if($product->stock > 10)
                                    <span style="background:#dcfce7;color:#166534;padding:4px 8px;border-radius:8px;font-size:12px;">{{ $product->stock }} unit</span>
                                @elseif($product->stock > 0)
                                    <span style="background:#fef3c7;color:#92400e;padding:4px 8px;border-radius:8px;font-size:12px;">{{ $product->stock }} unit</span>
                                @else
                                    <span style="background:#fee2e2;color:#991b1b;padding:4px 8px;border-radius:8px;font-size:12px;">Habis</span>
                                @endif
                            </td>
                            <td>{{ $product->created_at->format('d M Y') }}</td>
                            <td>
                                <span style="background:{{ $product->is_active ? '#dcfce7' : '#e5e7eb' }};color:{{ $product->is_active ? '#166534' : '#374151' }};padding:4px 8px;border-radius:8px;font-size:12px;">
                                    {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- RIGHT SIDEBAR --}}
    <aside>

        {{-- Target Penjualan --}}
        <div class="card">
            <div class="card-header">
                <h3 class="section-title">Target Penjualan</h3>
                <span>🎯</span>
            </div>
            <div>
                <p style="font-size:13px;color:#555;">Progress Bulanan ({{ $salesTarget['percentage'] }}%)</p>
                <div style="background:#eee;height:8px;border-radius:6px;">
                    <div style="width:{{ $salesTarget['percentage'] }}%;background:#fbbf24;height:8px;border-radius:6px;"></div>
                </div>
                <div style="text-align:center;margin-top:10px;font-weight:600;">
                    Rp {{ number_format($salesTarget['target_amount'], 0, ',', '.') }}
                </div>
                <p style="text-align:center;color:#666;font-size:13px;">Target bulan {{ $salesTarget['month_name'] }}</p>
            </div>
        </div>

        {{-- Pending Orders --}}
        <div class="card" style="border-left:4px solid #f97316;">
            <div class="card-header">
                <h3 class="section-title">Pesanan Pending</h3>
                <span>⏳</span>
            </div>
            <div style="text-align:center;">
                <div style="font-size:28px;font-weight:700;">{{ $pending ?? 0 }}</div>
                <p style="color:#777;">Menunggu konfirmasi</p>
            </div>
            <a href="{{ route('orders.index') }}" 
               style="display:block;text-align:center;background:#f97316;color:#fff;padding:10px;border-radius:10px;text-decoration:none;margin-top:10px;font-weight:600;">
               Kelola Pesanan
            </a>
        </div>

        {{-- Quick Actions --}}
        <div class="card">
            <div class="card-header">
                <h3 class="section-title">Quick Actions</h3>
                <span>⚡</span>
            </div>
            <div class="grid" style="gap:12px;">
                <a href="{{ route('products.create') }}" 
                   style="background:#fbbf24;color:#fff;padding:10px;border-radius:10px;text-align:center;text-decoration:none;font-weight:600;box-shadow:0 2px 5px rgba(0,0,0,0.05);">
                   + Tambah Produk Baru
                </a>
                <a href="{{ route('orders.index') }}" 
                   style="background:#fff;border:1px solid #fcd34d;color:#92400e;padding:10px;border-radius:10px;text-align:center;text-decoration:none;font-weight:600;">
                   📋 Lihat Semua Pesanan
                </a>
                <a href="{{ route('categories.index') }}" 
                   style="background:#fff;border:1px solid #ccc;color:#333;padding:10px;border-radius:10px;text-align:center;text-decoration:none;font-weight:600;">
                   🏷️ Kelola Kategori
                </a>
            </div>
        </div>

        {{-- Aktivitas Terbaru --}}
        <div class="card">
            <div class="card-header">
                <h3 class="section-title">Aktivitas Terbaru</h3>
                <span>📝</span>
            </div>
            <div style="max-height:350px;overflow-y:auto;">
                @forelse($recentActivities as $activity)
                    <div style="display:flex;align-items:flex-start;gap:10px;border:1px solid #eee;padding:10px;border-radius:10px;margin-bottom:10px;">
                        <div style="width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;
                            background:{{ $activity['type'] == 'order' ? '#dcfce7' : ($activity['type'] == 'product' ? '#dbeafe' : '#fef3c7') }};">
                            <span>{{ $activity['icon'] }}</span>
                        </div>
                        <div style="flex:1;">
                            <p style="font-weight:600;">{{ $activity['title'] }}</p>
                            <p style="font-size:12px;color:#555;">{{ $activity['description'] }}</p>
                            <p style="font-size:12px;color:#777;">{{ $activity['time_ago'] }}</p>
                        </div>
                    </div>
                @empty
                    <p style="text-align:center;color:#777;">Belum ada aktivitas</p>
                @endforelse
            </div>
        </div>

    </aside>
</div>

{{-- CHART SCRIPT --}}
@push('scripts')
<script>
const ctx = document.getElementById('salesChart');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($salesLabels),
        datasets: [{
            label: 'Penjualan',
            data: @json($salesData),
            borderColor: '#d97706',
            backgroundColor: 'rgba(217, 119, 6, 0.1)',
            borderWidth: 3,
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#d97706',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 5,
            pointHoverRadius: 7
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: { 
            x: { grid: { display: false }, ticks: { color: '#6b7280' } }, 
            y: { beginAtZero: true, grid: { color: 'rgba(107,114,128,0.1)' }, ticks: { color: '#6b7280' } } 
        }
    }
});
</script>
@endpush

@endsection




