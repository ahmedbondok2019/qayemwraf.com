<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;
use App\Models\PaymentMethodTranslation;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $methods = [
            [
                'keyword' => 'cash',
                'is_active' => true,
                'sort_order' => 1,
                'tax' => 0,
                'discount' => 100,
                'discount_type' => 'percentage',
                'cod_limit' => 10000,
                'translations' => [
                    ['locale' => 'en', 'name' => 'Cash on Delivery', 'description' => 'Pay when you receive the order.'],
                    ['locale' => 'ar', 'name' => 'الدفع عند الاستلام', 'description' => 'ادفع عند استلام الطلب.'],
                ],
            ],
            [
                'keyword' => 'credit_card',
                'is_active' => true,
                'sort_order' => 2,
                'tax' => 2.5,
                'discount' => 100,
                'discount_type' => 'percentage',
                'cod_limit' => 10000,
                'translations' => [
                    ['locale' => 'en', 'name' => 'Credit Card', 'description' => 'Pay securely with your credit card.'],
                    ['locale' => 'ar', 'name' => 'بطاقة ائتمان', 'description' => 'ادفع بأمان باستخدام بطاقتك الائتمانية.'],
                ],
            ],
            [
                'keyword' => 'valu',
                'is_active' => true,
                'sort_order' => 3,
                'tax' => 1.5,
                'discount' => 70,
                'discount_type' => 'percentage',
                'cod_limit' => 10000,
                'translations' => [
                    ['locale' => 'en', 'name' => 'Valu', 'description' => 'Buy now, pay later with Valu.'],
                    ['locale' => 'ar', 'name' => 'فاليو', 'description' => 'اشترِ الآن وادفع لاحقاً مع فاليو.'],
                ],
            ],
            [
                'keyword' => 'vodafone_cash',
                'is_active' => true,
                'sort_order' => 4,
                'tax' => 0,
                'discount' => 100,
                'discount_type' => 'fixed',
                'cod_limit' => 10000,
                'translations' => [
                    ['locale' => 'en', 'name' => 'Vodafone Cash', 'description' => 'Pay via Vodafone Cash wallet.'],
                    ['locale' => 'ar', 'name' => 'فودافون كاش', 'description' => 'ادفع عن طريق محفظة فودافون كاش.'],
                ],
            ],
             [
                'keyword' => 'instapay',
                'is_active' => true,
                'sort_order' => 5,
                'tax' => 0,
                'discount' => 50,
                'discount_type' => 'percentage',
                'cod_limit' => 10000,
                'translations' => [
                    ['locale' => 'en', 'name' => 'InstaPay', 'description' => 'Pay via InstaPay.'],
                    ['locale' => 'ar', 'name' => 'انستا باي', 'description' => 'ادفع عن طريق انستا باي.'],
                ],
            ],
        ];

        foreach ($methods as $methodData) {
            $translations = $methodData['translations'];
            unset($methodData['translations']);

            $method = PaymentMethod::create($methodData);

            foreach ($translations as $translation) {
                PaymentMethodTranslation::create([
                    'payment_method_id' => $method->id,
                    'locale' => $translation['locale'],
                    'name' => $translation['name'],
                    'description' => $translation['description'],
                ]);
            }
        }
    }
}
