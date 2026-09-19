<?php

use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Vendor\OrdersController;
use App\Http\Controllers\Vendor\PaymentsController;
use App\Http\Controllers\Vendor\ProductsController;
use App\Http\Controllers\Vendor\VendorController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::get('cache-clear', function () {
    Artisan::call('config:cache');

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
                Route::post('/check', [VendorController::class, 'check'])->name('check');
                Route::get('register', [VendorController::class, 'first_step'])->name('register');
                Route::post('finish', [VendorController::class, 'finish'])->name('finish');
                Route::get('create_account', [VendorController::class, 'create_account'])->name('create_account');
                Route::post('create', [VendorController::class, 'create'])->name('create');

                Route::get('password/reset', [VendorController::class, 'forgetPassword'])->name('forgetPassword');
                Route::post('password/update', [ResetPasswordController::class])->name('password.update');

                Route::get('download/contract', [VendorController::class, 'downloadContract']);
            });

            Route::middleware(['auth:vendor', 'PreventBackHistory'])->group(function () {
                Route::get('/', [VendorController::class, 'home']);
                Route::get('/home', [VendorController::class, 'home'])->name('home');

                Route::post('/logout', [VendorController::class, 'logout'])->name('logout');

                Route::get('profile/{id}', [VendorController::class, 'vieweditAdmins']);
                Route::post('updateProfile', [VendorController::class, 'updateProfile']);
                Route::get('download/{vendor}', [VendorController::class, 'downloadContract']);

                Route::prefix('products')->group(function () {
                    Route::get('all', [ProductsController::class, 'index'])->name('users.Specialist');
                    Route::get('create', [ProductsController::class, 'create']);
                    Route::get('addTrans/{product_id}', [ProductsController::class, 'addTrans']);
                    Route::post('addProductTrans', [ProductsController::class, 'addProductTrans']);
                    Route::get('edit/{id}', [ProductsController::class, 'edit']);
                    Route::post('updateProduct', [ProductsController::class, 'update']);
                    Route::post('createProduct', [ProductsController::class, 'store']);
                    Route::get('delete/{id}', [ProductsController::class, 'delete']);
                    Route::get('delete/image/{id}', [ProductsController::class, 'delete_image']);
                    Route::post('change_status', [ProductsController::class, 'change_status']);
                    Route::post('getProductOptionItems', [ProductsController::class, 'getProductOptionItems']);
                    Route::get('export_xls', [ProductsController::class, 'export_xls']);
                    Route::post('uploadImages', [ProductsController::class, 'uploadImages']);
                    Route::get('readFiles', [ProductsController::class, 'readFiles'])->name('readFiles');
                    Route::post('delete_image', [ProductsController::class, 'delete_image']);
                });

                Route::prefix('orders')->group(function () {
                    Route::get('all', [OrdersController::class, 'index']);
                    Route::get('edit/{id}', [OrdersController::class, 'edit']);
                    Route::post('update', [OrdersController::class, 'update']);
                    Route::post('updateOrder', [OrdersController::class, 'updateOrder']);
                    Route::get('delete/{id}', [OrdersController::class, 'delete']);
                    Route::any('invoice_pdf/{id}', [OrdersController::class, 'invoice_pdf']);
                    Route::any('print/{id}', [OrdersController::class, 'print']);
                });

                Route::prefix('order_returns')->group(function () {
                    Route::get('all', [OrdersController::class, 'order_returns']);
                    Route::get('edit/{id}', [OrdersController::class, 'edit']);
                    Route::post('update', [OrdersController::class, 'update']);
                    Route::get('delete/{id}', [OrdersController::class, 'delete']);
                    Route::any('invoice_pdf/{id}', [OrdersController::class, 'invoice_pdf']);
                    Route::any('print/{id}', [OrdersController::class, 'print']);
                });

                Route::prefix('orders_notcompleted')->group(function () {
                    Route::get('all', [OrdersController::class, 'orders_notcompleted']);
                    Route::get('edit/{id}', [OrdersController::class, 'edit']);
                    Route::post('update', [OrdersController::class, 'update']);
                    Route::get('delete/{id}', [OrdersController::class, 'delete']);
                    Route::any('invoice_pdf/{id}', [OrdersController::class, 'invoice_pdf']);
                    Route::any('print/{id}', [OrdersController::class, 'print']);
                });

                Route::prefix('payments')->group(function () {
                    Route::get('all', [PaymentsController::class, 'index']);
                    Route::get('edit/{id}', [PaymentsController::class, 'edit']);
                    Route::any('invoice_pdf/{id}', [PaymentsController::class, 'invoice_pdf']);
                    Route::any('print/{id}', [PaymentsController::class, 'print']);
                });
            });

            Route::get('getAllArea', [VendorController::class, 'getAllArea']);
            Route::post('getAllCity', [VendorController::class, 'getAllCity']);
            Route::post('getAccountType', [VendorController::class, 'getAccountType']);
        });
    });
});

Auth::routes();

//    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
