<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $userId = $user ? $user->id : null;
        $tempUserId = $request->cookie('temp_user_id');

        $wishlistItems = Wishlist::where(function($q) use ($userId, $tempUserId) {
                if ($userId) {
                    $q->where('user_id', $userId);
                } elseif ($tempUserId) {
                    $q->where('temp_user_id', $tempUserId);
                } else {
                    $q->whereRaw('1 = 0');
                }
            })
            ->with(['product.translation', 'product.brand.translation'])
            ->get();

        // Cart for Guest/Auth to check status
        $cartProducts = \App\Models\Cart::where(function($q) use ($userId, $tempUserId) {
                if ($userId) {
                    $q->where('user_id', $userId);
                } elseif ($tempUserId) {
                    $q->where('temp_user_id', $tempUserId);
                } else {
                    $q->whereRaw('1 = 0');
                }
            })
            ->pluck('quantity', 'product_id')
            ->toArray();

        return view('frontend.wishlist.index', compact('wishlistItems', 'cartProducts'));
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $user = \Illuminate\Support\Facades\Auth::user();
        $userId = $user ? $user->id : null;
        $tempUserId = null;

        if (!$userId) {
            $tempUserId = $request->cookie('temp_user_id');
            if (!$tempUserId) {
                $tempUserId = (string) \Illuminate\Support\Str::uuid();
            }
        }

        $wishlist = Wishlist::where('product_id', $request->product_id)
            ->where(function($q) use ($userId, $tempUserId) {
                if ($userId) {
                    $q->where('user_id', $userId);
                } else {
                    $q->where('temp_user_id', $tempUserId);
                }
            })
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $action = 'removed';
            $message = __('Item removed from wishlist');
        } else {
            Wishlist::create([
                'user_id' => $userId,
                'temp_user_id' => $userId ? null : $tempUserId,
                'product_id' => $request->product_id
            ]);
            $action = 'added';
            $message = __('Item added to wishlist');
        }

        $count = Wishlist::where(function($q) use ($userId, $tempUserId) {
             if ($userId) {
                $q->where('user_id', $userId);
            } else {
                $q->where('temp_user_id', $tempUserId);
            }
        })->count();

        $response = response()->json([
            'status' => true,
            'action' => $action,
            'message' => $message,
            'wishlist_count' => $count
        ]);

        if (!$userId && !$request->cookie('temp_user_id')) {
             $response->withCookie(cookie('temp_user_id', $tempUserId, 60 * 24 * 30));
        }

        return $response;
    }
}
