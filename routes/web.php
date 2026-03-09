<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\User\UsersController;
use App\Http\Controllers\Web\HomeController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Route::get('/sitemap.xml', [App\Http\Controllers\Web\SitemapController::class, 'index']);

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'last_url','logVisits'],
], function () {
    Route::middleware(['Language'])->as("frontend.")->group(function () {
        Route::get("/", [HomeController::class, 'index'])->name("index");
        //
        // Auth Routes
        // Login
        Route::get('/login/user', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'login']);
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

        Route::get('/login/{provider}', [App\Http\Controllers\Auth\SocialLoginController::class, 'redirectToProvider']);
        Route::get('/login/{provider}/callback', [App\Http\Controllers\Auth\SocialLoginController::class, 'handleProviderCallback']);
            
        // Registration
        Route::get('/register/user', [RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register', [RegisterController::class, 'register']);

        // Password Reset
        Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
        Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
        Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
        Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
        // User Profile & Checkout Routes
        Route::group(['as' => 'user.', 'middleware' => ['auth']], function () {
            Route::get('/home', [App\Http\Controllers\Web\ProfileController::class, 'index'])->name('home');
            Route::put('/profile/update', [App\Http\Controllers\Web\ProfileController::class, 'update'])->name('profile.update');
            Route::get('/delete_account', [UsersController::class, 'delete_account'])->name('delete_account');
            // Addresses
            Route::get('/addresses', [App\Http\Controllers\Web\ProfileController::class, 'addresses'])->name('addresses.index');
            Route::post('/addresses', [App\Http\Controllers\Web\ProfileController::class, 'storeAddress'])->name('addresses.store');
            Route::put('/addresses/{id}', [App\Http\Controllers\Web\ProfileController::class, 'updateAddress'])->name('addresses.update');
            Route::delete('/addresses/{id}', [App\Http\Controllers\Web\ProfileController::class, 'deleteAddress'])->name('addresses.delete');
            Route::post('/addresses/{id}/set-main', [App\Http\Controllers\Web\ProfileController::class, 'setMainAddress'])->name('addresses.set_main');
            Route::get('/get-cities/{governorate_id}', [App\Http\Controllers\Web\ProfileController::class, 'getCities'])->name('get_cities_by_gov');
            
            // Notifications
            Route::get('/notifications', [App\Http\Controllers\Web\ProfileController::class, 'notifications'])->name('notifications.index');
            
            // Orders
            Route::get('/orders', [App\Http\Controllers\Web\ProfileController::class, 'orders'])->name('orders.index');
            Route::get('/orders/{id}', [App\Http\Controllers\Web\ProfileController::class, 'show_order'])->name('orders.show');

            // Checkout
            Route::get('/checkout', [App\Http\Controllers\Web\CheckoutController::class, 'index'])->name('checkout.index');
            Route::post('/checkout', [App\Http\Controllers\Web\CheckoutController::class, 'store'])->name('checkout.store');
            Route::get('/checkout/success/{order_id}', [App\Http\Controllers\Web\CheckoutController::class, 'success'])->name('checkout.success');
            Route::get('/shipping-cost', [App\Http\Controllers\Web\CheckoutController::class, 'shipping_cost'])->name('shipping.cost');
            Route::post('/checkout/coupon/apply', [App\Http\Controllers\Web\CheckoutController::class, 'applyCoupon'])->name('checkout.coupon.apply');
            Route::post('/checkout/coupon/remove', [App\Http\Controllers\Web\CheckoutController::class, 'removeCoupon'])->name('checkout.coupon.remove');
            
            // Gifts
            Route::get('/gifts', [App\Http\Controllers\Web\GiftController::class, 'index'])->name('gifts.index');
            Route::post('/gifts', [App\Http\Controllers\Web\GiftController::class, 'store'])->name('gifts.store');
            Route::get('/gifts/success', [App\Http\Controllers\Web\GiftController::class, 'success'])->name('gifts.success');

            // Address Management
            Route::get('/get-cities/{country_id}', [App\Http\Controllers\User\UsersController::class, 'getCities'])->name('get_cities');
            Route::get('/get-areas/{city_id}', [App\Http\Controllers\User\UsersController::class, 'getAreas'])->name('get_areas');
            Route::post('/address/set-main/{id}', [App\Http\Controllers\User\UsersController::class, 'setMainAddress'])->name('address.set_main');
        });

        // Contact Routes
        Route::get('/contact', [App\Http\Controllers\Web\ContactController::class, 'index'])->name('contact');
        Route::post('/contact', [App\Http\Controllers\Web\ContactController::class, 'store'])->name('contact.store');

        // Brand Routes
        Route::get('/brands', [App\Http\Controllers\Web\BrandController::class, 'index'])->name('brands');

        // Product Routes
        Route::get('/products', [App\Http\Controllers\Web\ProductController::class, 'index'])->name('products.index');
        Route::get('/products/{category_slug}', [App\Http\Controllers\Web\ProductController::class, 'index'])->name('products.category');
        Route::get('/product/{id}/{slug?}', [App\Http\Controllers\Web\ProductController::class, 'show'])->name('products.show');
        Route::post('/product/rate', [App\Http\Controllers\Web\ProductController::class, 'rate'])->name('products.rate');
        Route::get('/product/reviews/more', [App\Http\Controllers\Web\ProductController::class, 'getMoreReviews'])->name('products.reviews.more');
        Route::get('/live-search', [App\Http\Controllers\Web\ProductController::class, 'liveSearch'])->name('products.live_search');

        // Cart & Wishlist Routes
        Route::get('/cart', [App\Http\Controllers\Web\CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add', [App\Http\Controllers\Web\CartController::class, 'addToCart'])->name('cart.add');

        Route::get('/wishlist', [App\Http\Controllers\Web\WishlistController::class, 'index'])->name('wishlist.index');
        Route::post('/wishlist/toggle', [App\Http\Controllers\Web\WishlistController::class, 'toggle'])->name('wishlist.toggle');

        // Static Pages
        Route::get('/page/{slug}', [App\Http\Controllers\Web\PageController::class, 'show'])->name('page.show');

        // Blog Routes
        Route::get('/blogs', [App\Http\Controllers\Web\BlogController::class, 'index'])->name('blogs.index');
        Route::get('/blog/{id}/{slug?}', [App\Http\Controllers\Web\BlogController::class, 'show'])->name('blogs.show');

        // Broadcast Click Tracking
        Route::get('/br/{id}', [\App\Http\Controllers\Admin\BroadcastController::class, 'trackClick'])->name('broadcast.click');
    });
});

Route::get('/test-jnt-order', [App\Http\Controllers\TestJntController::class, 'testOrder']);

