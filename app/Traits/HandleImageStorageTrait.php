<?php

namespace App\Traits;

trait HandleImageStorageTrait
{
    /**
     * Resolve the storage vs legacy path for images/files.
     */
    protected function resolvePath($value, $attribute = 'image')
    {
        if (!$value) {
            return null;
        }

        // If it's already a full URL or starts with storage/, return as is
        if (str_starts_with($value, 'storage/') || str_starts_with($value, 'http')) {
            return $value;
        }

        // Legacy path mapping based on Model class
        $prefix = '';
        $className = class_basename($this);

        switch ($className) {
            case 'Product':
            case 'ProductImage':
                $prefix = 'website/images/products/';
                break;
            case 'Category':
                $prefix = 'website/images/category/';
                break;
            case 'SliderTranslation':
                $prefix = 'website/images/sliders/';
                break;
            case 'BrandTranslation':
                $prefix = 'website/images/brands/';
                break;
            case 'Vendor':
            case 'VendorImage':
                $prefix = 'website/images/users/';
                break;
            case 'User':
                $prefix = 'uploads/users/';
                break;
            case 'BlogTranslation':
                $prefix = 'website/images/blog/';
                break;
            case 'Review':
                $prefix = 'uploads/reviews/';
                break;
            case 'TeamWork':
            case 'TeamWorkImage':
            case 'TeamWorkTranslation':
                $prefix = 'website/images/team_work/';
                break;
            case 'AboutTranslation':
            case 'AboutImage':
                $prefix = 'website/images/about/';
                break;
            case 'Gallery':
            case 'GalleryImage':
                $prefix = 'website/images/gallery/';
                break;
            case 'GalleryVideo':
                $prefix = 'website/uploads/videos/';
                break;
            case 'FlashSale':
                $prefix = 'uploads/flash_sales/';
                break;
            default:
                return $value;
        }

        if ($prefix && str_starts_with($value, $prefix)) {
            return $value;
        }

        return $prefix . $value;
    }

    /**
     * Accessor for 'image' attribute
     */
    public function getImageAttribute($value)
    {
        return $this->resolvePath($value, 'image');
    }

    /**
     * Accessor for 'video' attribute
     */
    public function getVideoAttribute($value)
    {
        return $this->resolvePath($value, 'video');
    }
    
    /**
     * Accessor for 'primary_image' attribute (used in some models)
     */
    public function getPrimaryImageAttribute($value)
    {
         return $this->resolvePath($value, 'primary_image');
    }
}
