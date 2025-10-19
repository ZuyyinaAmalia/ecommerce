<?php

namespace App\Filament\Resources\Orders\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Order;


class OrderStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('New Orders', Order::where('status', 'new')->count()),
            Stat::make('Order Processing', Order::where('status', 'processing')->count()),
            Stat::make('Order Shipped', Order::where('status', 'shipped')->count()),
            Stat::make('Average Price', '' . number_format(Order::query()->avg('total') ?? 0, 0, ',', '.')),
        ];
    }
}
