<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Http\Resources\ApiV1\SliderResource;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Traits\ApiPaginationTrait;

/**
 * @group Home
 * 
 * APIs for home page components like sliders.
 */
class SliderController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

    /**
     * Get Sliders
     * 
     * Returns a list of active sliders with their translations and associated categories.
     */
    public function index()
    {
        $sliders = Slider::active()
            ->with(['translation', 'category'])
            ->get();

        return $this->successResponse(SliderResource::collection($sliders));
    }
}
