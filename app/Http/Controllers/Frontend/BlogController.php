<?php
namespace App\Http\Controllers\Frontend;

use App\Models\Blog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class BlogController extends Controller
{
    public function index()
    {
        // Ambil semua artikel blog, urutkan terbaru
        $artikels = \App\Models\Blog::latest()->get();
        return view('blog.index', compact('artikels'));
    }

    public function show($slug)
    {
        // Find the blog post by slug
        $artikel = Blog::where('slug', $slug)->firstOrFail();
        return view('blog.detail', compact('artikel')); // Blog detail page view
    }
    
}
