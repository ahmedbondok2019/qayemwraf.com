<?php

use App\Http\Controllers\Admin\BroadcastController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\TestJntController;
use App\Http\Controllers\User\UsersController;
use App\Http\Controllers\Web\BlogController;
use App\Http\Controllers\Web\BrandController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\CheckoutController;
use App\Http\Controllers\Web\ContactController;
use App\Http\Controllers\Web\GiftController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\PageController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\SitemapController;
use App\Http\Controllers\Web\WishlistController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::get('/sitemap.xml', [SitemapController::class, 'index']);

// Social Login Routes (Outside localization group for consistent callback URL)
Route::get('/login/{provider}', [SocialLoginController::class, 'redirectToProvider']);
Route::get('/login/{provider}/callback', [SocialLoginController::class, 'handleProviderCallback']);

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'last_url', 'logVisits'],
], function () {
    Route::middleware(['Language'])->as('frontend.')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('index');

        //
        // Auth Routes
        // Login
        Route::get('/login/user', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'login']);
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

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
            Route::get('/home', [ProfileController::class, 'index'])->name('home');
            Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
            Route::get('/delete_account', [UsersController::class, 'delete_account'])->name('delete_account');
            // Addresses
            Route::get('/addresses', [ProfileController::class, 'addresses'])->name('addresses.index');
            Route::post('/addresses', [ProfileController::class, 'storeAddress'])->name('addresses.store');
            Route::put('/addresses/{id}', [ProfileController::class, 'updateAddress'])->name('addresses.update');
            Route::delete('/addresses/{id}', [ProfileController::class, 'deleteAddress'])->name('addresses.delete');
            Route::post('/addresses/{id}/set-main', [ProfileController::class, 'setMainAddress'])->name('addresses.set_main');
            Route::get('/get-cities/{governorate_id}', [ProfileController::class, 'getCities'])->name('get_cities_by_gov');

            // Notifications
            Route::get('/notifications', [ProfileController::class, 'notifications'])->name('notifications.index');

            // Orders
            Route::get('/orders', [ProfileController::class, 'orders'])->name('orders.index');
            Route::get('/orders/{id}', [ProfileController::class, 'show_order'])->name('orders.show');

            // Checkout
            Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
            Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
            Route::get('/checkout/success/{order_id}', [CheckoutController::class, 'success'])->name('checkout.success');
            Route::get('/shipping-cost', [CheckoutController::class, 'shipping_cost'])->name('shipping.cost');
            Route::post('/checkout/coupon/apply', [CheckoutController::class, 'applyCoupon'])->name('checkout.coupon.apply');
            Route::post('/checkout/coupon/remove', [CheckoutController::class, 'removeCoupon'])->name('checkout.coupon.remove');

            // Gifts
            Route::get('/gifts', [GiftController::class, 'index'])->name('gifts.index');
            Route::post('/gifts', [GiftController::class, 'store'])->name('gifts.store');
            Route::get('/gifts/success', [GiftController::class, 'success'])->name('gifts.success');

            // Address Management
            Route::get('/get-cities/{country_id}', [UsersController::class, 'getCities'])->name('get_cities');
            Route::get('/get-areas/{city_id}', [UsersController::class, 'getAreas'])->name('get_areas');
            Route::post('/address/set-main/{id}', [UsersController::class, 'setMainAddress'])->name('address.set_main');
        });

        // Contact Routes
        Route::get('/contact', [ContactController::class, 'index'])->name('contact');
        Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

        // Brand Routes
        Route::get('/brands', [BrandController::class, 'index'])->name('brands');

        // Product Routes
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/{category_slug}', [ProductController::class, 'index'])->name('products.category');
        Route::get('/product/{id}/{slug?}', [ProductController::class, 'show'])->name('products.show');
        Route::post('/product/rate', [ProductController::class, 'rate'])->name('products.rate');
        Route::get('/product/reviews/more', [ProductController::class, 'getMoreReviews'])->name('products.reviews.more');
        Route::get('/live-search', [ProductController::class, 'liveSearch'])->name('products.live_search');

        // Cart & Wishlist Routes
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');

        Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
        Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

        // Static Pages
        Route::get('/about-us', [PageController::class, 'show'])->defaults('slug', 'about-us')->name('about-us');
        Route::get('/latest-products', [ProductController::class, 'index'])->name('latest-products');
        Route::get('/best-sellers', [ProductController::class, 'index'])->name('best-sellers');
        Route::get('/page/{slug}', [PageController::class, 'show'])->name('page.show');

        // Blog Routes
        Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
        Route::get('/blog/{id}/{slug?}', [BlogController::class, 'show'])->name('blogs.show');

        // Broadcast Click Tracking
        Route::get('/br/{id}', [BroadcastController::class, 'trackClick'])->name('broadcast.click');
    });
});

