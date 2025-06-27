<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ItemSimilarity;
use App\Helpers\RecommendationHelper;
use Illuminate\Support\Facades\DB;

class GenerateMenuSimilarity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recommendation:generate-similarity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate item-based menu similarity';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orders = DB::table('order_items')->select('order_id', 'sku')->get();
        $menuOrderMatrix = [];
        foreach ($orders as $row) {
            $menuOrderMatrix[$row->sku][$row->order_id] = 1;
        }
        $menuIds = array_keys($menuOrderMatrix);
        foreach ($menuIds as $i => $menuId1) {
            for ($j = $i + 1; $j < count($menuIds); $j++) {
                $menuId2 = $menuIds[$j];
                 if ($menuId1 == 'TAX10' || $menuId2 == 'TAX10') {
                    continue;  // Skip if one of the menu IDs is 'TAX10'
                }
                $vec1 = $menuOrderMatrix[$menuId1] ?? [];
                $vec2 = $menuOrderMatrix[$menuId2] ?? [];
                $allOrders = array_unique(array_merge(array_keys($vec1), array_keys($vec2)));
                $v1 = []; $v2 = [];
                foreach ($allOrders as $oid) {
                    $v1[$oid] = $vec1[$oid] ?? 0;
                    $v2[$oid] = $vec2[$oid] ?? 0;
                }
                $sim = RecommendationHelper::calculateCosineSimilarity($v1, $v2);
                if ($sim > 0) {
                    // Gunakan model ItemSimilarity untuk menyimpan data
                    ItemSimilarity::create([
                        'menu_id_1' => $menuId1,
                        'menu_id_2' => $menuId2,
                        'similarity_score' => $sim,
                    ]);
                    // Simpan juga dalam urutan terbalik (menu_id_2 dan menu_id_1)
                    ItemSimilarity::create([
                        'menu_id_1' => $menuId2,
                        'menu_id_2' => $menuId1,
                        'similarity_score' => $sim,
                    ]);
                }
            }
        }
        $this->info('Similarity generated!');
    }
}
