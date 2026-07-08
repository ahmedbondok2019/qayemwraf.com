<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdvertisementController;
use App\Http\Controllers\Admin\AuthAdminController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\FlashSaleController;
use App\Http\Controllers\Admin\GovernorateController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ProductBrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductStockController;
use App\Http\Controllers\Admin\ShippingRuleController;
use App\Http\Controllers\Admin\BroadcastController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
], function () {

    // Guest Routes (Login)
    Route::group(['prefix' => 'admin-2026', 'as' => 'admin.', 'middleware' => ['guest:admin']], function () {
        Route::get('login', [AuthAdminController::class, 'login'])->name('login');
        Route::post('login', [AuthAdminController::class, 'check'])->name('check');
    });

    // Authenticated Routes (Logout, Dashboard, Categories)
    Route::group(['prefix' => 'admin-2026', 'as' => 'admin.', 'middleware' => ['auth:admin', 'Language']], function () {
        Route::post('logout', [AuthAdminController::class, 'logout'])->name('logout');
        
        // Dashboard
        Route::get('/', [AdminController::class, 'home'])->name('home');

        // Categories
        Route::resource('categories', CategoryController::class);

        // Pages
        Route::resource('pages', PageController::class);

        // Countries
        Route::resource('countries', CountryController::class);

        // Governorates
        Route::resource('governorates',GovernorateController::class);

        // Cities
        Route::resource('cities', CityController::class);

        // Offers
        Route::resource('offers', OfferController::class);

        // Payment Methods
        Route::resource('payment_methods', PaymentMethodController::class)->only(['index', 'edit', 'update']);

        // Coupons
        Route::resource('coupons', CouponController::class);

        // Sliders
        Route::resource('sliders', SliderController::class);

        // Product Brands
        Route::resource('product_brands', ProductBrandController::class);
        
        // Products
        Route::get('products/import', [ProductController::class, 'import'])->name('products.import');
        Route::post('products/import', [ProductController::class, 'importProcess'])->name('products.import_process');
        Route::get('products/import-template', [ProductController::class, 'downloadTemplate'])->name('products.import_template');
        Route::get('products/export-categories', [ProductController::class, 'exportCategories'])->name('products.export_categories');
        Route::get('products/export-brands', [ProductController::class, 'exportBrands'])->name('products.export_brands');
        Route::resource('products', ProductController::class);
        Route::get('products/stock/update', [ProductStockController::class, 'index'])->name('products.stock.index');
        Route::post('products/stock/upload', [ProductStockController::class, 'upload'])->name('products.stock.upload');
        Route::get('products/stock/show/{id}', [ProductStockController::class, 'show'])->name('products.stock.show');
        Route::get('products/stock/download-template', [ProductStockController::class, 'downloadTemplate'])->name('products.stock.download_template');
        Route::get('products/option/values/{id}', [ProductController::class, 'getOptionValues'])->name('products.option.values'); // API/Ajax route
        Route::post('products/toggle-gift/{id}', [ProductController::class, 'toggleGift'])->name('products.toggle_gift');
        Route::post('products/toggle-home/{id}', [ProductController::class, 'toggleShowOnHome'])->name('products.toggle_home');

        // Options
        Route::resource('options', OptionController::class);

        // Shipping Rules
        Route::resource('shipping_rules', ShippingRuleController::class);
        Route::get('shipping_rules/get/governorates', [ShippingRuleController::class, 'getGovernorates'])->name('shipping_rules.get_governorates');
        
        // Flash Sales
        Route::get('flash_sales/search/products', [FlashSaleController::class, 'searchProducts'])->name('flash_sales.search_products');
        Route::resource('flash_sales', FlashSaleController::class);

        // Settings
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('settings/update', [SettingController::class, 'update'])->name('settings.update');

        // Static Translations
        Route::resource('static_translations', App\Http\Controllers\Admin\StaticTranslationController::class);

        // Currencies
        Route::resource('currencies', App\Http\Controllers\Admin\CurrenciesController::class);

        // Order Services
        Route::resource('order_services', App\Http\Controllers\Admin\OrderServiceController::class);

        // Orders
        Route::get('orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{id}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
        Route::post('orders/update-status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update_status');

        // Gifts
        Route::get('gifts', [App\Http\Controllers\Admin\GiftController::class, 'index'])->name('gifts.index');
        Route::get('gifts/{id}', [App\Http\Controllers\Admin\GiftController::class, 'show'])->name('gifts.show');
        Route::post('gifts/update-status', [App\Http\Controllers\Admin\GiftController::class, 'updateStatus'])->name('gifts.update_status');

        // Advertisements
        Route::resource('advertisements', App\Http\Controllers\Admin\AdvertisementController::class);

        // Roles & Permissions
        Route::resource('roles', App\Http\Controllers\Admin\RoleController::class);

        // Blog & Categories
        Route::post('blog_categories/change-status', [App\Http\Controllers\Admin\BlogCategoryController::class, 'change_status'])->name('blog_categories.change_status');
        Route::resource('blog_categories', BlogCategoryController::class);
        
        Route::get('blogs', [BlogController::class, 'index'])->name('blogs.index');
        Route::get('blogs/create', [BlogController::class, 'create'])->name('blogs.create');
        Route::post('blogs/store', [BlogController::class, 'store'])->name('blogs.store');
        Route::get('blogs/edit/{id}', [BlogController::class, 'edit'])->name('blogs.edit');
        Route::put('blogs/update/{id}', [BlogController::class, 'update'])->name('blogs.update');
        Route::delete('blogs/delete/{id}', [BlogController::class, 'delete'])->name('blogs.delete');
        Route::post('blogs/change-status', [BlogController::class, 'change_status'])->name('blogs.change_status');
        Route::get('blogs/addTrans/{id}', [BlogController::class, 'addTrans'])->name('blogs.addTrans');
        Route::post('blogs/storeTrans/{id}', [BlogController::class, 'storeTrans'])->name('blogs.storeTrans');

        // Broadcasting
        Route::resource('broadcasts', BroadcastController::class);

        // Profile
        Route::get('profile', [AdminController::class, 'profile'])->name('profile');
        Route::post('profile/update', [AdminController::class, 'update_profile'])->name('profile.update');

        // System Admins

        // Public Users
        Route::get('users/MarkAsRead', [AdminController::class, 'MarkAsRead'])->name('users.mark_as_read');
        Route::get('users/get-governorates/{country_id}', [UserController::class, 'getGovernorates'])->name('users.get_governorates');
        Route::get('users/get-cities/{governorate_id}', [UserController::class, 'getCities'])->name('users.get_cities');
        Route::get('users/{user}/cart', [UserController::class, 'cart'])->name('users.cart');
        Route::get('users/{user}/wishlist', [UserController::class, 'wishlist'])->name('users.wishlist');
        Route::resource('users', UserController::class);

        // Contacts
        Route::get('contacts', [ContactController::class, 'index'])->name('contacts.index');
        Route::get('contacts/{id}', [ContactController::class, 'show'])->name('contacts.show');
        Route::delete('contacts/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy');
    });
});
