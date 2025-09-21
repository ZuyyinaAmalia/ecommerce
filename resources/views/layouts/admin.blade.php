<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>@yield('title','Admin Dashboard')</title>
    @vite('resources/css/app.css')
    <!-- Chart.js via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50 font-inter antialiased">
    <div class="min-h-screen flex">
        {{-- SIDEBAR --}}
        <aside class="w-72 bg-emerald-50 border-r border-gray-100 p-6 hidden md:block">
            <div class="flex items-center gap-3 mb-8">
                <div class="bg-emerald-200 rounded-full w-12 h-12 flex items-center justify-center text-emerald-700 font-bold">P</div>
                <div>
                    <div class="font-bold text-gray-800">Pixel Commerce</div>
                    <div class="text-xs text-gray-500">Admin Panel</div>
                </div>
            </div>

            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg bg-emerald-200 text-emerald-800">
                    <span class="w-8 text-center">🏠</span>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('orders.index') }}" 
                    class="flex items-center px-4 py-2 text-gray-700 hover:bg-green-100 rounded-lg">
                    <span class="material-icons mr-2">shopping_cart</span>
                    Orders
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 hover:bg-white">📦 Products</a>
                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 hover:bg-white">⚙️ Settings</a>
            </nav>
        </aside>

        {{-- MAIN --}}
        <div class="flex-1 min-w-0">
            {{-- Header --}}
            <header class="bg-white border-b border-gray-100">
                <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <h1 class="text-2xl font-semibold text-gray-800">@yield('page-title','Overview')</h1>
                        <div class="hidden sm:block">
                            <input type="search" placeholder="Search..." class="px-3 py-2 border rounded-lg text-sm">
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="text-sm text-gray-600">
                            @if(session('username'))
                                Hi, <span class="font-semibold text-gray-800">{{ session('username') }}</span>
                            @else
                                Hi, Guest
                            @endif
                        </div>
                        <a href="#" class="inline-block bg-emerald-500 text-white px-3 py-2 rounded-lg text-sm">Logout</a>
                    </div>
                </div>
            </header>

            {{-- Content area --}}
            <main class="max-w-7xl mx-auto p-6">
                {{-- session alert --}}
                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-50 border-l-4 border-green-400 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>

