<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use App\Models\Menu;
use App\Helpers\RecommendationHelper;
use App\Models\DataRekomendasi;
use App\Models\OrderItem;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->hasCookie('cust_uid')) {
            $anonymousId = Str::uuid();
            Cookie::queue(cookie('cust_uid', Str::uuid(), 60 * 24 * 365, '/'));
        }
        $recommendations = [];
        if (auth()->check()) {
            $recommendations = RecommendationHelper::getRecommendations(auth()->id(), 20); // ambil lebih banyak dulu
        }
        // Filter untuk menghindari menu pajak
        $recommendations = collect($recommendations)->filter(function ($rec) {
            return $rec['menu'] && $rec['menu']->name !== 'Pajak 10%'; // Pastikan menu pajak tidak ada dalam rekomendasi
        });
        // Group dan ambil max 2 per kategori
        $grouped = collect($recommendations)
            ->filter(fn($rec) => $rec['menu'] && $rec['menu']->category_id)
            ->sortByDesc('score')
            ->groupBy(fn($rec) => $rec['menu']->category_id)
            ->map(function ($items) {
                return $items->take(2);
            })
            ->flatten(1)
            ->values();

        // Hitung jumlah pembelian tiap menu
        $menuCounts = OrderItem::select('menu_id')
            ->whereNotNull('menu_id')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('menu_id')
            ->orderByDesc('total')
            ->take(5)
            ->pluck('total', 'menu_id')
            ->toArray();

        // Ambil data menu berdasarkan urutan terbanyak
        $menus = Menu::whereIn('id', array_keys($menuCounts))->get()->keyBy('id');

        // Gabungkan dengan jumlah pembelian
        foreach ($menuCounts as $menuId => $total) {
            if (isset($menus[$menuId])) {
                $recommendations[] = [
                    'menu' => $menus[$menuId],
                    'score' => $total // jumlah pembelian
                ];
            }
        }

        $sku = DB::table('order_items')
            ->where('sku', 'NOT LIKE', 'TAX%')
            ->inRandomOrder()
            ->value('sku');

        $recommendedSkus = collect();
        if ($sku) {
            $recommendedSkus = DB::table('item_similarities')
                ->where('menu_id_1', $sku)
                ->where('menu_id_2', 'NOT LIKE', 'TAX%')
                ->orderByDesc('similarity_score')
                ->limit(4)
                ->pluck('menu_id_2');
        }

        $recommendedItems = collect();
        if ($recommendedSkus->isNotEmpty()) {
            $recommendedItems = Menu::whereIn('sku', $recommendedSkus)->get();
        }

        $artikels = Blog::latest()->get();
        $specials = Category::where('name', 'specials')->first();

        // data rekomendasi
        // ngambil cust_uid dari cookie
        $cust_uid = $request->cookie("cust_uid");
        // dd($cust_uid);

        $menuId = DataRekomendasi::where("cust_uid", $cust_uid)
            ->value("menu_id");
        // dd($menuId);

        if ($menuId) {
            $ids = collect(explode(",", $menuId))
                ->map(fn($v) => trim($v))
                ->filter()
                ->map(fn($v) => (int) $v)
                ->all();

            $namaMenuRekomendasi = Menu::whereIn('id', $ids)->get(['id', 'name', 'description', 'image', 'price']);

            // dd($namaMenuRekomendasi);
        } else {
            $namaMenuRekomendasi = collect();
            // dd($namaMenuRekomendasi);
        }

        return view('welcome', [
            'recommendations' => collect($recommendations), // pastikan Collection
            'specials' => $specials,
            'artikels' => $artikels,
            'recommendedItems' => $recommendedItems,
            'namaMenuRekomendasi' => $namaMenuRekomendasi,
        ]);
    }
}
