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
        // === المصادقة والحسابات ===
        // تسجيل حساب جديد للمستخدم
        Route::post('/registerUser', [AuthController::class, 'register']);
        // تسجيل الدخول بواسطة البريد الإلكتروني أو الهاتف وكلمة المرور
        Route::post('/login', [AuthController::class, 'login']);
        // تسجيل الدخول عبر وسائل التواصل الاجتماعي (جوجل / فيسبوك)
        Route::post('/social-login', [AuthController::class, 'socialLogin']);
        // طلب إرسال رابط / رمز استعادة كلمة المرور
        Route::post('/forget-password', [AuthController::class, 'forgetPassword']);
        // إعادة تعيين كلمة المرور بواسطة الرمز
        Route::post('/reset-password', [AuthController::class, 'resetPassword']);
        // الاشتراك في الإشعارات عبر Firebase (FCM)
        Route::post('/fcm-subscribe', [AuthController::class, 'subscribeToTopic']);
        
        // === الصفحة الرئيسية والعروض السريعة ===
        // جلب جميع بيانات الصفحة الرئيسية (السلايدرز، الأقسام الرئيسية، الفلاش سيل، العروض، الأفضل مبيعاً، لماذا تختارنا، الكتالوج)
        Route::get('/home', [HomeController::class, 'index']);
        // جلب قائمة عروض التخفيضات السريعة (فلاش سيل)
        Route::get('/flash-sales', [HomeController::class, 'flashSales']);

        // === الإعدادات والمعلومات العامة ===
        // جلب تكوينات التطبيق والإعدادات العامة (الكتالوج، وسائل التواصل، السياسات)
        Route::get('configuration', [SettingController::class, 'configuration']);
        // جلب إعدادات التطبيق التفصيلية
        Route::get('settings', [SettingController::class, 'index']);
        // جلب خدمات الطلبات الإضافية (مثل التركيب والتوصيل الخاص)
        Route::get('order-services', [OrderServiceController::class, 'index']);
        // جلب طرق الدفع المتاحة
        Route::get('payment-methods', [PaymentMethodController::class, 'index']);
        // جلب السلايدرز (شرائح العرض متحركة)
        Route::get('sliders', [SliderController::class, 'index']);
        // جلب الإعلانات البنريّة
        Route::get('advertisements', [AdvertisementController::class, 'index']);
        // جلب العروض الخاصة والتخفيضات
        Route::get('/offers', [OfferController::class, 'index']);
        // إرسال نموذج تواصل معنا
        Route::post('/contact-us', [ContactController::class, 'store']);
        // جلب أقسام المدونة
        Route::get('/blog-categories', [BlogController::class, 'categories']);
        // جلب قائمة المقالات والمدونة
        Route::get('/blogs', [BlogController::class, 'index']);
        // جلب تفاصيل مقال محدد بالمعرف
        Route::get('/blogs/{id}', [BlogController::class, 'show']);
        
        // === الصفحات التعريفية والتنظيمية ===
        // جلب قائمة الصفحات التعريفية (من نحن، الشروط، السياسات)
        Route::get('/pages', [PageController::class, 'index']);
        // جلب تفاصيل صفحة تعريفية بواسطة الرابط الصديق (Slug)
        Route::get('/pages/{slug}', [PageController::class, 'show']);
        
        // === الأقسام والمنتجات والتصفح ===
        // جلب الأقسام الرئيسية المتاحة للعرض
        Route::get('/categories', [CategoryController::class, 'index']);
        // جلب الأقسام الفرعية
        Route::get('/sub-categories', [CategoryController::class, 'subCategories']);
        // جلب العلامات التجارية والشركات المصنعة (البراندات)
        Route::get('/brands', [BrandController::class, 'index']);
        // جلب قائمة المنتجات مع دعم الفلترة والبحث
        Route::get('/products', [ProductController::class, 'index']);
        // جلب تفاصيل منتج محدد بواسطة المعرف
        Route::get('/products/{id}', [ProductController::class, 'show']);
        // جلب المنتجات الأكثر مبيعاً
        Route::get('/best-sellers', [ProductController::class, 'bestSellers']);
        // جلب أحدث المنتجات المضافة
        Route::get('/latest-products', [ProductController::class, 'latestProducts']);
        // جلب خيارات ومواصفات المنتج المحدد
        Route::get('/products/{id}/options', [OptionController::class, 'productOptions']);
        // جلب جميع الخيارات المتاحة للمنتجات
        Route::get('/options', [OptionController::class, 'index']);
        
        // === تقييمات المنتجات ===
        // إضافة تقييم ومراجعة لمنتج (يتطلب تسجيل الدخول)
        Route::middleware('auth:sanctum')->post('/rate-product', [RatingController::class, 'store']);

        // === المناطق والمواقع الجغرافية ===
        // جلب قائمة الدول المتاحة
        Route::get('/countries', [LocationController::class, 'countries']);
        // جلب المحافظات التابعة لدولة محدودة
        Route::get('/governorates/{country_id}', [LocationController::class, 'governorates']);
        // جلب المدن التابعة لمحافظة محددة
        Route::get('/cities/{governorate_id}', [LocationController::class, 'cities']);

        // === ملخص الشراء وكوبونات الخصم ===
        // حساب ملخص إجمالي الطلب والشحن قبل إتمام الشراء
        Route::post('/checkout/summary', [CheckoutController::class, 'summary']);
        // تطبيق كوبون خصم على الطلب الحالي
        Route::post('/checkout/apply-coupon', [CheckoutController::class, 'applyCoupon']);

        // === سلة التسوق وقائمة الرغبات ===
        // جلب محتويات سلة التسوق الحالية
        Route::get('/cart', [CartController::class, 'index']);
        // إضافة منتج جديد إلى سلة التسوق
        Route::post('/add-to-cart', [CartController::class, 'store']);
        // تحديث كمية أو خيارات عنصر في السلة
        Route::post('/cart/{id}', [CartController::class, 'update']);
        // حذف عنصر من سلة التسوق
        Route::delete('/cart/{id}', [CartController::class, 'destroy']);
        
        // جلب قائمة الرغبات / المفضلة
        Route::get('/wishlist', [WishlistController::class, 'index']);
        // إضافة أو إزالة منتج من قائمة الرغبات
        Route::post('/wishlist/toggle', [WishlistController::class, 'toggle']);
        
        // === المسارات الخاصة بالمستخدمين المسجلين فقط ===
        Route::middleware('auth:sanctum')->group(function () {
            // إنهاء الشراء وتأكيد الطلب
            Route::post('/checkout/store', [CheckoutController::class, 'store']);

            // جلب البيانات الشخصية للمستخدم الحالي
            Route::get('/profile', [ProfileController::class, 'show']);
            // تحديث البيانات الشخصية للمستخدم الحالي
            Route::post('/profile', [ProfileController::class, 'update']);
            // تحديث رمز الإشعارات (FCM Token) للمستخدم
            Route::post('/update-fcm-token', [ProfileController::class, 'updateFcmToken']);

            // جلب قائمة طلبات المستخدم السابقة والحالية
            Route::get('/orders', [OrderController::class, 'index']);
            // جلب تفاصيل طلب محدد برقم الطلب
            Route::get('/orders/{id}', [OrderController::class, 'show']);
            // إلغاء طلب مسبق للمستخدم
            Route::post('/cancel-order', [OrderController::class, 'cancel']);

            // جلب الهدايا والمكافآت المتاحة للمستخدم
            Route::get('/gifts', [GiftController::class, 'index']);
            // المطالبة بهدية أو مكافأة
            Route::post('/gifts/claim', [GiftController::class, 'store']);

            // تسجيل الخروج وإلغاء الرمز
            Route::post('/logout', [AuthController::class, 'logout']);
            // حذف حساب المستخدم نهائياً
            Route::post('/delete_account', [AuthController::class, 'deleteAccount']);
            
            // جلب العناوين المسجلة للمستخدم
            Route::get('/addresses', [UserAddressController::class, 'index']);
            // إضافة عنوان شحن جديد
            Route::post('/addresses', [UserAddressController::class, 'store']);
            // تحديث بيانات عنوان شحن محدد
            Route::match(['put', 'patch', 'post'], '/addresses/{id}', [UserAddressController::class, 'update']);
            // حذف عنوان شحن محدد
            Route::delete('/addresses/{id}', [UserAddressController::class, 'destroy']);
            // تعيين عنوان كعنوان شحن رئيسي
            Route::post('/addresses/{id}/set-main', [UserAddressController::class, 'setMain']);
        });
    });
});