<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Http\Resources\ApiV1\AdvertisementResource;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Traits\ApiPaginationTrait;

/**
 * @group General
 * 
 * APIs for advertisements.
 */
class AdvertisementController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

    /**
     * Get Advertisements
     * 
     * Returns a list of active advertisements.
     * 
     * @queryParam position string Filter by position. Example: popup, sidebar, top_banner
     */
    public function index(Request $request)
    {
        $query = Advertisement::active()->with(['translation']);

        if ($request->has('position')) {
            $positions = explode(',', $request->position);
            $query->whereIn('location', array_map('trim', $positions));
        }

        $advertisements = $query->latest()->get();

        return $this->successResponse(AdvertisementResource::collection($advertisements));
    }
}
