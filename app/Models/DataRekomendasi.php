<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataRekomendasi extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'data_rekomendasi';
    protected $fillable = [
        'cust_uid',
        'menu_id'
    ];
}
