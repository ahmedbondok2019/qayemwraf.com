<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Product;
use App\Http\Resources\ApiV1\OptionResource;
use App\Http\Resources\ApiV1\ProductOptionResource;
use App\Traits\ApiResponseTrait;
use App\Traits\ApiPaginationTrait;
use Illuminate\Http\Request;

/**
 * @group 06. خيارات المنتجات (Product Options)
 * 
 * يتولى جلب خيارات ومواصفات المنتجات (مثل الألوان والأنواع والمقاسات) وقيمها.
 */
class OptionController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

    /**
     * جلب جميع خيارات المنتجات العامة
     * 
     * يعيد قائمة بجميع المواصفات والخيارات العامة المتاحة للنظام وقيم كل منها.
     */
    public function index()
    {
        $options = Option::with(['translation', 'values.translation'])->get();
        return $this->successResponse(OptionResource::collection($options));
    }

    /**
     * جلب خيارات ومواصفات منتج محدد
     * 
     * يعيد الخيارات والمواصفات والقيم المتاحة لمنتج محدد برقم المنتج (product_id).
     */
    public function productOptions($product_id)
    {
        $product = Product::find($product_id);
        if (!$product) {
            return $this->errorResponse('المنتج غير موجود', 404);
        }

        $options = $product->productOptions()->with(['option.translation', 'values.optionValue.translation'])->get();

        return $this->successResponse(ProductOptionResource::collection($options));
    }
}
