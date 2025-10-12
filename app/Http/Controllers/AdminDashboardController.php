<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Order::where('status', 'completed')->sum('total');
        $totalOrder     = Order::count();
        $totalCustomer  = User::count();
        $pending        = Order::where('status', 'pending')->count();

        $topSelling = $this->getTopSellingProducts();

        $salesLabels = Order::selectRaw('DATE(created_at) as date')
                            ->groupBy('date')
                            ->orderBy('date')
                            ->pluck('date');

        $salesData = Order::selectRaw('SUM(total) as total')
                          ->groupByRaw('DATE(created_at)')
                          ->orderByRaw('DATE(created_at)')
                          ->pluck('total');

        $recentActivities = $this->getRecentActivities();

        $salesTarget = $this->getSalesTarget();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalOrder',
            'totalCustomer',
            'pending',
            'topSelling',
            'salesLabels',
            'salesData',
            'recentActivities',
            'salesTarget' 
        ));
    }

    private function getSalesTarget()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;
        
        // Total penjualan bulan lalu
        $lastMonthSales = Order::where('status', 'completed')
                              ->whereMonth('created_at', now()->subMonth()->month)
                              ->whereYear('created_at', now()->subMonth()->year)
                              ->sum('total');
        
        // Target = Penjualan bulan lalu + 20% growth
        // Jika bulan lalu tidak ada penjualan, gunakan default target
        $targetAmount = $lastMonthSales > 0 
                       ? $lastMonthSales * 1.2  // +20% dari bulan lalu
                       : 145000000;              // Default target
        
        // Total penjualan bulan ini (completed)
        $currentSales = Order::where('status', 'completed')
                            ->whereMonth('created_at', $currentMonth)
                            ->whereYear('created_at', $currentYear)
                            ->sum('total');
        
        // Hitung persentase progress
        $percentage = $targetAmount > 0 
                     ? round(($currentSales / $targetAmount) * 100, 1) 
                     : 0;
        
        // Pastikan tidak lebih dari 100%
        $percentage = min($percentage, 100);
        
        // Sisa target yang harus dicapai
        $remaining = max($targetAmount - $currentSales, 0);
        
        return [
            'target_amount' => $targetAmount,
            'current_sales' => $currentSales,
            'last_month_sales' => $lastMonthSales,
            'percentage' => $percentage,
            'remaining' => $remaining,
            'month_name' => now()->translatedFormat('F Y'),
            'last_month_name' => now()->subMonth()->translatedFormat('F Y'),
            'growth_rate' => 20, // 20% growth target

        ];
    }

    /**
     * Get top selling products based on actual sales
     */
    private function getTopSellingProducts($limit = 5)
    {
        $topSelling = Product::select(
                'products.id',
                'products.name',
                'products.price',
                'products.image',
                DB::raw('COALESCE(SUM(order_items.qty), 0) as total_sold')
            )
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->leftJoin('orders', function($join) {
                $join->on('order_items.order_id', '=', 'orders.id');
            })
            // ✅ TAMBAHKAN WHERE DI LUAR JOIN
            ->where(function($query) {
                $query->whereNull('orders.id') // Produk yang belum ada order
                      ->orWhere('orders.status', '=', 'completed'); // ATAU order completed
            })
            ->groupBy('products.id', 'products.name', 'products.price', 'products.image')
            ->orderByDesc('total_sold')
            ->limit($limit)
            ->get();

        return $topSelling;
    }

    /**
     * Get recent activities from orders, products, and users
     * 
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    private function getRecentActivities($limit = 10)
    {
        $activities = collect();
        
        // 1. Recent Orders (Pesanan Baru)
        $recentOrders = Order::with('user')
            ->latest()
            ->limit(5)
            ->get()
            ->map(function($order) {
                $statusIcons = [
                    'pending' => '⏳',
                    'processing' => '🔄',
                    'completed' => '✅',
                    'cancelled' => '❌',
                ];
                
                return [
                    'type' => 'order',
                    'icon' => $statusIcons[$order->status] ?? '🛒',
                    'title' => "Pesanan baru #ORD-{$order->id}",
                    'description' => ($order->user ? $order->user->name : 'Guest') . " - " . number_format($order->total, 0, ',', '.'),
                    'time' => $order->created_at,
                    'time_ago' => $order->created_at->diffForHumans(),
                    'status' => $order->status,
                ];
            });
        
        // 2. Recently Added/Updated Products
        $recentProducts = Product::latest()
            ->limit(5)
            ->get()
            ->map(function($product) {
                return [
                    'type' => 'product',
                    'icon' => '📦',
                    'title' => "Produk \"{$product->name}\" ditambahkan",
                    'description' => $product->category->name ?? 'Tanpa kategori',
                    'time' => $product->created_at,
                    'time_ago' => $product->created_at->diffForHumans(),
                ];
            });
        
        // 3. New Customers (Pelanggan Baru Terdaftar)
        $recentCustomers = User::latest()
            ->limit(5)
            ->get()
            ->map(function($user) {
                return [
                    'type' => 'customer',
                    'icon' => '👤',
                    'title' => "Pelanggan baru terdaftar",
                    'description' => $user->name,
                    'time' => $user->created_at,
                    'time_ago' => $user->created_at->diffForHumans(),
                ];
            });
        
        // Gabungkan semua aktivitas dan urutkan berdasarkan waktu
        $activities = $activities
            ->merge($recentOrders)
            ->merge($recentProducts)
            ->merge($recentCustomers)
            ->sortByDesc('time')
            ->take($limit)
            ->values();
        
        return $activities;
    }

}



