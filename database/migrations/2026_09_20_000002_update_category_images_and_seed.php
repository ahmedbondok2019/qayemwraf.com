<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\File;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $bundledDir = base_path('database/seeders/images/categories');
        $storageDir = storage_path('app/public/uploads/categories');
        $publicWebDir = public_path('website/images/category');

        if (! File::exists($storageDir)) {
            File::makeDirectory($storageDir, 0755, true, true);
        }

        if (! File::exists($publicWebDir)) {
            File::makeDirectory($publicWebDir, 0755, true, true);
        }

        if (File::isDirectory($bundledDir)) {
            $files = File::files($bundledDir);
            foreach ($files as $file) {
                File::copy($file->getRealPath(), $storageDir.DIRECTORY_SEPARATOR.$file->getFilename());
                File::copy($file->getRealPath(), $publicWebDir.DIRECTORY_SEPARATOR.$file->getFilename());
            }
        }

        // Update categories in database
        $categories = Category::orderBy('id', 'asc')->get();
        foreach ($categories as $index => $category) {
            $imgNum = ($index % 10) + 1;
            $category->update([
                'image' => 'storage/uploads/categories/category_'.$imgNum.'.webp',
            ]);
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
