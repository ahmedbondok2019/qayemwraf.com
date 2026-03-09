<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\GroupPermission;

class StaticTranslationPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Define the permission structure
        $permissions = [
            'static_translations' => ['static_translations', 'Settings'],
        ];

        foreach ($permissions as $key => $details) {
            $baseName = $details[0];
            $groupName = $details[1];

            // Create permissions
            $read = Permission::firstOrCreate([
                'name' => $baseName . '_read',
                'parent_permission' => $key,
                'group_permission' => $groupName,
            ]);

            $create = Permission::firstOrCreate([
                'name' => $baseName . '_create',
                'parent_permission' => $key,
                'group_permission' => $groupName,
            ]);

            $update = Permission::firstOrCreate([
                'name' => $baseName . '_update',
                'parent_permission' => $key,
                'group_permission' => $groupName,
            ]);

            $delete = Permission::firstOrCreate([
                'name' => $baseName . '_delete',
                'parent_permission' => $key,
                'group_permission' => $groupName,
            ]);

            // Assign to Super Admin (Group ID 1)
            $adminGroupId = 1;

            GroupPermission::firstOrCreate(['permission_id' => $read->id, 'group_id' => $adminGroupId]);
            GroupPermission::firstOrCreate(['permission_id' => $create->id, 'group_id' => $adminGroupId]);
            GroupPermission::firstOrCreate(['permission_id' => $update->id, 'group_id' => $adminGroupId]);
            GroupPermission::firstOrCreate(['permission_id' => $delete->id, 'group_id' => $adminGroupId]);
        }
    }
}
