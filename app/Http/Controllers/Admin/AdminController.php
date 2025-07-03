<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Hitung jumlah data
        $ordersCount = Order::count();
        $menusCount = Menu::count();
        $tablesCount = Table::count();
        $reservationsCount = Reservation::count();

        // Data grafik untuk statistik
        $sales = Order::selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
            ->where('payment_status', 'completed')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $salesLabels = $sales->pluck('month')->map(fn($m) => date('M', mktime(0, 0, 0, $m, 1)));
        $salesData = $sales->pluck('total');

        return view('admin.index', compact(
            'ordersCount',
            'menusCount',
            'tablesCount',
            'reservationsCount',
            'salesLabels',
            'salesData'
        ));
    }

    public function statistik()
    {
        $ordersCount = Order::count();
        $menusCount = Menu::count();
        $totalSales = Order::where('payment_status', 'completed')->sum('total_price');

        // Data grafik penjualan bulanan (dummy)
        $sales = Order::selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
            ->where('payment_status', 'completed')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $salesLabels = $sales->pluck('month')->map(fn($m) => date('M', mktime(0, 0, 0, $m, 1)));
        $salesData = $sales->pluck('total');

        return view('admin.statistik', compact('ordersCount', 'menusCount', 'totalSales', 'salesLabels', 'salesData'));
    }
}
