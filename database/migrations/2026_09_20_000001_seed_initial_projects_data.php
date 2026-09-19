<?php

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
        // 1. Add/update Static Translations for Projects
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

        // 2. Force seed initial projects from bundled images
        if (Schema::hasTable('projects')) {
            try {
                // If projects table is empty, run ProjectSeeder
                if (Project::count() < 60) {
                    $seeder = new ProjectSeeder();
                    $seeder->run();
                }
            } catch (\Throwable $e) {
                // Log or continue
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
