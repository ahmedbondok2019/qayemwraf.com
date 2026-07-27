<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Api\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 *  تقييم ومراجعة المنتجات
 * 
 * يتولى استقبال وتخزين تقييمات وتعليقات المستخدمين المسجلين على المنتجات بعد الشراء.
 */
class RatingController extends Controller
{
    use ApiResponseTrait;

    /**
     * إضافة تقييم ومراجعة لمنتج
     * 
     * يحفظ التقييم الرقمي والتعليق الخاص بالمستخدم على منتج تم شراؤه واستلامه مسبقاً.
     */
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

        $hasPurchased = $user->orders()
            ->where('status', 3)
            ->whereHas('order_details', function($q) use ($request) {
                $q->where('product_id', $request->product_id);
            })->exists();

        if (!$hasPurchased) {
             return $this->NewApiResponse(null, __('website.You must purchase and receive this product to rate it'), 'false', 403);
        }

        $rating = Rating::updateOrCreate(
            [
                'user_id' => $user->id,
                'product_id' => $request->product_id,
            ],
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
                'status' => true,
            ]
        );

        return $this->NewApiResponse(null, __('website.Rating submitted successfully'), 'true', 200);
    }
}
