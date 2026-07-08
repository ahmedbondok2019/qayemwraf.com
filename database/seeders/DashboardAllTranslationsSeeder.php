<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StaticTranslation;

class DashboardAllTranslationsSeeder extends Seeder
{
    // php artisan db:seed --class=DashboardAllTranslationsSeeder
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locales = ['ar', 'en'];
        $namespaces = ['dashboard', 'website', 'frontend', 'Replied', 'validation', 'pagination'];
        $allKeys = [];

        foreach ($locales as $locale) {
            foreach ($namespaces as $ns) {
                $path = base_path("resources/lang/{$locale}/{$ns}.php");
                if (file_exists($path)) {
                    $translations = include $path;
                    if (is_array($translations)) {
                        foreach ($translations as $key => $value) {
                            $fullKey = "{$ns}.{$key}";
                            if (!isset($allKeys[$fullKey])) {
                                $allKeys[$fullKey] = [];
                            }
                            $allKeys[$fullKey][$locale] = $value;
                        }
                    }
                }
            }
        }

        // Add manual hardcoded keys
        $manualKeys = [
            'dashboard.Yes' => ['ar' => 'نعم', 'en' => 'Yes'],
            'dashboard.No' => ['ar' => 'لا', 'en' => 'No'],
            'dashboard.Invoice' => ['ar' => 'فاتورة', 'en' => 'Invoice'],
            'dashboard.Drop files here or click to upload' => ['ar' => 'قم بإسقاط الملفات هنا أو انقر للتحميل.', 'en' => 'Drop files here or click to upload'],
            'dashboard.Total Sent' => ['ar' => 'إجمالى المرسلة', 'en' => 'Total Sent'],
            // Frontend keys
            'website.Search results for:' => ['ar' => 'نتائج البحث عن: ', 'en' => 'Search results for: '],
            'website.Book Editions' => ['ar' => 'إصدارات المنتجات', 'en' => 'Book Editions'],
            'website.Books' => ['ar' => 'المنتجات', 'en' => 'Books'],
            'website.Category' => ['ar' => 'القسم', 'en' => 'Category'],
            'website.Filter Products' => ['ar' => 'تصفية المنتجات', 'en' => 'Filter Products'],
            'website.Search by book name' => ['ar' => 'البحث باسم المنتج', 'en' => 'Search by book name'],
            'website.Type book name...' => ['ar' => 'اكتب اسم المنتج...', 'en' => 'Type book name...'],
            'website.Price' => ['ar' => 'السعر', 'en' => 'Price'],
            'website.From' => ['ar' => 'من', 'en' => 'From'],
            'website.To' => ['ar' => 'إلى', 'en' => 'To'],
            'website.Brands' => ['ar' => 'العلامات التجارية', 'en' => 'Brands'],
            'website.Unknown' => ['ar' => 'غير معروف', 'en' => 'Unknown'],
            'website.Current Flash Sales' => ['ar' => 'عروض فلاش الحالية', 'en' => 'Current Flash Sales'],
            'website.All' => ['ar' => 'الكل', 'en' => 'All'],
            'website.Ends:' => ['ar' => 'ينتهي: ', 'en' => 'Ends: '],
            'website.Best Seller' => ['ar' => 'الأكثر مبيعاً', 'en' => 'Best Seller'],
            'website.Apply Filter' => ['ar' => 'تطبيق التصفية', 'en' => 'Apply Filter'],
            'website.Reset' => ['ar' => 'إعادة تعيين', 'en' => 'Reset'],
            'website.View' => ['ar' => 'عرض', 'en' => 'View'],
            'website.out of' => ['ar' => 'من أصل', 'en' => 'out of'],
            'website.book' => ['ar' => 'كتاب', 'en' => 'book'],
            'website.New arrivals' => ['ar' => 'وصل حديثاً', 'en' => 'New arrivals'],
            'website.Price: Low to High' => ['ar' => 'السعر: من الأقل للأعلى', 'en' => 'Price: Low to High'],
            'website.Price: High to Low' => ['ar' => 'السعر: من الأعلى للأقل', 'en' => 'Price: High to Low'],
            'website.In Cart' => ['ar' => 'في السلة', 'en' => 'In Cart'],
            'website.In Wishlist' => ['ar' => 'في المفضلة', 'en' => 'In Wishlist'],
            'website.Untitled book' => ['ar' => 'كتاب غير معنون', 'en' => 'Untitled book'],
            'website.Unknown author' => ['ar' => 'مؤلف غير معروف', 'en' => 'Unknown author'],
            'website.Remove from Wishlist' => ['ar' => 'حذف من المفضلة', 'en' => 'Remove from Wishlist'],
            'website.Wishlist is empty' => ['ar' => 'قائمة المفضلة فارغة', 'en' => 'Wishlist is empty'],
            'website.empty_wishlist_msg' => ['ar' => 'لم تقم بإضافة أي منتجات لمفضلتك بعد. ابدأ باكتشاف منتجاتنا الرائعة!', 'en' => 'You haven\'t added any products to your wishlist yet. Start discovering our great products!'],
            'website.No matching results' => ['ar' => 'لا توجد نتائج مطابقة', 'en' => 'No matching results'],
            'website.Untitled product' => ['ar' => 'منتج غير معنون', 'en' => 'Untitled product'],
            'website.Brand:' => ['ar' => 'الماركة: ', 'en' => 'Brand: '],
            'website.Flash Sale' => ['ar' => 'عرض فلاش', 'en' => 'Flash Sale'],
            'website.Added to Cart' => ['ar' => 'تم الإضافة للسلة', 'en' => 'Added to Cart'],
            'website.View Cart' => ['ar' => 'عرض السلة', 'en' => 'View Cart'],
            'website.Add to Cart' => ['ar' => 'أضف للسلة', 'en' => 'Add to Cart'],
            'website.Discover Products' => ['ar' => 'اكتشف المنتجات', 'en' => 'Discover Products'],
            'website.Search for books, authors...' => ['ar' => 'ابحث عن المنتجات، المؤلفين...', 'en' => 'Search for books, authors...'],
            'website.Translation Settings' => ['ar' => 'اعدادات الترجمة', 'en' => 'Translation Settings'],
            'website.Choose Country' => ['ar' => 'اختر الدولة', 'en' => 'Choose Country'],
            'website.Egypt' => ['ar' => 'مصر', 'en' => 'Egypt'],
            'website.Arabic' => ['ar' => 'العربية', 'en' => 'Arabic'],
            'website.Kuwait' => ['ar' => 'الكويت', 'en' => 'Kuwait'],
            'website.Mauritania' => ['ar' => 'موريتانيا', 'en' => 'Mauritania'],
            'website.Saudi Arabia' => ['ar' => 'السعودية', 'en' => 'Saudi Arabia'],
            'website.Qatar' => ['ar' => 'قطر', 'en' => 'Qatar'],
            'website.Cancel' => ['ar' => 'إلغاء', 'en' => 'Cancel'],
            'website.Confirm' => ['ar' => 'تأكيد', 'en' => 'Confirm'],
            'website.Add Delivery Address' => ['ar' => 'اضف عنوان التوصيل', 'en' => 'Add Delivery Address'],
            'website.Address *' => ['ar' => 'العنوان *', 'en' => 'Address *'],
            'website.Phone *' => ['ar' => 'التليفون *', 'en' => 'Phone *'],
            'website.Name *' => ['ar' => 'الاسم *', 'en' => 'Name *'],
            'website.Choose' => ['ar' => 'اختر', 'en' => 'Choose'],
            'website.Error' => ['ar' => 'خطأ', 'en' => 'Error'],
            'website.Something went wrong' => ['ar' => 'حدث خطأ ما', 'en' => 'Something went wrong'],
            'website.Something went wrong, please try again' => ['ar' => 'حدث خطأ ما، يرجى المحاول مرة أخرى', 'en' => 'Something went wrong, please try again'],
        ];

        foreach ($manualKeys as $key => $trans) {
            $allKeys[$key] = $trans;
        }

        foreach ($allKeys as $key => $translations) {
            foreach ($locales as $locale) {
                if (!isset($translations[$locale])) {
                    $translations[$locale] = '';
                }
            }

            StaticTranslation::updateOrCreate(
                ['key' => $key],
                ['translations' => $translations]
            );
        }
    }
}
