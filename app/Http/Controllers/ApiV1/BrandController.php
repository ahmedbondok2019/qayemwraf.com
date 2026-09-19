<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiV1\BrandResource;
use App\Models\ProductBrand;
use App\Traits\ApiPaginationTrait;
use App\Traits\ApiResponseTrait;

/**
 * @group 05. العلامات التجارية (Brands)
 *
 * يتولى جلب العلامات التجارية والشركات المصنعة المتاحة للمنتجات.
 */
class BrandController extends Controller
{
    use ApiPaginationTrait, ApiResponseTrait;

    /**
     * جلب العلامات التجارية
     *
     * يعيد قائمة بجميع العلامات التجارية والشركات المصنعة مع عدد المنتجات لكل علامة تجارية.
     */
    public function index()
    {
        $brands = ProductBrand::active()->withCount('products')->get();

        return $this->successResponse(BrandResource::collection($brands));
    }
}
