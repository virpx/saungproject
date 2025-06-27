<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemSimilarity extends Model
{
    use HasFactory;

     // Tentukan nama tabel jika tidak sesuai dengan nama model (opsional)
    protected $table = 'item_similarities';

    // Tentukan kolom yang dapat diisi massal
    protected $fillable = [
        'menu_id_1', 
        'menu_id_2', 
        'similarity_score'
    ];
}
