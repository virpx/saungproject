<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
    public function statistik()
{
    $ordersCount = \App\Models\Order::count();
    $menusCount = \App\Models\Menu::count();
    $totalSales = \App\Models\Order::where('payment_status', 'completed')->sum('total_price');

    // Data grafik penjualan bulanan (dummy)
    $sales = \App\Models\Order::selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
        ->where('payment_status', 'completed')
        ->groupBy('month')
        ->orderBy('month')
        ->get();

    $salesLabels = $sales->pluck('month')->map(fn($m) => date('M', mktime(0,0,0,$m,1)));
    $salesData = $sales->pluck('total');

    return view('admin.statistik', compact('ordersCount', 'menusCount', 'totalSales', 'salesLabels', 'salesData'));
}
}
