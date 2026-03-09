<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Models\OrderService;
use App\Http\Resources\ApiV1\OrderServiceResource;
use App\Traits\ApiResponseTrait;
use App\Traits\ApiPaginationTrait;
use Illuminate\Http\Request;

/**
 * @group Order Services
 * 
 * APIs for retrieving available order services like gift wrapping.
 */
class OrderServiceController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

    /**
     * Get All Order Services
     * 
     * Returns a list of all active order services.
     */
    public function index()
    {
        $services = OrderService::active()->get();

        return $this->successResponse(OrderServiceResource::collection($services));
    }
}
