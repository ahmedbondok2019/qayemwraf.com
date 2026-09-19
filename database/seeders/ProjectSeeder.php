<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ini_set('memory_limit', '2048M');

        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ProjectTranslation::truncate();
        Project::truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $sourceDir = 'D:\\قائم ورف';
        $storageDir = storage_path('app/public/uploads/projects');

        if (! File::exists($storageDir)) {
            File::makeDirectory($storageDir, 0755, true, true);
        }

        if (! File::isDirectory($sourceDir)) {
            $this->command->error("Source directory {$sourceDir} does not exist!");

            return;
        }

        $watermarkPath = public_path('_fixed/watermark.png');
        $hasWatermark = File::exists($watermarkPath);

        $titlesAr = [
            'تجهيز مستودعات ومخازن كبرى بالرفوف المعدنية',
            'تركيب وحدات تخزين وأرفف للأحمال الثقيلة',
            'تجهيز مساحات تخزين لوجستية وأنظمة رص',
            'تركيب استاندات وأرفف عرض للمحلات والشركات',
            'مشروع تجهيز عنابر تخزين بمقاسات مخصصة',
            'تأسيس أنظمة أرفف ذكية للمصانع والمستودعات',
            'تنفيذ وتجهيز أرفف ومكاتب معدنية متكاملة',
            'مشروع وحدات تخزين أرشيفية ومخزنية متطورة',
        ];

        $titlesEn = [
            'Large-Scale Warehouse Shelving & Storage Setup',
            'Heavy-Duty Industrial Rack & Pallet Systems',
            'Logistics Warehouse Optimization & Racking',
            'Commercial Display Stands & Retail Shelving',
            'Custom Heavy Storage Bay Construction',
            'Smart Industrial Racking for Factories',
            'Integrated Metal Office & Storage Units',
            'Advanced Archive & High-Density Storage Racks',
        ];

        $descAr = 'تم تنفيذ المشروع وتوريد وتركيب الرفوف المعدنية بأعلى معايير الجودة والمتانة من مصنع قائم ورف، لتحقيق أقصى استغلال للمساحات التخزينية وسهولة التحميل والتفريغ.';
        $descEn = 'Successfully executed and installed high-grade industrial metal racking systems by Qayem & Raf, engineered for maximum load capacity, safety, and optimal warehouse space utilization.';

        $files = File::files($sourceDir);
        $count = 0;

        foreach ($files as $index => $file) {
            $extension = strtolower($file->getExtension());

            // Handle image files
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
                $filename = 'project_'.uniqid().'_'.$index.'.webp';
                $destPath = $storageDir.DIRECTORY_SEPARATOR.$filename;

                try {
                    $img = Image::make($file->getRealPath());

                    // Resize if larger than 1600px width
                    if ($img->width() > 1600) {
                        $img->resize(1600, null, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });
                    }

                    // Apply Watermark
                    if ($hasWatermark) {
                        $wm = Image::make($watermarkPath);
                        $targetWidth = (int) ($img->width() * 0.55);
                        $targetHeight = (int) ($img->height() * 0.65);

                        $wm->resize($targetWidth, $targetHeight, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });

                        $wm->opacity(35);
                        $img->insert($wm, 'center');
                    }

                    // Save as WebP
                    $img->encode('webp', 85)->save($destPath);
                    $img->destroy();
                    unset($img);
                    gc_collect_cycles();

                    // Create Project Record
                    $titleIndex = $count % count($titlesAr);
                    $projectNumber = $count + 1;

                    $project = Project::create([
                        'image' => 'storage/uploads/projects/'.$filename,
                        'sort_order' => $count,
                        'is_active' => true,
                    ]);

                    ProjectTranslation::create([
                        'project_id' => $project->id,
                        'locale' => 'ar',
                        'title' => $titlesAr[$titleIndex]." (#{$projectNumber})",
                        'description' => $descAr,
                    ]);

                    ProjectTranslation::create([
                        'project_id' => $project->id,
                        'locale' => 'en',
                        'title' => $titlesEn[$titleIndex]." (#{$projectNumber})",
                        'description' => $descEn,
                    ]);

                    $count++;
                } catch (\Exception $e) {
                    // Log or continue
                    continue;
                }
            }
        }

        $this->command->info("Successfully seeded {$count} projects with watermarked images!");
    }
}
