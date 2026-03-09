<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::get('cache-clear', function () {
    \Illuminate\Support\Facades\Artisan::call('config:cache');

    return 'cache-clear';
});

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
], function () {
    Route::middleware(['Language'])->group(function () {
        Route::prefix('vendor')->name('vendor.')->group(function () {

            Route::middleware(['guest:vendor', 'PreventBackHistory'])->group(function () {
                Route::get('welcome', function () {
                    return view('dashboard.vendor.welcome');
                })->name('welcome');
                Route::get('login', function () {
                    return view('dashboard.vendor.login');
                })->name('login');
                Route::post('/check', [\App\Http\Controllers\Vendor\VendorController::class, 'check'])->name('check');
                Route::get('register', [\App\Http\Controllers\Vendor\VendorController::class, 'first_step'])->name('register');
                Route::post('finish', [\App\Http\Controllers\Vendor\VendorController::class, 'finish'])->name('finish');
                Route::get('create_account', [\App\Http\Controllers\Vendor\VendorController::class, 'create_account'])->name('create_account');
                Route::post('create', [\App\Http\Controllers\Vendor\VendorController::class, 'create'])->name('create');

                Route::get('password/reset', [\App\Http\Controllers\Vendor\VendorController::class, 'forgetPassword'])->name('forgetPassword');
                Route::post('password/update', [\App\Http\Controllers\Auth\ResetPasswordController::class])->name('password.update');

                Route::get('download/contract', [\App\Http\Controllers\Vendor\VendorController::class, 'downloadContract']);
            });

            Route::middleware(['auth:vendor', 'PreventBackHistory'])->group(function () {
                Route::get('/', [\App\Http\Controllers\Vendor\VendorController::class, 'home']);
                Route::get('/home', [\App\Http\Controllers\Vendor\VendorController::class, 'home'])->name('home');

                Route::post('/logout', [\App\Http\Controllers\Vendor\VendorController::class, 'logout'])->name('logout');

                Route::get('profile/{id}', [\App\Http\Controllers\Vendor\VendorController::class, 'vieweditAdmins']);
                Route::post('updateProfile', [\App\Http\Controllers\Vendor\VendorController::class, 'updateProfile']);
                Route::get('download/{vendor}', [\App\Http\Controllers\Vendor\VendorController::class, 'downloadContract']);

                Route::prefix('products')->group(function () {
                    Route::get('all', [\App\Http\Controllers\Vendor\ProductsController::class, 'index'])->name('users.Specialist');
                    Route::get('create', [\App\Http\Controllers\Vendor\ProductsController::class, 'create']);
                    Route::get('addTrans/{product_id}', [\App\Http\Controllers\Vendor\ProductsController::class, 'addTrans']);
                    Route::post('addProductTrans', [\App\Http\Controllers\Vendor\ProductsController::class, 'addProductTrans']);
                    Route::get('edit/{id}', [\App\Http\Controllers\Vendor\ProductsController::class, 'edit']);
                    Route::post('updateProduct', [\App\Http\Controllers\Vendor\ProductsController::class, 'update']);
                    route::post('createProduct', [\App\Http\Controllers\Vendor\ProductsController::class, 'store']);
                    Route::get('delete/{id}', [\App\Http\Controllers\Vendor\ProductsController::class, 'delete']);
                    Route::get('delete/image/{id}', [\App\Http\Controllers\Vendor\ProductsController::class, 'delete_image']);
                    Route::post('change_status', [\App\Http\Controllers\Vendor\ProductsController::class, 'change_status']);
                    Route::post('getProductOptionItems', [\App\Http\Controllers\Vendor\ProductsController::class, 'getProductOptionItems']);
                    Route::get('export_xls', [\App\Http\Controllers\Vendor\ProductsController::class, 'export_xls']);
                    Route::post('uploadImages', [\App\Http\Controllers\Vendor\ProductsController::class, 'uploadImages']);
                    Route::get('readFiles', [\App\Http\Controllers\Vendor\ProductsController::class, 'readFiles'])->name('readFiles');
                    Route::post('delete_image', [\App\Http\Controllers\Vendor\ProductsController::class, 'delete_image']);
                });

                Route::prefix('orders')->group(function () {
                    Route::get('all', [\App\Http\Controllers\Vendor\OrdersController::class, 'index']);
                    Route::get('edit/{id}', [\App\Http\Controllers\Vendor\OrdersController::class, 'edit']);
                    Route::post('update', [\App\Http\Controllers\Vendor\OrdersController::class, 'update']);
                    Route::post('updateOrder', [\App\Http\Controllers\Vendor\OrdersController::class, 'updateOrder']);
                    Route::get('delete/{id}', [\App\Http\Controllers\Vendor\OrdersController::class, 'delete']);
                    Route::any('invoice_pdf/{id}', [\App\Http\Controllers\Vendor\OrdersController::class, 'invoice_pdf']);
                    Route::any('print/{id}', [\App\Http\Controllers\Vendor\OrdersController::class, 'print']);
                });

                Route::prefix('order_returns')->group(function () {
                    Route::get('all', [\App\Http\Controllers\Vendor\OrdersController::class, 'order_returns']);
                    Route::get('edit/{id}', [\App\Http\Controllers\Vendor\OrdersController::class, 'edit']);
                    Route::post('update', [\App\Http\Controllers\Vendor\OrdersController::class, 'update']);
                    Route::get('delete/{id}', [\App\Http\Controllers\Vendor\OrdersController::class, 'delete']);
                    Route::any('invoice_pdf/{id}', [\App\Http\Controllers\Vendor\OrdersController::class, 'invoice_pdf']);
                    Route::any('print/{id}', [\App\Http\Controllers\Vendor\OrdersController::class, 'print']);
                });

                Route::prefix('orders_notcompleted')->group(function () {
                    Route::get('all', [\App\Http\Controllers\Vendor\OrdersController::class, 'orders_notcompleted']);
                    Route::get('edit/{id}', [\App\Http\Controllers\Vendor\OrdersController::class, 'edit']);
                    Route::post('update', [\App\Http\Controllers\Vendor\OrdersController::class, 'update']);
                    Route::get('delete/{id}', [\App\Http\Controllers\Vendor\OrdersController::class, 'delete']);
                    Route::any('invoice_pdf/{id}', [\App\Http\Controllers\Vendor\OrdersController::class, 'invoice_pdf']);
                    Route::any('print/{id}', [\App\Http\Controllers\Vendor\OrdersController::class, 'print']);
                });

                Route::prefix('payments')->group(function () {
                    Route::get('all', [\App\Http\Controllers\Vendor\PaymentsController::class, 'index']);
                    Route::get('edit/{id}', [\App\Http\Controllers\Vendor\PaymentsController::class, 'edit']);
                    Route::any('invoice_pdf/{id}', [\App\Http\Controllers\Vendor\PaymentsController::class, 'invoice_pdf']);
                    Route::any('print/{id}', [\App\Http\Controllers\Vendor\PaymentsController::class, 'print']);
                });
            });

            Route::get('getAllArea', [\App\Http\Controllers\Vendor\VendorController::class, 'getAllArea']);
            Route::post('getAllCity', [\App\Http\Controllers\Vendor\VendorController::class, 'getAllCity']);
            Route::post('getAccountType', [\App\Http\Controllers\Vendor\VendorController::class, 'getAccountType']);
        });
    });
});

Auth::routes();

//    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
