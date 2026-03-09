<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\GroupPermission;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing permissions to avoid duplicates during re-seed
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Permission::truncate();
        GroupPermission::truncate();
        Group::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Group::create([
            'id' => 1,
            'name' => 'Super Admin',
        ]);

        $arrayPermission = [
            // Format: ['sidebar_key' => ['base_permission_name', 'group_name/header']]
            
            // Users Management Group
            ['roles' => ['roles', 'UsersManagement']],
            ['admins' => ['admins', 'UsersManagement']],
            ['vendors' => ['vendors', 'UsersManagement']],
            ['customers' => ['customers', 'UsersManagement']],

            ['pages' => ['pages', 'General']],
            ['blog_categories' => ['blog_categories', 'General']],
            ['blogs' => ['blogs', 'General']],
            ['contacts' => ['contacts', 'General']],
            
            ['countries' => ['countries', 'Location']],
            ['governorates' => ['governorates', 'Location']],
            ['cities' => ['cities', 'Location']],
            
            ['categories' => ['categories', 'Products']],
            ['products' => ['products', 'Products']],
            ['product_brands' => ['product_brands', 'Products']],
            ['options' => ['options', 'Products']],
            
            ['offers' => ['offers', 'Offers']],
            ['coupons' => ['coupons', 'Offers']],
            ['flash_sales' => ['flash_sales', 'Offers']],
            
            ['orders' => ['orders', 'Orders']],
            ['gifts' => ['gifts', 'Orders']],
            ['order_services' => ['order_services', 'Orders']],
            
            ['advertisements' => ['advertisements', 'Marketing']],
            ['sliders' => ['sliders', 'Marketing']],
            
            ['shipping_rules' => ['shipping_rules', 'Shipping']],
            
            ['currencies' => ['currencies', 'Settings']],
        ];

        foreach ($arrayPermission as $Permission) {
            foreach ($Permission as $key => $Per) {

                $ist = Permission::create([
                    'name' => $Per[0].'_read',
                    'parent_permission' => $key,
                    'group_permission' => $Per[1],
                ]);

                $snd = Permission::create([
                    'name' => $Per[0].'_create',
                    'parent_permission' => $key,
                    'group_permission' => $Per[1],
                ]);
                $thrd = Permission::create([
                    'name' => $Per[0].'_update',
                    'parent_permission' => $key,
                    'group_permission' => $Per[1],
                ]);
                $forth = Permission::create([
                    'name' => $Per[0].'_delete',
                    'parent_permission' => $key,
                    'group_permission' => $Per[1],
                ]);

                GroupPermission::create(['permission_id' => $ist->id, 'group_id' => 1]);
                GroupPermission::create(['permission_id' => $snd->id, 'group_id' => 1]);
                GroupPermission::create(['permission_id' => $thrd->id, 'group_id' => 1]);
                GroupPermission::create(['permission_id' => $forth->id, 'group_id' => 1]);
            }
        }

        $arrayPermissionOne = [
            ['settings' => ['settings', 'Settings']],
            ['languages' => ['languages', 'Settings']],
            ['payment_methods' => ['payment_methods', 'Settings']],
        ];

        foreach ($arrayPermissionOne as $Permission) {
            foreach ($Permission as $key => $Per) {
                $ID = Permission::create([
                    'name' => $Per[0].'_update',
                    'parent_permission' => $key,
                    'group_permission' => $Per[1],
                ]);

                GroupPermission::create([
                    'permission_id' => $ID->id,
                    'group_id' => 1,
                ]);
            }
        }
    }
}
