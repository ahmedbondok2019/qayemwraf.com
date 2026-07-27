<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Http\Requests\ApiV1\Wishlist\WishlistIndexRequest;
use App\Http\Requests\ApiV1\Wishlist\WishlistToggleRequest;
use App\Traits\ApiResponseTrait;
use App\Traits\ApiPaginationTrait;

/**
 *  قائمة الرغبات (المفضلة)
 * 
 * يتولى جلب قائمة المنتجات المفضلة وإضافة/إزالة المنتجات من مفضلة المستخدم أو الزائر.
 */
class WishlistController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

    /**
     * جلب عناصر قائمة الرغبات
     * 
     * يعيد جميع المنتجات المضافة إلى قائمة المفضلة للمستخدم الحالي أو الزائر.
     */
    public function index(WishlistIndexRequest $request)
    {
        $query = Wishlist::with('product','product.productOptions.values', 'product.translation');

        if ($request->user('sanctum')) {
            $query->where('user_id', $request->user('sanctum')->id);
        } else {
            $query->where('temp_user_id', $request->temp_user_id);
        }

        $items = $query->get();

        return $this->successResponse($items);
    }

    /**
     * إضافة أو إزالة منتج من المفضلة
     * 
     * يضيف المنتج إلى المفضلة إذا لم يكن موجوداً، أو يزيله من المفضلة إذا كان موجوداً مسبقاً.
     */
    public function toggle(WishlistToggleRequest $request)
    {
        $userId = $request->user('sanctum') ? $request->user('sanctum')->id : null;
        $tempUserId = $request->temp_user_id;

        $wishlistItem = Wishlist::where('product_id', $request->product_id)
            ->where(function($q) use ($userId, $tempUserId) {
                if ($userId) {
                    $q->where('user_id', $userId);
                } else {
                    $q->where('temp_user_id', $tempUserId);
                }
            })->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            return $this->successResponse(['status' => 'removed'], 'تم حذف المنتج من قائمة المفضلة');
        } else {
            Wishlist::create([
                'user_id' => $userId,
                'temp_user_id' => $tempUserId,
                'product_id' => $request->product_id,
            ]);
            return $this->successResponse(['status' => 'added'], 'تمت إضافة المنتج إلى قائمة المفضلة');
        }
    }
}
