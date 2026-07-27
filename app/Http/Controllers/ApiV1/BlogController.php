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
 *  المدونة والمقالات
 * 
 * يتولى جلب أقسام المدونة، قائمة المقالات مع دعم الفلترة بحسب القسم، وتفاصيل المقال المكتوب.
 */
class BlogController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

    /**
     * جلب أقسام المدونة
     * 
     * يعيد قائمة بأقسام المدونة المتاحة مع عدد المقالات لكل قسم.
     */
    public function categories()
    {
        $categories = BlogCategory::withCount('blogs')->with('translation')->get();

        return $this->successResponse(BlogCategoryResource::collection($categories));
    }

    /**
     * جلب المقالات والمدونة
     * 
     * يعيد قائمة مقسمة صفحات من المقالات النشطة، مع إمكانية الفلترة حسب قسم المدونة.
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
     * جلب تفاصيل مقال محدد
     * 
     * يعيد كامل بيانات ومحتوى ومحتويات مقال محدد برقم المقال (ID).
     */
    public function show($id)
    {
        $blog = Blog::active()->with(['BlogTranslation', 'category.translation'])->find($id);

        if (!$blog) {
            return $this->errorResponse('المقال غير موجود', 404);
        }

        return $this->successResponse(new BlogResource($blog));
    }
}
