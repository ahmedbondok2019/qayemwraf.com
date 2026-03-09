<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($slug)
    {
        $page = Page::active()->whereHas('translations', function ($query) use ($slug) {
            $query->where('slug', $slug);
        })->firstOrFail();

        return view('frontend.pages.show', compact('page'));
    }
}
