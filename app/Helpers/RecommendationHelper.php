<?php

namespace App\Helpers;

use App\Models\Menu;
use App\Models\user_menu_rekomendasis; 
use Illuminate\Support\Facades\DB;

class RecommendationHelper
{
    /**
     * Rekomendasi menu berbasis item-based collaborative filtering.
     * @param int $userId
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public static function getRecommendations($userId, $limit = 5)
    {
        // Ambil semua interaksi user-menu
        $allInteractions = user_menu_rekomendasis::all();

        // Buat matrix user-menu
        $matrix = [];
        foreach ($allInteractions as $inter) {
            $matrix[$inter->user_id][$inter->menu_id] = 1;
        }

        // Ambil menu yang sudah pernah diorder user
        $userMenus = isset($matrix[$userId]) ? array_keys($matrix[$userId]) : [];

        // Hitung similarity antar menu (cosine similarity sederhana)
         $similarity = [];
            $menuIds = Menu::pluck('id')->toArray();
            foreach ($menuIds as $i) {
                foreach ($menuIds as $j) {
                    if ($i == $j || $i === 'TAX10' || $j === 'TAX10') continue; // Skip menu pajak
                    $sim = self::cosineSimilarity($matrix, $i, $j);
                    if ($sim > 0) {
                        $similarity[$i][$j] = $sim;
                    }
                }
            }

        // Hitung skor rekomendasi untuk menu yang belum pernah diorder user
        $scores = [];
        foreach ($menuIds as $menuId) {
            if (in_array($menuId, $userMenus)) continue;
            $score = 0;
            foreach ($userMenus as $userMenuId) {
                $score += $similarity[$menuId][$userMenuId] ?? 0;
            }
            if ($score > 0) {
                $scores[] = [
                    'menu_id' => $menuId,
                    'score' => $score,
                ];
            }
        }

        // Urutkan skor secara konsisten: skor desc, menu_id asc
        $sorted = collect($scores)->sortBy([
            ['score', 'desc'],
            ['menu_id', 'asc'],
        ])->take($limit);

        // Ambil data menu
        $menuIds = $sorted->pluck('menu_id')->toArray();
        $menus = Menu::whereIn('id', $menuIds)->get()->keyBy('id');

        // Gabungkan skor dan data menu
        return $sorted->map(function ($item) use ($menus) {
            $menu = $menus[$item['menu_id']] ?? null;
            return [
                'menu' => $menu,
                'score' => $item['score'],
            ];
        })->filter(fn($item) => $item['menu'] !== null)->values();
    }

    // Fungsi cosine similarity sederhana antar dua menu
    private static function cosineSimilarity($matrix, $menuA, $menuB)
    {
        $usersA = [];
        $usersB = [];
        foreach ($matrix as $userId => $menus) {
            if (isset($menus[$menuA])) $usersA[] = $userId;
            if (isset($menus[$menuB])) $usersB[] = $userId;
        }
        $intersection = array_intersect($usersA, $usersB);
        if (count($intersection) == 0) return 0;
        return count($intersection) / sqrt(count($usersA) * count($usersB));
    }

    public static function calculateCosineSimilarity(array $vectorA, array $vectorB)
    {
        $dotProduct = 0;
        $normA = 0;
        $normB = 0;
        foreach ($vectorA as $key => $valueA) {
            $valueB = $vectorB[$key] ?? 0;
            $dotProduct += $valueA * $valueB;
            $normA += $valueA * $valueA;
            $normB += $valueB * $valueB;
        }
        if ($normA == 0 || $normB == 0) {
            return 0;
        }
        return $dotProduct / (sqrt($normA) * sqrt($normB));
    }

    public static function saveSimilarity($menuIdA, $menuIdB, $similarity)
    {
        DB::table('item_similarities')->updateOrInsert(
            ['menu_id_a' => $menuIdA, 'menu_id_b' => $menuIdB],
            ['similarity' => $similarity]
        );
    }
}
