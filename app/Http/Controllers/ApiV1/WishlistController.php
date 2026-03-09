<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Http\Requests\ApiV1\Wishlist\WishlistIndexRequest;
use App\Http\Requests\ApiV1\Wishlist\WishlistToggleRequest;
use App\Traits\ApiResponseTrait;
use App\Traits\ApiPaginationTrait;

/**
 * @group Wishlist
 * 
 * APIs for managing the user wishlist
 */
class WishlistController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;
    /**
     * Get Wishlist Items
     * 
     * Get all products in the wishlist for the authenticated user or guest.
     * 
     * @bodyParam temp_user_id string Optional. Required if user is not authenticated. Example: guest_123
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
     * Toggle Wishlist
     * 
     * Add or remove a product from the wishlist.
     * 
     * @bodyParam product_id int required The ID of the product. Example: 1
     * @bodyParam temp_user_id string Optional. Required if user is not authenticated. Example: guest_123
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
            return $this->successResponse(['status' => 'removed'], 'Product removed from wishlist');
        } else {
            Wishlist::create([
                'user_id' => $userId,
                'temp_user_id' => $tempUserId,
                'product_id' => $request->product_id,
            ]);
            return $this->successResponse(['status' => 'added'], 'Product added to wishlist');
        }
    }
}
