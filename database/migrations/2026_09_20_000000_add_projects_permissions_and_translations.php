<?php

use App\Models\Group;
use App\Models\GroupPermission;
use App\Models\Permission;
use App\Models\Project;
use App\Models\StaticTranslation;
use Database\Seeders\ProjectSeeder;
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

            $perm->update([
                'parent_permission' => 'projects',
                'group_permission' => 'Projects',
                'status' => 1,
            ]);

            $permissionIds[] = $perm->id;
        }

        // 2. Attach permissions to Super Admin group (ID 1) and all other existing groups
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

        // 3. Add Static Translations for Projects & Table labels
        if (Schema::hasTable('static_translations')) {
            $translations = [
                'dashboard.Projects' => ['ar' => 'المشروعات', 'en' => 'Projects'],
                'dashboard.projects' => ['ar' => 'المشروعات', 'en' => 'Projects'],
                'dashboard.project' => ['ar' => 'مشروع', 'en' => 'project'],
                'dashboard.Sort' => ['ar' => 'الترتيب', 'en' => 'Sort'],
                'dashboard.SORT' => ['ar' => 'الترتيب', 'en' => 'Sort'],
                'dashboard.No data available' => ['ar' => 'لا توجد بيانات متاحة', 'en' => 'No data available'],
                'dashboard.Image' => ['ar' => 'الصورة', 'en' => 'Image'],
                'dashboard.Title' => ['ar' => 'العنوان', 'en' => 'Title'],
                'dashboard.Status' => ['ar' => 'الحالة', 'en' => 'Status'],
                'dashboard.Created At' => ['ar' => 'تاريخ الإضافة', 'en' => 'Created At'],
                'dashboard.Actions' => ['ar' => 'الإجراءات', 'en' => 'Actions'],
                'dashboard.Add New' => ['ar' => 'إضافة جديد', 'en' => 'Add New'],
                'dashboard.Are you sure?' => ['ar' => 'هل أنت متأكد من الحذف؟', 'en' => 'Are you sure you want to delete?'],
            ];

            foreach ($translations as $key => $values) {
                StaticTranslation::updateOrCreate(
                    ['key' => $key],
                    ['translations' => $values]
                );
            }
        }

        // 4. Auto-seed projects if none exist on production
        if (Schema::hasTable('projects') && Project::count() < 60) {
            try {
                (new ProjectSeeder())->run();
            } catch (\Throwable $e) {
                // Ignore or continue
            }
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
