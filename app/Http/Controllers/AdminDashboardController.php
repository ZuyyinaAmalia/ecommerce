<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalRevenue   = Order::sum('total');
        $totalOrder     = Order::count();
        $totalCustomer  = User::count();
        $pending        = Order::where('status', 'pending')->count();

        $topSelling = Product::orderBy('stock', 'asc')
                            ->take(5)
                            ->get();

        $salesLabels = Order::selectRaw('DATE(created_at) as date')
                            ->groupBy('date')
                            ->orderBy('date')
                            ->pluck('date');

        $salesData = Order::selectRaw('SUM(total) as total')
                          ->groupByRaw('DATE(created_at)')
                          ->orderByRaw('DATE(created_at)')
                          ->pluck('total');

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalOrder',
            'totalCustomer',
            'pending',
            'topSelling',
            'salesLabels',
            'salesData'
        ));
    }
}



