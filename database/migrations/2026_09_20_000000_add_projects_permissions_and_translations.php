<?php

use App\Models\Group;
use App\Models\GroupPermission;
use App\Models\Permission;
use App\Models\StaticTranslation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Create or ensure Projects permissions exist
        $permissions = [
            'projects_read',
            'projects_create',
            'projects_update',
            'projects_delete',
        ];

        $permissionIds = [];

        foreach ($permissions as $permName) {
            $perm = Permission::firstOrCreate(
                ['name' => $permName],
                [
                    'parent_permission' => 'projects',
                    'group_permission' => 'Projects',
                    'status' => 1,
                ]
            );

            // Ensure parent and group are set properly
            $perm->update([
                'parent_permission' => 'projects',
                'group_permission' => 'Projects',
                'status' => 1,
            ]);

            $permissionIds[] = $perm->id;
        }

        // 2. Attach permissions to Super Admin group (ID 1) and all other existing groups if needed
        $groups = Group::all();
        if ($groups->isEmpty()) {
            $group = Group::firstOrCreate(['id' => 1], ['name' => 'Super Admin']);
            $groups = collect([$group]);
        }

        foreach ($groups as $group) {
            foreach ($permissionIds as $permId) {
                GroupPermission::firstOrCreate([
                    'group_id' => $group->id,
                    'permission_id' => $permId,
                ]);
            }
        }

        // 3. Add Static Translations for Projects
        if (Schema::hasTable('static_translations')) {
            StaticTranslation::updateOrCreate(
                ['key' => 'dashboard.Projects'],
                ['translations' => ['ar' => 'المشروعات', 'en' => 'Projects']]
            );

            StaticTranslation::updateOrCreate(
                ['key' => 'dashboard.projects'],
                ['translations' => ['ar' => 'المشروعات', 'en' => 'Projects']]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $permissions = Permission::where('parent_permission', 'projects')->get();
        foreach ($permissions as $perm) {
            GroupPermission::where('permission_id', $perm->id)->delete();
            $perm->delete();
        }
    }
};
