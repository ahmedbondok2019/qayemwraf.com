<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiV1\AuthController;
use App\Http\Controllers\ApiV1\UserAddressController;
use App\Http\Controllers\ApiV1\LocationController;
use App\Http\Controllers\ApiV1\CartController;
use App\Http\Controllers\ApiV1\WishlistController;
use App\Http\Controllers\ApiV1\SliderController;
use App\Http\Controllers\ApiV1\CategoryController;
use App\Http\Controllers\ApiV1\BrandController;
use App\Http\Controllers\ApiV1\SettingController;
use App\Http\Controllers\ApiV1\BlogController;
use App\Http\Controllers\ApiV1\ContactController;
use App\Http\Controllers\ApiV1\AdvertisementController;
use App\Http\Controllers\ApiV1\OfferController;
use App\Http\Controllers\ApiV1\ProductController;
use App\Http\Controllers\ApiV1\HomeController;
use App\Http\Controllers\ApiV1\CheckoutController;
use App\Http\Controllers\ApiV1\ProfileController;
use App\Http\Controllers\ApiV1\OrderController;
use App\Http\Controllers\ApiV1\GiftController;
use App\Http\Controllers\ApiV1\OptionController;
use App\Http\Controllers\ApiV1\OrderServiceController;
use App\Http\Controllers\ApiV1\PaymentMethodController;
use App\Http\Controllers\ApiV1\PageController;
use App\Http\Controllers\ApiV1\RatingController;
// 
Route::group(['middleware' => ['Language']], function () {
    Route::prefix('v1')->group(function () {
        Route::post('/registerUser', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/social-login', [AuthController::class, 'socialLogin']);
        Route::post('/forget-password', [AuthController::class, 'forgetPassword']);
        Route::post('/reset-password', [AuthController::class, 'resetPassword']);
        Route::post('/fcm-subscribe', [AuthController::class, 'subscribeToTopic']);
        
        Route::get('/home', [HomeController::class, 'index']);
        Route::get('/flash-sales', [HomeController::class, 'flashSales']);

        // General
        Route::get('configuration', [SettingController::class, 'configuration']);
        Route::get('settings', [SettingController::class, 'index']);
        Route::get('order-services', [OrderServiceController::class, 'index']);
        Route::get('payment-methods', [PaymentMethodController::class, 'index']);
        Route::get('sliders', [SliderController::class, 'index']);
        Route::get('advertisements', [AdvertisementController::class, 'index']);
        Route::get('/offers', [OfferController::class, 'index']);
        Route::post('/contact-us', [ContactController::class, 'store']);
        Route::get('/blog-categories', [BlogController::class, 'categories']);
        Route::get('/blogs', [BlogController::class, 'index']);
        Route::get('/blogs/{id}', [BlogController::class, 'show']);
        
        // Pages
        Route::get('/pages', [PageController::class, 'index']);
        Route::get('/pages/{slug}', [PageController::class, 'show']);
        
        // Home Components & Discovery
        Route::get('/settings', [SettingController::class, 'index']);
        Route::get('/sliders', [SliderController::class, 'index']);
        Route::get('/categories', [CategoryController::class, 'index']);
        Route::get('/sub-categories', [CategoryController::class, 'subCategories']);
        Route::get('/brands', [BrandController::class, 'index']);
        Route::get('/products', [ProductController::class, 'index']);
        Route::get('/products/{id}', [ProductController::class, 'show']);
        Route::get('/best-sellers', [ProductController::class, 'bestSellers']);
        Route::get('/latest-products', [ProductController::class, 'latestProducts']);
        Route::get('/products/{id}/options', [OptionController::class, 'productOptions']);
        
        // Ratings
        Route::middleware('auth:sanctum')->post('/rate-product', [RatingController::class, 'store']);

        Route::get('/options', [OptionController::class, 'index']);
        Route::get('/options', [OptionController::class, 'index']);
        
        // Locations (Public)
        Route::get('/countries', [LocationController::class, 'countries']);
        Route::get('/governorates/{country_id}', [LocationController::class, 'governorates']);
        Route::get('/cities/{governorate_id}', [LocationController::class, 'cities']);

        // Checkout Summary & Coupon (Shared)
        Route::post('/checkout/summary', [CheckoutController::class, 'summary']);
        Route::post('/checkout/apply-coupon', [CheckoutController::class, 'applyCoupon']);

        // Cart & Wishlist (Shared Auth/Guest)
        Route::get('/cart', [CartController::class, 'index']);
        Route::post('/add-to-cart', [CartController::class, 'store']);
        Route::post('/cart/{id}', [CartController::class, 'update']);
        Route::delete('/cart/{id}', [CartController::class, 'destroy']);
        
        Route::get('/wishlist', [WishlistController::class, 'index']);
        Route::post('/wishlist/toggle', [WishlistController::class, 'toggle']);
        
        Route::middleware('auth:sanctum')->group(function () {
            // Checkout
            Route::post('/checkout/store', [CheckoutController::class, 'store']);

            // Profile
            Route::get('/profile', [ProfileController::class, 'show']);
            Route::post('/profile', [ProfileController::class, 'update']);
            Route::post('/update-fcm-token', [ProfileController::class, 'updateFcmToken']);

            // Orders
            Route::get('/orders', [OrderController::class, 'index']);
            Route::get('/orders/{id}', [OrderController::class, 'show']);
            Route::post('/cancel-order', [OrderController::class, 'cancel']);

            // Gifts
            Route::get('/gifts', [GiftController::class, 'index']);
            Route::post('/gifts/claim', [GiftController::class, 'store']);

            Route::post('/logout', [AuthController::class, 'logout']);
            Route::post('/delete_account', [AuthController::class, 'deleteAccount']);
            
            // User Addresses
            Route::get('/addresses', [UserAddressController::class, 'index']);
            Route::post('/addresses', [UserAddressController::class, 'store']);
            Route::post('/addresses/{id}', [UserAddressController::class, 'update']);
            Route::delete('/addresses/{id}', [UserAddressController::class, 'destroy']);
            Route::post('/addresses/{id}/set-main', [UserAddressController::class, 'setMain']);
        });
    });


});
 