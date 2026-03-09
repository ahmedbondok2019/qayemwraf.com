<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductTranslation;
use App\Models\ProductBrand;
use App\Models\ProductBrandTranslation;
use App\Models\ShippingRule;
use App\Models\ShippingRuleTranslation;
use App\Models\Country;
use App\Models\ProductImage;
use Illuminate\Support\Facades\File;
use com_exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Category;
use App\Models\CategoryTranslation;
use Illuminate\Support\Facades\DB;

class ProductsImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (!isset($row['name_ar']) || empty($row['name_ar'])) {
                continue;
            }

            DB::beginTransaction();
            
            try {
                // Handle Brand
                $brandId = null;
                $brandName = $row['brand'] ?? $row['brand_ar'] ?? $row['brand_en'] ?? null;
                
                if ($brandName) {
                    $brandId = $this->findOrCreateBrand($brandName);
                }

                // Handle Shipping Rule (Section)
                $shippingRuleId = null;
                $shippingRuleName = $row['shipping_section'] ?? $row['shipping_rule'] ?? null;
                
                if ($shippingRuleName) {
                    $shippingRuleId = $this->findOrCreateShippingRule($shippingRuleName);
                }

                // Handle Images from public/imports/{folder}
                $mainImage = null;
                $galleryImages = [];
                $folderName = $row['image_folder'] ?? null;
                
                if ($folderName) {
                    $importPath = public_path('imports/' . $folderName);
                    if (File::isDirectory($importPath)) {
                        $files = File::files($importPath);
                        usort($files, function($a, $b) {
                            return strnatcmp($a->getFilename(), $b->getFilename());
                        });
                        
                        foreach ($files as $index => $file) {
                            $filename = Str::random(20) . '.' . $file->getExtension();
                            $destinationPath = public_path('uploads/products/' . $filename);
                            
                            // Ensure directory exists
                            if (!File::isDirectory(public_path('uploads/products/'))) {
                                File::makeDirectory(public_path('uploads/products/'), 0755, true);
                            }
                            
                            File::copy($file->getRealPath(), $destinationPath);
                            $relativeImagePath = 'uploads/products/' . $filename;
                            
                            if ($index === 0) {
                                $mainImage = $relativeImagePath;
                            } else {
                                $galleryImages[] = $relativeImagePath;
                            }
                        }
                    }
                }

                // Handle Categories
                $categoryIds = [];
                $categoriesInput = $row['category'] ?? $row['categories'] ?? $row['section'] ?? null;
                if ($categoriesInput) {
                    $categoryIds = $this->findCategoryIds($categoriesInput);
                }

                $product = Product::create([
                    'price' => $row['price'] ?? 0,
                    'quantity' => $row['quantity'] ?? 0,
                    'sku' => $row['sku'] ?? null,
                    'image' => $mainImage,
                    'weight' => $row['weight'] ?? null,
                    'max_order_qty' => $row['max_order_qty'] ?? null,
                    'ignore_quantity' => $row['ignore_quantity'] ?? 0,
                    'special_price' => $row['special_price'] ?? null,
                    'special_price_start' => $row['special_price_start'] ?? null,
                    'special_price_end' => $row['special_price_end'] ?? null,
                    'is_best_seller' => $row['is_best_seller'] ?? 0,
                    'best_seller_start' => $row['best_seller_start'] ?? null,
                    'best_seller_end' => $row['best_seller_end'] ?? null,
                    'is_gift' => $row['is_gift'] ?? 0,
                    'product_brand_id' => $brandId,
                    'shipping_rule_id' => $shippingRuleId,
                    'status' => 1,
                    'vendor_id' => auth('admin')->id(),
                ]);

                // Create Arabic Translation
                ProductTranslation::create([
                    'product_id' => $product->id,
                    'locale' => 'ar',
                    'name' => $row['name_ar'],
                    'description' => $row['description_ar'] ?? null,
                    'meta_title' => $row['meta_title_ar'] ?? null,
                    'meta_description' => $row['meta_description_ar'] ?? null,
                    'slug' => Str::slug($row['name_ar'], '-', null) ?: Str::random(10),
                ]);

                // Create English Translation if provided
                if (isset($row['name_en']) && !empty($row['name_en'])) {
                    ProductTranslation::create([
                        'product_id' => $product->id,
                        'locale' => 'en',
                        'name' => $row['name_en'],
                        'description' => $row['description_en'] ?? null,
                        'meta_title' => $row['meta_title_en'] ?? null,
                        'meta_description' => $row['meta_description_en'] ?? null,
                        'slug' => Str::slug($row['name_en']),
                    ]);
                }

                // Save Gallery Images
                foreach ($galleryImages as $index => $galleryImage) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $galleryImage,
                        'sort_order' => $index + 1
                    ]);
                }

                // Sync Categories
                if (!empty($categoryIds)) {
                    $product->categories()->sync($categoryIds);
                }

                DB::commit();
                
            } catch (\Exception $e) {
                DB::rollBack();
            }
        }
    }

    private function findOrCreateBrand($brandName)
    {
        $translation = ProductBrandTranslation::where('title', $brandName)->first();
        
        if ($translation) {
            return $translation->product_brand_id;
        }

        // Create new brand
        $brand = ProductBrand::create([
            'is_active' => 1,
        ]);

        ProductBrandTranslation::create([
            'product_brand_id' => $brand->id,
            'locale' => 'ar',
            'title' => $brandName,
        ]);

        ProductBrandTranslation::create([
            'product_brand_id' => $brand->id,
            'locale' => 'en',
            'title' => $brandName,
        ]);

        return $brand->id;
    }

    private function findOrCreateShippingRule($name)
    {
        $translation = ShippingRuleTranslation::where('name', $name)->first();
        
        if ($translation) {
            return $translation->shipping_rule_id;
        }

        // Create new shipping rule
        $country = Country::first(); // Default to first country
        
        $shippingRule = ShippingRule::create([
            'country_id' => $country ? $country->id : null,
            'is_active' => 1,
        ]);

        // Add translations
        ShippingRuleTranslation::create([
            'shipping_rule_id' => $shippingRule->id,
            'locale' => 'ar',
            'name' => $name,
        ]);

        ShippingRuleTranslation::create([
            'shipping_rule_id' => $shippingRule->id,
            'locale' => 'en',
            'name' => $name,
        ]);

        return $shippingRule->id;
    }

    private function findCategoryIds($categoriesInput)
    {
        $ids = [];
        $parts = explode(',', $categoriesInput);
        
        foreach ($parts as $part) {
            $part = trim($part);
            if (empty($part)) continue;
            
            // Try as ID
            if (is_numeric($part)) {
                $category = Category::find($part);
                if ($category) {
                    $ids[] = $category->id;
                    continue;
                }
            }
            
            // Try as Name
            $translation = CategoryTranslation::where('title', $part)->first();
            if ($translation) {
                $ids[] = $translation->category_id;
            }
        }
        
        return array_unique($ids);
    }
}
