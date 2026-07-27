<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Http\Resources\ApiV1\BrandResource;
use App\Models\ProductBrand;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Traits\ApiPaginationTrait;

/**
 *  العلامات التجارية (البراندات وشركاء النجاح)
 * 
 * يتولى جلب العلامات التجارية والشركات المصنعة المتاحة للمنتجات.
 */
class BrandController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

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
