<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StaticTranslation;

class SidebarTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $translations = [
            // Home
            ['key' => 'dashboard.Home', 'ar' => 'الرئيسية', 'en' => 'Home'],
            
            // Users Management Group
            ['key' => 'dashboard.UsersManagement', 'ar' => 'إدارة المستخدمين', 'en' => 'Users Management'],
            ['key' => 'dashboard.roles', 'ar' => 'الصلاحيات', 'en' => 'Roles'],
            ['key' => 'dashboard.admins', 'ar' => 'موظفي النظام', 'en' => 'Admins'],
            ['key' => 'dashboard.vendors', 'ar' => 'التجار', 'en' => 'Vendors'],
            ['key' => 'dashboard.customers', 'ar' => 'العملاء', 'en' => 'Customers'],

            // General Group
            ['key' => 'dashboard.General', 'ar' => 'عام', 'en' => 'General'],
            ['key' => 'dashboard.pages', 'ar' => 'الصفحات', 'en' => 'Pages'],
            ['key' => 'dashboard.blog_categories', 'ar' => 'أقسام المقالات', 'en' => 'Blog Categories'],
            ['key' => 'dashboard.blogs', 'ar' => 'المدونة', 'en' => 'Blogs'],
            ['key' => 'dashboard.contacts', 'ar' => 'وسائل التواصل', 'en' => 'Contacts'],

            // Location Group
            ['key' => 'dashboard.Location', 'ar' => 'المواقع والدول', 'en' => 'Location'],
            ['key' => 'dashboard.countries', 'ar' => 'الدول', 'en' => 'Countries'],
            ['key' => 'dashboard.governorates', 'ar' => 'المحافظات', 'en' => 'Governorates'],
            ['key' => 'dashboard.cities', 'ar' => 'المدن', 'en' => 'Cities'],

            // Products Group
            ['key' => 'dashboard.Products', 'ar' => 'المنتجات والماركات', 'en' => 'Products'],
            ['key' => 'dashboard.categories', 'ar' => 'أقسام المنتجات', 'en' => 'Categories'],
            ['key' => 'dashboard.products', 'ar' => 'المنتجات', 'en' => 'Products'],
            ['key' => 'dashboard.product_brands', 'ar' => 'الماركات', 'en' => 'Brands'],
            ['key' => 'dashboard.options', 'ar' => 'خيارات المنتج', 'en' => 'Options'],

            // Offers Group
            ['key' => 'dashboard.Offers', 'ar' => 'العروض والخصومات', 'en' => 'Offers'],
            ['key' => 'dashboard.offers', 'ar' => 'العروض', 'en' => 'Offers'],
            ['key' => 'dashboard.coupons', 'ar' => 'كوبونات الخصم', 'en' => 'Coupons'],
            ['key' => 'dashboard.flash_sales', 'ar' => 'تخفيضات', 'en' => 'Flash Sales'],

            // Orders Group
            ['key' => 'dashboard.Orders', 'ar' => 'الطلبات والخدمات', 'en' => 'Orders'],
            ['key' => 'dashboard.orders', 'ar' => 'الطلبات', 'en' => 'Orders'],
            ['key' => 'dashboard.gifts', 'ar' => 'هدايا', 'en' => 'Gifts'],
            ['key' => 'dashboard.order_services', 'ar' => 'خدمات الطلبات', 'en' => 'Order Services'],

            // Marketing Group
            ['key' => 'dashboard.Marketing', 'ar' => 'التسويق والإعلانات', 'en' => 'Marketing'],
            ['key' => 'dashboard.advertisements', 'ar' => 'الإعلانات', 'en' => 'Advertisements'],
            ['key' => 'dashboard.sliders', 'ar' => 'البانرات', 'en' => 'Sliders'],

            // Shipping Group
            ['key' => 'dashboard.Shipping', 'ar' => 'الشحن والتوصيل', 'en' => 'Shipping'],
            ['key' => 'dashboard.shipping_rules', 'ar' => 'أقسام الشحن', 'en' => 'Shipping Rules'],

            // Settings Group
            ['key' => 'dashboard.Settings', 'ar' => 'الإعدادات واللغات', 'en' => 'Settings'],
            ['key' => 'dashboard.currencies', 'ar' => 'العملات', 'en' => 'Currencies'],
            ['key' => 'dashboard.settings', 'ar' => 'الإعدادات', 'en' => 'Settings'],
            ['key' => 'dashboard.payment_methods', 'ar' => 'طرق الدفع', 'en' => 'Payment Methods'],
            ['key' => 'dashboard.static_translations', 'ar' => 'الترجمات الثابتة', 'en' => 'Static Translations'],
            ['key' => 'dashboard.languages', 'ar' => 'اللغات', 'en' => 'Languages'],
            
            // Other
            ['key' => 'dashboard.Stock Update', 'ar' => 'تحديث المخزون', 'en' => 'Stock Update'],
        ];

        foreach ($translations as $trans) {
            StaticTranslation::updateOrCreate(
                ['key' => $trans['key']],
                [
                    'translations' => [
                        'ar' => $trans['ar'],
                        'en' => $trans['en']
                    ]
                ]
            );
        }
    }
}
