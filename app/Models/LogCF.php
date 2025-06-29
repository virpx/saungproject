<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogCF extends Model
{
    use HasFactory;
    protected $table = 'log_cf';

    // Tentukan kolom yang dapat diisi massal
    protected $fillable = [
        'cust_uid', 
        'jenis', 
        'hasil'
    ];
}
