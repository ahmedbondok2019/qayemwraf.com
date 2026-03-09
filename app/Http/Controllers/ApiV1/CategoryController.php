<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Resources\ApiV1\CategoryResource;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Traits\ApiPaginationTrait;

/**
 * @group Categories
 * 
 * APIs for managing product categories.
 */
class CategoryController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

    /**
     * Get Main Categories
     * 
     * Returns a list of main categories (parent_id is null).
     */
    public function index()
    {
        $categories = Category::active()
            ->whereNull('parent_id')
            ->with(['translation'])
            ->withCount('products')
            ->get();

        return $this->successResponse(CategoryResource::collection($categories));
    }

    /**
     * Get Sub Categories
     * 
     * Returns a list of sub-categories (parent_id is NOT null/0).
     */
    public function subCategories()
    {
        $categories = Category::active()
            ->whereNotNull('parent_id')
            ->where('parent_id', '!=', NULL)
            ->with(['translation', 'parent.translation'])
            ->withCount('products')
            ->get();

        return $this->successResponse(CategoryResource::collection($categories));
    }
}
