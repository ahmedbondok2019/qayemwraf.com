<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

trait UploadImageTrait
{
    /**
     * Upload an image, convert it to WebP, apply optional watermark, and save it.
     *
     * @param  UploadedFile|string  $file  The image file to upload.
     * @param  string  $folderName  The folder name within public/uploads.
     * @param  int|null  $width  The width to resize to (optional).
     * @param  int|null  $height  The height to resize to (optional).
     * @param  bool  $withWatermark  Whether to stamp the watermark.
     * @return string The storage relative path of the uploaded image.
     */
    public function uploadImage($file, $folderName, $width = null, $height = null, $withWatermark = false)
    {
        // Create the directory if it doesn't exist
        $path = 'uploads'.DIRECTORY_SEPARATOR.$folderName;
        $fullStoragePath = storage_path('app/public'.DIRECTORY_SEPARATOR.$path);
        if (! File::exists($fullStoragePath)) {
            File::makeDirectory($fullStoragePath, 0755, true, true);
        }

        // Generate a unique filename
        $filename = uniqid().'.webp';

        // Initialize Intervention Image
        $image = Image::make($file);

        // Resize if width and height are provided
        if ($width && $height) {
            $image->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        // Apply watermark if requested
        if ($withWatermark) {
            $this->applyWatermark($image);
        }

        // Encode as WebP and save
        $image->encode('webp', 85)->save($fullStoragePath.DIRECTORY_SEPARATOR.$filename);

        return 'storage/uploads/'.$folderName.'/'.$filename;
    }

    /**
     * Apply watermark to Intervention Image instance
     *
     * @param  \Intervention\Image\Image  $image
     * @param  int  $opacity
     * @return void
     */
    public function applyWatermark(&$image, $opacity = 35)
    {
        $watermarkPath = public_path('_fixed/watermark.png');
        if (! File::exists($watermarkPath)) {
            $setting = \App\Models\Setting::first();
            if ($setting && $setting->logo && File::exists(public_path($setting->logo))) {
                $watermarkPath = public_path($setting->logo);
            }
        }

        if (File::exists($watermarkPath)) {
            try {
                $watermark = Image::make($watermarkPath);

                $imgWidth = $image->width();
                $imgHeight = $image->height();

                $targetWidth = (int) ($imgWidth * 0.45);
                $targetHeight = (int) ($imgHeight * 0.45);

                $watermark->resize($targetWidth, $targetHeight, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $watermark->opacity($opacity);

                $image->insert($watermark, 'center');
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning('Watermark failed: '.$e->getMessage());
            }
        }
    }
}
