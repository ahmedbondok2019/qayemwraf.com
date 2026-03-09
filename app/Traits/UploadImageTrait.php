<?php

namespace App\Traits;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

trait UploadImageTrait
{
    /**
     * Upload an image, convert it to WebP, and save it to the specified folder.
     *
     * @param \Illuminate\Http\UploadedFile $file The image file to upload.
     * @param string $folderName The folder name within public/uploads.
     * @param int|null $width The width to resize to (optional).
     * @param int|null $height The height to resize to (optional).
     * @return string The filename of the uploaded image.
     */
    public function uploadImage($file, $folderName, $width = null, $height = null)
    {
        // Create the directory if it doesn't exist
        $path = public_path('uploads/' . $folderName);
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true, true);
        }

        // Generate a unique filename
        $filename = uniqid() . '.webp';

        // Initialize Intervention Image
        $image = Image::make($file);

        // Resize if width and height are provided
        if ($width && $height) {
            $image->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        // Encode as WebP and save
        $image->encode('webp', 80)->save($path . '/' . $filename);

        return $filename;
    }
}
