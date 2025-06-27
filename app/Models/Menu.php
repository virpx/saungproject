<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Menu extends Model
{
    use HasFactory;

    // Menambahkan category_id dan spiciness ke dalam $fillable
    protected $fillable = ['name', 'price', 'description', 'image', 'category_id', 'spiciness'];

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity', 'price');  // Relasi dengan tabel 'Order'
    }
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($menu) {
            // Jika SKU belum diisi, generate otomatis
            if (empty($menu->sku)) {
                // Contoh: DMS + slug nama + random 3 digit
                $slug = Str::slug($menu->name);
                $menu->sku = 'DMS' . strtoupper($slug) . rand(100, 999);
            }
        });
    }
}
