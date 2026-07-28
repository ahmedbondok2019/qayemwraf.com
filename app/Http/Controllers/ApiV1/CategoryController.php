<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Resources\ApiV1\CategoryResource;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Traits\ApiPaginationTrait;

/**
 * @group 04. الأقسام (Categories)
 * 
 * يتولى جلب الأقسام الرئيسية والأقسام الفرعية المتاحة لعرض المنتجات في التطبيق.
 */
class CategoryController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

    /**
     * جلب الأقسام الرئيسية
     * 
     * يعيد قائمة بجميع الأقسام الرئيسية المتاحة والنشطة في النظام.
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
     * جلب الأقسام الفرعية
     * 
     * يعيد قائمة بالتصنيفات والأقسام الفرعية المرتبطة بالأقسام الرئيسية.
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
