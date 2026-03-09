<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Api\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{
    use ApiResponseTrait;

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return $this->NewApiResponse(null, $validator->errors()->first(), 'false', 422);
        }

        $user = $request->user();

        // Check if user purchased AND received the product
        $hasPurchased = $user->orders()
            ->where('status', 3) // 3 = Received/Delivered
            ->whereHas('order_details', function($q) use ($request) {
                $q->where('product_id', $request->product_id);
            })->exists();

        if (!$hasPurchased) {
             return $this->NewApiResponse(null, __('website.You must purchase and receive this product to rate it'), 'false', 403);
        }

        // Create or update rating
        $rating = Rating::updateOrCreate(
            [
                'user_id' => $user->id,
                'product_id' => $request->product_id,
            ],
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
                'status' => true, // Auto-approve for now
            ]
        );

        return $this->NewApiResponse(null, __('website.Rating submitted successfully'), 'true', 200);
    }
}
