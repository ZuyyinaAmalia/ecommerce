@extends('layouts.admin')

@section('title','Dashboard - Pixel Commerce')
@section('page-title','Overview')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- MAIN LEFT (2/3) --}}
    <div class="lg:col-span-2 space-y-6">
        {{-- KPI Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl p-5 shadow-sm">
                <div class="text-sm text-gray-500">Total Revenue <span class="text-xs text-gray-400">Last 30 days</span></div>
                <div class="mt-2 flex items-end justify-between">
                    <div>
                        <div class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</div>
                        <div class="text-xs text-green-500 mt-1">▲ 11%</div>
                    </div>
                    <div class="text-3xl text-emerald-300">💰</div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 shadow-sm">
                <div class="text-sm text-gray-500">Total Order <span class="text-xs text-gray-400">Last 30 days</span></div>
                <div class="mt-2 flex items-end justify-between">
                    <div>
                        <div class="text-2xl font-bold text-gray-900">{{ $totalOrder ?? 0 }}</div>
                        <div class="text-xs text-green-500 mt-1">▲ 8%</div>
                    </div>
                    <div class="text-3xl text-emerald-300">🛒</div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 shadow-sm">
                <div class="text-sm text-gray-500">Total Customer <span class="text-xs text-gray-400">Last 30 days</span></div>
                <div class="mt-2 flex items-end justify-between">
                    <div>
                        <div class="text-2xl font-bold text-gray-900">{{ $totalCustomer ?? 0 }}</div>
                        <div class="text-xs text-red-500 mt-1">▼ 3%</div>
                    </div>
                    <div class="text-3xl text-emerald-300">👥</div>
                </div>
            </div>
        </div>

        {{-- Sales Analytics & Top Selling --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl p-6 shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Sales Analytic</h3>
                    <select class="text-sm border px-2 py-1 rounded">
                        <option>Jul 2023</option>
                        <option>Aug 2023</option>
                    </select>
                </div>
                <canvas id="salesChart" class="w-full h-56"></canvas>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Top Selling Products</h3>

                {{-- Horizontal scroll list (carousel-like) --}}
                <div class="flex gap-4 overflow-x-auto pb-2">
                    @forelse($topSelling as $p)
                        <div class="min-w-[160px] bg-gray-50 rounded-lg p-3">
                            @php
                                // Cek apakah $p->image berupa URL (http/https) atau nama file lokal
                                $image = Str::startsWith($p->image, ['http://', 'https://'])
                                    ? $p->image
                                    : asset('storage/' . $p->image);
                            @endphp

                            <img src="{{ $image }}" 
                                alt="{{ $p->name }}" 
                                class="h-32 w-full object-cover rounded-md">

                            <div class="mt-3 font-semibold text-sm">
                                {{ \Illuminate\Support\Str::limit($p->name, 18) }}
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                 Rp {{ number_format($p->price,0,',','.') }}
                            </div>
                            <div class="text-xs text-gray-400 mt-1">{{ $p->stock }} pcs</div>
                        </div>
@empty
    <div class="text-sm text-gray-500">No products</div>
@endforelse
                </div>
            </div>
        </div>

        {{-- Table recent activities (simple) --}}
        <div class="bg-white rounded-xl p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Products</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-gray-500">
                        <tr>
                            <th class="px-3 py-2">Name</th>
                            <th class="px-3 py-2">Price</th>
                            <th class="px-3 py-2">Stock</th>
                            <th class="px-3 py-2">Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\Product::latest()->take(8)->get() as $r)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-3 py-2">{{ $r->name }}</td>
                                <td class="px-3 py-2">Rp {{ number_format($r->price,0,',','.') }}</td>
                                <td class="px-3 py-2">{{ $r->stock }}</td>
                                <td class="px-3 py-2">{{ $r->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- RIGHT SIDEBAR (summary) --}}
    <aside class="space-y-6">
        <div class="bg-white rounded-xl p-5 shadow-sm w-full">
            <h3 class="text-sm text-gray-600">Sales Target</h3>
            <div class="mt-3">
                <div class="text-2xl font-bold">145,00</div>
                <div class="text-xs text-gray-400">Monthly Target</div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm w-full">
            <h3 class="text-sm text-gray-600">Current Orders</h3>
            <div class="mt-3 text-lg font-semibold">{{ $pending ?? 0 }}</div>
            <div class="text-xs text-gray-400">Pending</div>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm w-full">
            <h3 class="text-sm text-gray-600">Quick Actions</h3>
            <div class="mt-3 flex flex-col gap-2">
                <a href="#" class="block text-sm bg-emerald-500 text-white px-3 py-2 rounded">+ Add Product</a>
                <a href="#" class="block text-sm border px-3 py-2 rounded">Orders</a>
            </div>
        </div>
    </aside>

</div>
@endsection

@push('scripts')
<script>
    // Sales chart
    const ctx = document.getElementById('salesChart');
    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($salesLabels),
            datasets: [{
                label: 'Sales',
                data: @json($salesData),
                fill: true,
                tension: 0.4,
                borderWidth: 2,
                borderColor: 'rgb(34,197,94)',
                backgroundColor: 'rgba(34,197,94,0.08)',
                pointRadius: 2
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false } },
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endpush

