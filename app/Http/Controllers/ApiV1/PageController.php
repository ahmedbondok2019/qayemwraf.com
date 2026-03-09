<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Api\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiV1\PageResource;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $pages = Page::active()->get();
        return $this->NewApiResponse(PageResource::collection($pages), '', 'true', 200);
    }

    public function show($slug)
    {
        // Try finding by ID first if numeric, then by slug
        if (is_numeric($slug)) {
            $page = Page::active()->find($slug);
        } else {
             // In case slug is not unique in DB structure (though usually it is), take first
            $page = Page::active()->where('slug', $slug)->first();
            
            // Fallback: Check translations if main slug not found (depending on structure)
            if (!$page) {
                $page = Page::active()->whereHas('translations', function($q) use ($slug) {
                    $q->where('slug', $slug);
                })->first();
            }
        }

        if (!$page) {
            return $this->NewApiResponse(null, __('website.Page Not Found'), 'false', 404);
        }

        return $this->NewApiResponse(new PageResource($page), '', 'true', 200);
    }
}
