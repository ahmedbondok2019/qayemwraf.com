<?php

namespace App\Imports;

use App\Http\Controllers\helper\HelperController;
use App\Models\Brand;
use App\Models\BrandTranslation;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductRelate;
use App\Models\ProductTranslation;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $count = 0;
        foreach ($rows as $row) {
            $count += 1;
            // if($count > 1){
            if ($count > 500 && $count < 601) {
                // $productID = Product::where("id", $row[0])->first();
                // if (empty($productID)) {
                //     $productID = Product::create(self::productData($row));
                // }

                // $cat = array_filter(explode(',' , $row[42]), fn($value) => !is_null($value) && $value !== '');
                // $categories = array_unique($cat);
                // $productID->categories()->attach($categories);

                // if(!empty($row[46])){
                //     $rel = array_filter(explode(',' , $row[46]), fn($value) => !is_null($value) && $value !== '');
                //     $related = array_unique($rel);
                //     foreach($related as $relate){
                //         $testRelate = ProductRelate::where('product_id', $productID->id)->where('related_id',$relate)
                //             ->first();
                //         if(empty($testRelate)){
                //             ProductRelate::create([
                //                 'product_id' => $productID->id,
                //                 'related_id' => $relate
                //             ]);
                //         }
                //     }
                // }

                // try{
                //     $content = file_get_contents($row[10]);
                //     $primary_image = HelperController::make_slug(Carbon::now()) . rand(10,100) . '.jpg';

                //     $path = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'products');
                //     $destination = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'products'.DIRECTORY_SEPARATOR.$primary_image);
                //     helperController::upload_images($path,$destination, $content,'500', '500' ,'png');
                // }catch(Exception $ex){
                //     $primary_image = "no_image";
                // }

                $testTrans = ProductTranslation::where('title', strip_tags($row[3]))->first();
                if ($testTrans) {
                    $id = $testTrans->id;
                } else {
                    $id = null;
                }
                self::allUpload($row[50], $row[1], $row[0], strip_tags($row[3]), $id);

                // if(empty($testTrans)){
                //     ProductTranslation::create([
                //         "title" => strip_tags($row[3]),
                //         "description" => $row[5],
                //         "tags" => $row[9],
                //         "categories_id" => reset($categories),
                //         "category_id" => reset($categories),
                //         "primary_image" => $primary_image,
                //         "pdf_file" => null,
                //         "video_link" => null,
                //         "video_file" => null,
                //         "meta_title" => $row[7],
                //         "meta_description" => $row[8],
                //         "meta_keywords" => $row[9],
                //         "product_id" => $productID->id,
                //         "lang_id" => $row[1],
                //     ]);
                // }
            }
        }
    }

    public static function productData($row)
    {
        // $model = BrandTranslation::where('title', trim($row[4]))->first();
        // if(!$model){
        //     $model = Brand::create([
        //         'status' => 1,
        //     ]);
        //     BrandTranslation::create([
        //         "title" => $row[40],
        //         "image" => 'default.png',
        //         "brand_id" => $model->id,
        //         "lang_id" => 'ar',
        //     ]);

        //     BrandTranslation::create([
        //         "title" => $row[40],
        //         "image" => 'default.png',
        //         "brand_id" => $model->id,
        //         "lang_id" => 'en',
        //     ]);
        // }

        return [
            'id' => $row[0],
            'lang_id' => $row[1],
            'status' => 1,
            'views' => $row[52],
            'price' => $row[19],
            'sale_price' => 0,
            'cost' => $row[55],
            'brand_id' => $row[40],
            'model' => $row[4],
            'shipping' => $row[27],
            'shipping_category' => 1,
            'quantity' => $row[22],
            'ignore_quantity' => 0,
            'best_seller' => 0,
            'hot_deals' => 0,
            'deal_of_day' => 0,
            'deal_of_day_end' => null,
            'offer_type' => null,
            'product_categories' => $row[42],
            'product_options' => null,
            'related_products' => $row[46],
            'item_code' => $row[12],
            'barcode' => $row[11],
            'height' => $row[30],
            'width' => $row[33],
            'weight' => $row[35],
            'tall' => $row[34],
            'vendor_id' => 1,
        ];
    }

    public static function allUpload($Productimages, $lang, $productID, $title, $TransID)
    {
        $primary_image = '';
        if ($Productimages != null) {
            $images = explode(';', $Productimages);
            // dd($images);
            foreach ($images as $image) {
                try {
                    $content = file_get_contents($image);
                    $primary_image = HelperController::make_slug($title.'-'.Carbon::now()).'.jpg';

                    $path = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'products');
                    $destination = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'products'.DIRECTORY_SEPARATOR.$primary_image);
                    helperController::upload_images($path, $destination, $content, '500', '500', 'png');
                } catch (Exception $ex) {
                    $primary_image = $image;
                }

                ProductImage::create([
                    'image' => $primary_image,
                    'product_id' => $productID,
                    'translation_id' => $TransID,
                    'lang_id' => $lang,
                ]);
                // dd($newRow);
            }
        }

        return $primary_image;
    }
}
