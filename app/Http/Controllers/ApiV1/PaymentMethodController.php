<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Http\Resources\ApiV1\PaymentMethodResource;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

/**
 * @group Payment Methods
 * 
 * APIs for retrieving available payment methods.
 */
class PaymentMethodController extends Controller
{
    use ApiResponseTrait;

    /**
     * Get All Payment Methods
     * 
     * Returns a list of all active payment methods.
     */
    public function index()
    {
        $methods = PaymentMethod::active()->with(['translation', 'translations'])->get();

        return $this->successResponse(PaymentMethodResource::collection($methods));
    }
}
