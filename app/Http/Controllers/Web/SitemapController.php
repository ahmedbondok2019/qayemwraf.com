<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Page;
use App\Models\Blog;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $products = Product::active()->latest()->get();
        $categories = Category::active()->get();
        $pages = Page::active()->get();
        $blogs = Blog::active()->latest()->get();

        return response()->view('frontend.sitemap', [
            'products' => $products,
            'categories' => $categories,
            'pages' => $pages,
            'blogs' => $blogs,
        ])->header('Content-Type', 'text/xml');
    }
}
