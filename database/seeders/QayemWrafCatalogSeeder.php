<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Product;

class QayemWrafCatalogSeeder extends Seeder
{
    /**
     * Clear all existing dummy data and seed the Qayem W Raf catalog safely.
     * Guards against resetting if the catalog already exists in production.
     *
     * @return void
     */
    public function run()
    {
        // Safety guard: If the Qayem W Raf catalog is already present, do not wipe production data or admin edits.
        if (Product::where('sku', 'SH-STD-30K')->exists()) {
            $this->command->info('✅ تم العثور على كتالوج (قايم ورف) مسبقاً. تم تخطي السيدر تلقائياً للحفاظ على تعديلات الأسعار والصور والطلبات الحية في البرودكشن.');
            return;
        }

        $this->command->info('Clearing old catalog, products, categories, orders, brands, and options...');

        // Temporarily disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $tablesToClear = [
            'order_details',
            'order_options',
            'orders',
            'order_services',
            'order_service_items',
            'order_returns',
            'cart_options',
            'carts',
            'wishlists',
            'compares',
            'ratings',
            'reviews',
            'review_translations',
            'flash_sale_products',
            'flash_sale_translations',
            'flash_sales',
            'offer_translations',
            'offers',
            'product_categories',
            'product_related',
            'product_options',
            'product_option_values',
            'product_option_items',
            'product_images',
            'product_translations',
            'product_stock_updates',
            'product_offers',
            'product_shippings',
            'products',
            'category_translations',
            'categories',
            'product_brand_translations',
            'product_brands',
            'brand_translations',
            'brands',
            'option_value_translations',
            'option_values',
            'option_translations',
            'options',
        ];

        foreach ($tablesToClear as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->truncate();
                $this->command->line("Truncated: $table");
            }
        }

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('Seeding fresh Qayem W Raf catalog...');

        $this->call([
            CategorySeeder::class,
            ProductBrandSeeder::class,
            OptionSeeder::class,
            ProductSeeder::class,
            OfferSeeder::class,
            FlashSaleSeeder::class,
            RatingsSeeder::class,
            OrderSeeder::class,
        ]);

        $this->command->info('✅ Qayem W Raf catalog seeded successfully!');
    }
}
