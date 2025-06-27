<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['judul', 'slug', 'desc', 'image'];

    // Tambahkan kode ini untuk slug otomatis
    protected static function booted()
    {
        static::saving(function ($blog) {
            $blog->slug = Str::slug($blog->judul, '-');
        });
    }
}
