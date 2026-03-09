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
 * @group Options
 * 
 * APIs for fetching product options/attributes.
 */
class OptionController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

    /**
     * Get All Options
     * 
     * Returns a list of all available options and their values.
     */
    public function index()
    {
        $options = Option::with(['translation', 'values.translation'])->get();
        return $this->successResponse(OptionResource::collection($options));
    }

    /**
     * Get Product Options
     * 
     * Returns the specific options available for a product.
     * 
     * @urlParam product_id int required The ID of the product.
     */
    public function productOptions($product_id)
    {
        $product = Product::find($product_id);
        if (!$product) {
            return $this->errorResponse('Product not found', 404);
        }

        $options = $product->productOptions()->with(['option.translation', 'values.optionValue.translation'])->get();

        return $this->successResponse(ProductOptionResource::collection($options));
    }
}
