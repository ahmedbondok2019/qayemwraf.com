<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShippingRule;
use App\Models\ShippingRuleTranslation;
use App\Models\Country;
use App\Models\Governorate;
use Illuminate\Support\Facades\DB;

class ShippingRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ensure we have a country
        $country = Country::first();
        if (!$country) {
            $this->command->info('No country found, skipping ShippingRuleSeeder.');
            return;
        }

        // Create a Standard Shipping Rule
        $rule = ShippingRule::create([
            'country_id' => $country->id,
            'is_active' => true,
        ]);

        // Translations
        ShippingRuleTranslation::create([
            'shipping_rule_id' => $rule->id,
            'locale' => 'en',
            'name' => 'Standard Delivery',
        ]);
        ShippingRuleTranslation::create([
            'shipping_rule_id' => $rule->id,
            'locale' => 'ar',
            'name' => 'شحن عادي',
        ]);

        // Assign Rates for Governorates
        $governorates = Governorate::where('country_id', $country->id)->get();

        foreach ($governorates as $gov) {
            $rate = 50.00; // Base rate

            // Adjust rate based on simple logic or keywords if available
            // Note: This relies on translations usually, but checking model direct attributes if available.
            // Assuming governorates might have names in translations, but for seeding generic logic:
            
            // Just for variation:
            if ($gov->id <= 3) { 
                $rate = 30.00; // Cairo/Giza/Alex usually early IDs
            } elseif ($gov->id > 20) {
                $rate = 80.00; // Upper Egypt/Remote
            } else {
                $rate = 50.00; // Delta/Canal
            }

            DB::table('shipping_rule_governorates')->insert([
                'shipping_rule_id' => $rule->id,
                'governorate_id' => $gov->id,
                'rate' => $rate,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