Route::get('/test-jnt-order', [TestJntController::class, 'testOrder']);

// رابط مؤقت لتحديث قسم "لماذا تختارنا" و "المعرض" لمرة واحدة فقط (يمكن حذفه بعد استخدامه على السيرفر)
$updateWhyChooseUsCallback = function () {
    $setting = \App\Models\Setting::first();
    if (! $setting) {
        return response()->json(['status' => 'error', 'message' => 'لم يتم العثور على سجل الإعدادات.'], 404);
    }

    $setting->update([
        'why_choose_us_title' => [
            'ar' => 'لماذا تختار قايم ورف؟',
            'en' => 'Why Choose Qayem & Raf?',
        ],
        'why_choose_us_subtitle' => [
            'ar' => 'حلول تخزين هندسية متكاملة مصممة لتحمل أقصى الأحمال واستغلال مساحة مخزنك بالكامل بأعلى معايير الأمان.',
            'en' => 'Integrated storage and racking solutions engineered for heavy loads, maximum space utilization, and ultimate safety.',
        ],
        'why_choose_us_items' => \App\Models\Setting::defaultWhyChooseUsItems(),
        'showroom_tag' => [
            'ar' => 'موقع المعرض والمبيعات',
            'en' => 'Showroom & Sales Location',
        ],
        'showroom_title' => [
            'ar' => 'تفضل بزيارتنا في المعرض',
            'en' => 'Visit Our Showroom',
        ],
        'showroom_address' => [
            'ar' => '35 عمارات التوفيقية، شرق مدينة نصر (امتداد مصطفى النحاس - قرب النادي الأهلي)، القاهرة.',
            'en' => '35 Tawfikiya Buildings, East Nasr City (Mostafa El-Nahas Ext. - Near Al Ahly Club), Cairo.',
        ],
        'showroom_working_hours' => [
            'ar' => 'مواعيد العمل: يومياً من 9:00 ص إلى 10:00 م',
            'en' => 'Working Hours: Daily from 9:00 AM to 10:00 PM',
        ],
        'showroom_features' => [
            'ar' => 'معاينة وفحص كافة أنواع الأرفف والمشغولات',
            'en' => 'Inspect and examine all types of shelves and metal fixtures',
        ],
        'showroom_map_button_text' => [
            'ar' => 'فتح الموقع على Google Maps',
            'en' => 'Open Location on Google Maps',
        ],
        'showroom_map_url' => 'https://maps.google.com/?q=30.0561,31.3532',
        'showroom_map_iframe' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3453.6425110378036!2d31.3532!3d30.0561!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzDCsDAzJzIyLjAiTiAzMcKwMjEnMTEuNSJF!5e0!3m2!1sen!2seg!4v1620000000000!5m2!1sen!2seg',
    ]);

    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');

    return response()->json([
        'status' => 'success',
        'message' => 'تم تحديث عناصر "لماذا تختارنا" وقسم "المعرض" بنجاح 100% دون المساس بأي إعدادات أخرى، وتم تفريغ الكاش!',
        'showroom_section' => $setting->getShowroomSectionFormatted(),
    ], 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
};
