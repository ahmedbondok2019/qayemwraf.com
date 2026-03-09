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
 * @group Brands / Partners
 * 
 * APIs for managing brands (partners).
 */
class BrandController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

    /**
     * Get All Brands
     * 
     * Returns a list of brands (partners) with the count of products for each.
     */
    public function index()
    {
        $brands = ProductBrand::withCount('products')->get();

        return $this->successResponse(BrandResource::collection($brands));
    }
}
