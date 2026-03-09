<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Http\Resources\ApiV1\BlogResource;
use App\Http\Resources\ApiV1\BlogCategoryResource;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Traits\ApiPaginationTrait;

/**
 * @group Blogs
 * 
 * APIs for managing blogs and blog categories.
 */
class BlogController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

    /**
     * Get Blog Categories
     * 
     * Returns a list of blog categories with their blogs count.
     */
    public function categories()
    {
        $categories = BlogCategory::withCount('blogs')->with('translation')->get();

        return $this->successResponse(BlogCategoryResource::collection($categories));
    }

    /**
     * Get Blogs
     * 
     * Returns a list of active blogs, can be filtered by category.
     * 
     * @queryParam category_id int Filter by blog category ID. Example: 1
     */
    public function index(Request $request)
    {
        $query = Blog::active()->with(['BlogTranslation', 'category.translation']);

        if ($request->has('category_id')) {
            $query->where('blog_category_id', $request->category_id);
        }

        $blogs = $query->paginate(10);

        return $this->successResponse($this->paginateResponse($blogs, BlogResource::collection($blogs)));
    }

    /**
     * Get Blog Details
     * 
     * Get a single blog details.
     * 
     * @urlParam id int required The ID of the blog.
     */
    public function show($id)
    {
        $blog = Blog::active()->with(['BlogTranslation', 'category.translation'])->find($id);

        if (!$blog) {
            return $this->errorResponse('Blog not found', 404);
        }

        return $this->successResponse(new BlogResource($blog));
    }
}
