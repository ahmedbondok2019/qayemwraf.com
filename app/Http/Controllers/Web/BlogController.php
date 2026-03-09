<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::active()->with('BlogTranslation')->latest()->paginate(12);
        return view('frontend.blogs.index', compact('blogs'));
    }

    public function show($id, $slug = null)
    {
        $blog = Blog::active()->with('BlogTranslation')->findOrFail($id);
        
        // Fetch related or latest blogs for sidebar
        $latestBlogs = Blog::active()->with('BlogTranslation')->where('id', '!=', $id)->latest()->take(5)->get();
        
        return view('frontend.blogs.show', compact('blog', 'latestBlogs'));
    }
}
