<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Http\Resources\ApiV1\OfferResource;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Traits\ApiPaginationTrait;

/**
 * @group General
 * 
 * APIs for offers.
 */
class OfferController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

    /**
     * Get Offers
     * 
     * Returns a list of active offers.
     */
    public function index()
    {
        $offers = Offer::active()->with(['translation', 'category.translation'])->get();

        return $this->successResponse(OfferResource::collection($offers));
    }
}
