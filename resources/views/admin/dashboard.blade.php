@extends('layouts.admin')

@section('title', 'Dashboard - E-Commerce')
@section('page-title', 'Overview Dashboard')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
    {{-- Jarak diperbesar dari lg:gap-10 ke lg:gap-12 --}}

    {{-- LEFT MAIN CONTENT --}}
    <div class="lg:col-span-2 space-y-8">

        {{-- KPI CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Revenue Card --}}
            <div class="card rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 border-amber-500 bg-white">
                <div class="flex items-center justify-between">
                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-600">Total Pendapatan</p>
                        <h3 class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</h3>
                        <p class="text-xs text-gray-500">Bulan ini</p>
                    </div>
                    <div class="bg-amber-100 p-3 rounded-xl">
                        <span class="text-2xl">💰</span>
                    </div>
                </div>
            </div>

            {{-- Orders Card --}}
            <div class="card rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 border-blue-500 bg-white">
                <div class="flex items-center justify-between">
                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-600">Total Pesanan</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $totalOrder ?? 0 }}</h3>
                        <p class="text-xs text-gray-500">Pesanan aktif</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-xl">
                        <span class="text-2xl">🛍️</span>
                    </div>
                </div>
            </div>

            {{-- Customers Card --}}
            <div class="card rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 border-green-500 bg-white">
                <div class="flex items-center justify-between">
                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-600">Total Pelanggan</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $totalCustomer ?? 0 }}</h3>
                        <p class="text-xs text-gray-500">Pelanggan terdaftar</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-xl">
                        <span class="text-2xl">👥</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- CHARTS AND TOP PRODUCTS --}}
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            {{-- Sales Chart --}}
            <div class="card rounded-2xl p-6 shadow-lg bg-white">
                <div class="flex justify-between items-center mb-6">
                    <div class="space-y-1">
                        <h3 class="text-lg font-bold text-gray-900">Analisis Penjualan</h3>
                        <p class="text-sm text-gray-600">Statistik penjualan bulanan</p>
                    </div>
                    <span class="bg-amber-100 text-amber-800 px-3 py-1.5 rounded-lg text-sm font-semibold">Mar 2024</span>
                </div>
                <div class="h-72">
                    <canvas id="salesChart" class="w-full h-full"></canvas>
                </div>
            </div>

            {{-- Top Selling Products --}}
            <div class="card rounded-2xl p-6 shadow-lg bg-white">
                <div class="flex justify-between items-center mb-6">
                    <div class="space-y-1">
                        <h3 class="text-lg font-bold text-gray-900">Produk Terlaris</h3>
                        <p class="text-sm text-gray-600">Produk dengan penjualan tertinggi</p>
                    </div>
                    <span class="text-2xl">🔥</span>
                </div>
                <div class="space-y-4 max-h-72 overflow-y-auto pr-2">
                    @forelse($topSelling as $index => $product)
                    <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-amber-50 transition-colors duration-200 border border-gray-200">
                        <div class="flex-shrink-0 w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                            <span class="text-amber-600 font-bold text-sm">{{ $index + 1 }}</span>
                        </div>
                        <div class="flex-shrink-0 w-16 h-16">
                            <img src="{{ asset('storage/'.$product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover rounded-lg shadow-sm">
                        </div>
                        <div class="flex-1 min-w-0 space-y-0.5">
                            <h4 class="font-semibold text-gray-900 text-sm leading-tight">{{ Str::limit($product->name, 20) }}</h4>
                            <p class="text-sm text-gray-700 font-medium">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-bold text-amber-600">{{ $product->total_sold ?? 0 }} terjual</div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <div class="text-gray-400 text-4xl mb-2">📦</div>
                        <p class="text-gray-500 text-sm">Belum ada data penjualan</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- RECENT PRODUCTS TABLE --}}
        <div class="card rounded-2xl p-6 shadow-lg bg-white">
            <div class="flex justify-between items-center mb-6">
                <div class="space-y-0.5">
                    <h3 class="text-lg font-bold text-gray-900">Produk Terbaru</h3>
                    <p class="text-sm text-gray-600">Produk yang baru ditambahkan</p>
                </div>
                <a href="{{ route('products.index') }}" class="text-amber-600 hover:text-amber-700 text-sm font-semibold flex items-center gap-2">
                    Lihat semua <span class="text-base">→</span>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="py-4 px-4 text-left font-bold text-gray-700">Produk</th>
                            <th class="py-4 px-4 text-left font-bold text-gray-700">Harga</th>
                            <th class="py-4 px-4 text-left font-bold text-gray-700">Stok</th>
                            <th class="py-4 px-4 text-left font-bold text-gray-700">Tanggal</th>
                            <th class="py-4 px-4 text-left font-bold text-gray-700">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach(\App\Models\Product::latest()->take(5)->get() as $product)
                        <tr class="hover:bg-amber-50 transition-colors duration-150">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-lg bg-gray-100 overflow-hidden shadow-sm flex-shrink-0">
                                        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    </div>
                                    <span class="font-semibold text-gray-900">{{ Str::limit($product->name, 25) }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-gray-800 font-medium">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold 
                                    {{ $product->stock > 10 ? 'bg-green-100 text-green-800' : 
                                       ($product->stock > 0 ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $product->stock }} unit
                                </span>
                            </td>
                            <td class="py-3 px-4 text-gray-700">{{ $product->created_at->format('d M Y') }}</td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold 
                                    {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
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
    {{-- END LEFT MAIN CONTENT --}}

    {{-- RIGHT SIDEBAR --}}
    <aside class="space-y-8">
        {{-- Sales Target --}}
        <div class="card rounded-2xl p-6 shadow-lg bg-white">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-gray-900 text-lg">Target Penjualan</h3>
                <span class="text-2xl">🎯</span>
            </div>
            <div class="space-y-4">
                {{-- Progress Bar --}}
                <div>
                    <div class="flex justify-between text-sm text-gray-700 mb-2 font-semibold">
                        <span>Progress Bulanan</span>
                        <span>{{ $salesTarget['percentage'] }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-amber-500 h-2.5 rounded-full transition-all duration-500" 
                            style="width: {{ $salesTarget['percentage'] }}%"></div>
                    </div>
                </div>

                {{-- Target Amount --}}
                <div class="text-center pt-2 space-y-1">
                    <div class="text-2xl font-bold text-gray-900">
                        Rp {{ number_format($salesTarget['target_amount'], 0, ',', '.') }}
                    </div>
                    <p class="text-sm text-gray-600">Target bulan {{ $salesTarget['month_name'] }}</p>
                </div>

                {{-- Current Sales --}}
                <div class="border-t pt-3 space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Penjualan Saat Ini</span>
                        <span class="font-semibold text-green-600">
                            Rp {{ number_format($salesTarget['current_sales'], 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Sisa Target</span>
                        <span class="font-semibold text-amber-600">
                            Rp {{ number_format($salesTarget['remaining'], 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                {{-- Info Text --}}
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-3">
                    <p class="text-xs text-gray-700 text-center">
                        📊 Target dihitung dari penjualan bulan 
                        <span class="font-semibold">{{ $salesTarget['last_month_name'] }}</span>
                        <br>
                        <span class="text-amber-700 font-medium">+ {{ $salesTarget['growth_rate'] }}% growth</span>
                    </p>
                </div>
            </div>
        </div>

        {{-- Pending Orders --}}
        <div class="card rounded-2xl p-6 shadow-lg bg-white border-l-4 border-orange-500">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-gray-900 text-lg">Pesanan Pending</h3>
                <span class="text-2xl">⏳</span>
            </div>
            <div class="text-center py-3">
                <div class="text-3xl font-bold text-gray-900 mb-2">{{ $pending ?? 0 }}</div>
                <p class="text-sm text-gray-600">Menunggu konfirmasi</p>
            </div>
            <a href="{{ route('orders.index') }}" class="block mt-5 text-center bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-xl text-sm font-semibold transition-all duration-200 hover:shadow-lg">
                Kelola Pesanan
            </a>
        </div>

        {{-- Quick Actions --}}
        <div class="card rounded-2xl p-6 shadow-lg bg-white">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-gray-900 text-lg">Quick Actions</h3>
                <span class="text-2xl">⚡</span>
            </div>
            <div class="space-y-3">
                <a href="{{ route('products.create') }}" class="flex items-center justify-center gap-2 bg-amber-500 hover:bg-amber-600 text-white py-3 rounded-xl text-sm font-semibold transition-all duration-200 hover:shadow-lg">
                    <span class="text-base">+</span> Tambah Produk Baru
                </a>
                <a href="{{ route('orders.index') }}" class="flex items-center justify-center gap-2 border-2 border-amber-300 text-amber-700 hover:bg-amber-50 py-3 rounded-xl text-sm font-semibold transition-all duration-200">
                    <span class="text-base">📋</span> Lihat Semua Pesanan
                </a>
                <a href="{{ route('categories.index') }}" class="flex items-center justify-center gap-2 border-2 border-gray-300 text-gray-700 hover:bg-gray-50 py-3 rounded-xl text-sm font-semibold transition-all duration-200">
                    <span class="text-base">🏷️</span> Kelola Kategori
                </a>
            </div>
        </div>

        {{-- Recent Activity --}}
        <div class="card rounded-2xl p-6 shadow-lg bg-white">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-gray-900 text-lg">Aktivitas Terbaru</h3>
                <span class="text-2xl">📝</span>
            </div>
            <div class="space-y-3 max-h-96 overflow-y-auto pr-2">
                @forelse($recentActivities as $activity)
                <div class="flex items-start gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors duration-150 border border-gray-200">
                    <div class="w-10 h-10 
                        {{ $activity['type'] == 'order' ? 'bg-green-100' : 
                           ($activity['type'] == 'product' ? 'bg-blue-100' : 'bg-amber-100') }} 
                        rounded-lg flex items-center justify-center flex-shrink-0">
                        <span class="text-base">{{ $activity['icon'] }}</span>
                    </div>
                    <div class="flex-1 space-y-0.5 min-w-0">
                        <p class="text-sm font-medium text-gray-900">{{ $activity['title'] }}</p>
                        <p class="text-xs text-gray-600">{{ $activity['description'] }}</p>
                        <p class="text-xs text-gray-500">{{ $activity['time_ago'] }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <div class="text-gray-400 text-4xl mb-2">📭</div>
                    <p class="text-gray-500 text-sm">Belum ada aktivitas</p>
                </div>
                @endforelse
            </div>
        </div>
    </aside>
    {{-- END RIGHT SIDEBAR --}}

</div>
{{-- END GRID --}}
@endsection

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
            pointBorderColor: '#ffffff',
            pointBorderWidth: 2,
            pointRadius: 5,
            pointHoverRadius: 7
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { 
            legend: { display: false },
            tooltip: {
                backgroundColor: '#1f2937',
                titleColor: '#f9fafb',
                bodyColor: '#f9fafb',
                borderColor: '#374151',
                borderWidth: 1,
                cornerRadius: 8,
                displayColors: false,
                titleFont: { size: 14 },
                bodyFont: { size: 14 },
                padding: 12
            }
        },
        scales: { 
            x: { 
                grid: { display: false },
                ticks: { color: '#6b7280', font: { size: 12 } }
            }, 
            y: { 
                beginAtZero: true,
                grid: { color: 'rgba(107, 114, 128, 0.1)' },
                ticks: { color: '#6b7280', font: { size: 12 } }
            } 
        }
    }
});
</script>
@endpush


