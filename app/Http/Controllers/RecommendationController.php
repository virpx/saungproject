<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\user_menu_rekomendasis; 

class RecommendationController extends Controller
{
    public function getUserItemMatrix()
{
    $userItemMatrix = DB::table('user_menu_rekomendasis')
        ->select('user_id', 'menu_id', DB::raw('COUNT(*) as order_count'))
        ->groupBy('user_id', 'menu_id')
        ->get();

    return response()->json($userItemMatrix); // Mengembalikan matriks dalam format JSON
}
public function recommendMenu($user_id)
{
    // Ambil menu yang telah dipesan oleh pengguna
    $userOrders = DB::table('user_menu_rekomendasis')->where('user_id', $user_id)->pluck('menu_id');
    
    if (count($userOrders) == 1) {
        // Jika hanya ada satu menu yang dipesan, rekomendasikan menu berdasarkan popularitas
        $recommendedItems = DB::table('user_menu_rekomendasis')
                            ->select('menu_id', DB::raw('COUNT(*) as order_count'))
                            ->groupBy('menu_id')
                            ->orderBy('order_count', 'desc')  // Urutkan berdasarkan jumlah pesanan terbanyak
                            ->limit(5) // Batasi rekomendasi hanya 5 menu
                            ->pluck('menu_id');  // Ambil ID menu yang direkomendasikan
    } else {
        // Rekomendasi berdasarkan kemiripan antar menu (seperti sebelumnya)
        $recommendedItems = [];
        
        foreach ($userOrders as $menu_id) {
            $similarMenus = DB::table('item_similarities')
                ->where('menu_id_1', $menu_id)
                ->orWhere('menu_id_2', $menu_id)
                ->orderBy('similarity_score', 'desc')
                ->get();
    
            foreach ($similarMenus as $similarMenu) {
                $recommendedItems[] = ($similarMenu->menu_id_1 == $menu_id) ? $similarMenu->menu_id_2 : $similarMenu->menu_id_1;
            }
        }
    }

    return response()->json($recommendedItems);
}


}
