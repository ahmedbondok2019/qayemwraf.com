<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProductsDashboardExport;
use App\Http\Controllers\helper\HelperController;
use App\Http\Requests\products\CreateProductRequest;
use App\Http\Requests\products\UpdateProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\Option;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\ProductOption;
use App\Models\ProductOptionItem;
use App\Models\ProductRelate;
use App\Models\ProductTranslation;
use App\Models\ShippingCategory;
use App\Models\Vendor;
use App\Observers\ProductObserver;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProductsController extends BackendController
{
    public function index(Request $request)
    {
        if (! in_array('41', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data = [];
        $data['category_id'] = null;
        if (isset($request->category_id)) {
            $data['category_id'] = $request->category_id;
        }

        return view('dashboard.admin.products.index', $data);
    }

    public function create()
    {

        if (! in_array('42', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $parents = Category::select('parent_id')->pluck('parent_id');
        $data['categories'] = Category::whereNotIn('id', $parents)->whereNull('deleted_at')->with('childs')
            ->with('CategoryTranslation')->orderby('view')->get();
   
        $data['brands'] = Brand::whereHas('BrandTranslations')->get();
        $data['shipping_categories'] = ShippingCategory::whereHas('translations')->get();

        return view('dashboard.admin.products.create', $data);
    }
// 
    public function edit($id)
    {
        if (! in_array('43', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $data['details'] = Product::with('translations')->find($id);
        if ($data['details'] == null) {
            return redirect('/admin-2023/products/all');
        }
        // Check if ANY translation exists (using translations collection)
        if ($data['details']->translations->isEmpty()) {
            return redirect('/admin-2023/products/addTrans/'.$id);
        }
        $data['id'] = $id;
        $parents = Category::select('parent_id')->pluck('parent_id');
        $data['categories'] = Category::whereNotIn('id', $parents)->whereNull('deleted_at')->with('childs')
            ->with('CategoryTranslation')->orderby('view')->get();
        $data['products'] = Product::select('id')->with('translations')->get(); // Restored and optimized
        $data['brands'] = Brand::whereHas('BrandTranslations')->get();
        $data['options'] = Option::all();
        $data['vendors'] = Vendor::all();
        $data['shipping_categories'] = ShippingCategory::whereHas('translations')->get();
        return view('dashboard.admin.products.edit', $data);
    }

    public function store(CreateProductRequest $request)
    {
        // ===== 1. معالجة الصور =====
        $primaryImage = null;
        $pdfFile = null;
        $videoLink = $request->video ?: null;

        // --- الصورة الأساسية ---
        if ($request->filled('cropped_image')) {
            $tempName = $request->cropped_image;
            $tempPath = public_path("website/images/temporary/{$tempName}");
            if (file_exists($tempPath)) {
                $finalName = Str::random(15).'.jpg';
                $path = 'website' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'products';
                $fullStoragePath = storage_path('app/public' . DIRECTORY_SEPARATOR . $path);
                if (!file_exists($fullStoragePath)) {
                    mkdir($fullStoragePath, 0755, true);
                }
                rename($tempPath, $fullStoragePath . DIRECTORY_SEPARATOR . $finalName);
                $primaryImage = 'storage/website/images/products/' . $finalName;
            }
        } elseif ($request->hasFile('primary_image')) {
            $file = $request->file('primary_image');
            $finalName = Str::random(15).'.'.$file->getClientOriginalExtension();
            $path = 'website' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'products';
            $fullStoragePath = storage_path('app/public' . DIRECTORY_SEPARATOR . $path);
            if (!file_exists($fullStoragePath)) {
                mkdir($fullStoragePath, 0755, true);
            }
            $file->move($fullStoragePath, $finalName);
            \App\Http\Controllers\helper\HelperController::syncToRootImages($fullStoragePath . DIRECTORY_SEPARATOR . $finalName, 'products/' . $finalName);
            $primaryImage = 'storage/website/images/products/' . $finalName;
        }

        // --- الصور الإضافية ---
        $galleryImages = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $img) {
                $name = Str::random(15).'.'.$img->getClientOriginalExtension();
                $path = 'website' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'products';
                $fullStoragePath = storage_path('app/public' . DIRECTORY_SEPARATOR . $path);
                if (!file_exists($fullStoragePath)) {
                    mkdir($fullStoragePath, 0755, true);
                }
                $img->move($fullStoragePath, $name);
                \App\Http\Controllers\helper\HelperController::syncToRootImages($fullStoragePath . DIRECTORY_SEPARATOR . $name, 'products/' . $name);
                $galleryImages[] = 'storage/website/images/products/' . $name;
            }
        }

        // --- الملف PDF ---
        if ($request->hasFile('pdf_file')) {
            $pdf = $request->file('pdf_file');
            $pdfName = Str::random(15).'.'.$pdf->getClientOriginalExtension();
            $path = 'website' . DIRECTORY_SEPARATOR . 'pdf';
            $fullStoragePath = storage_path('app/public' . DIRECTORY_SEPARATOR . $path);
            if (!file_exists($fullStoragePath)) {
                mkdir($fullStoragePath, 0755, true);
            }
            $pdf->move($fullStoragePath, $pdfName);
            $pdfFile = 'storage/website/pdf/' . $pdfName;
        }

        $cat = array_filter(explode(',', $request->product_categories), fn ($value) => ! is_null($value) && $value !== '');
        $categories = array_unique($cat);

        $opt = array_filter(explode(',', $request->product_options), fn ($value) => ! is_null($value) && $value !== '');
        $options = array_unique($opt);

        $rel = array_filter(explode(',', $request->related_products), fn ($value) => ! is_null($value) && $value !== '');
        $related = array_unique($rel);

        $bestSeller = self::validDate($request->best_seller, $request->best_seller_start, $request->best_seller_end);
        $hotDeals = self::validDate($request->hot_deals, $request->hot_deals_start, $request->hot_deals_end);
        $dealOfDay = self::validDate($request->deal_of_day, $request->deal_of_day_start, $request->deal_of_day_end);

        // ===== 2. إنشاء المنتج الرئيسي =====
        $product = Product::create([
            'vendor_id' => 1,
            'lang_id' => app()->getLocale(),
            'status' => $request->status ?? 0,
            'views' => 0,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'quantity' => $request->quantity,
            'max_order' => $request->max_order,
            'cost' => $request->cost,
            'brand_id' => $request->brand_id,
            'model' => $request->model,
            'shipping' => $request->shipping,
            'shipping_category' => $request->shipping_category,
            'ignore_quantity' => isset($request->ignore_quantity) ? $request->ignore_quantity : 0,
            'best_seller' => isset($request->best_seller) ? $request->best_seller : 0,
            'hot_deals' => isset($request->hot_deals) ? $request->hot_deals : 0,
            'deal_of_day' => isset($request->deal_of_day) ? $request->deal_of_day : 0,
            'best_seller_start' => $bestSeller[0],
            'best_seller_end' => $bestSeller[1],
            'hot_deals_start' => $hotDeals[0],
            'hot_deals_end' => $hotDeals[1],
            'deal_of_day_start' => $dealOfDay[0],
            'deal_of_day_end' => $dealOfDay[1],
            'offer_type' => $request->offer_type,
            'product_categories' => collect($categories)->implode(','),
            'product_options' => collect($options)->implode(','),
            'related_products' => collect($related)->implode(','),
            'item_code' => $request->item_code,
            'barcode' => $request->barcode,
            'height' => $request->height,
            'width' => $request->width,
            'weight' => $request->weight,
            'tall' => $request->tall,
            'weight_unit' => $request->weight_unit,
            'tall_unit' => $request->tall_unit,
            'short_url' => Str::random(50),
        ]);

        // ===== 3. حفظ الترجمات لكل لغة =====
        foreach ($request->translations ?? [] as $langCode => $data) {
            if (empty($data['title'])) {
                continue;
            }

            ProductTranslation::create([
                'product_id' => $product->id,
                'lang_id' => $langCode,
                'title' => $data['title'],
                'slug' => HelperController::make_slug($data['slug'] ?? $data['title']),
                'description' => $data['description'] ?? '',
                'categories_id' => reset($categories),
                'category_id' => reset($categories),
                'meta_title' => $data['meta_title'] ?? '',
                'meta_description' => $data['meta_description'] ?? '',
                'meta_keywords' => $data['meta_keywords'] ?? '',
                'primary_image' => $primaryImage,
                'pdf_file' => $pdfFile,
                'video_link' => $videoLink,
            ]);
        }

        // ===== 4. حفظ الصور الإضافية (إن وجدت) =====
        if (! empty($galleryImages)) {
            foreach ($galleryImages as $img) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $img,
                ]);
            }
        }

        $data = self::allUpload($request);
        $cat = array_filter(explode(',', $request->product_categories), fn ($value) => ! is_null($value) && $value !== '');
        $categories = array_unique($cat);

        $product->categories()->attach($categories);

        if (! empty($request->related_products)) {
            $rel = array_filter(explode(',', $request->related_products), fn ($value) => ! is_null($value) && $value !== '');
            $related = array_unique($rel);
            foreach ($related as $relate) {
                ProductRelate::create([
                    'product_id' => $product->id,
                    'related_id' => $relate,
                ]);
            }
        }

        // Generate QR Code
        $categoryID = ProductCategory::where('product_id', $product->id)->first();
        if ($categoryID) {
            $categoryData = CategoryTranslation::where('category_id', $categoryID->category_id)->first();
            if ($categoryData) {
                $activeCategory = str_replace('-', ' ', $categoryData->title);
                $productTitle = $product->translation->title ?? $request->title;
                $image = QrCode::format('svg')
                    ->size(600)
                    ->margin(5)
                    ->generate(
                        LaravelLocalization::localizeUrl(
                            'product/'.intval($product->id).'/'.
                                htmlentities(urlencode(
                                    \App\Http\Controllers\helper\HelperController::make_slug($productTitle).
                                        '/'.\App\Http\Controllers\helper\HelperController::make_slug($activeCategory)
                                ))
                        )
                    );
                $output_file = 'img-'.time().'.svg';
                Storage::disk('MyDisk')->put($output_file, $image);
                $path = public_path('website/images/BarCode/').\Illuminate\Support\Carbon::now()->format('M-Y').'/';
                $toRemove = HelperController::getResourcePath().'public/';
                $url = str_replace($toRemove, '', $path);
                $fullUrl = env('APP_URL').$url.$output_file;
                $product->qr_code = $fullUrl;
                $product->save();
            }
        }

        // Update Dropzone Images Relation
        if ($request->filled('random_id')) {
            ProductImage::where('product_id', $request->random_id)->update(['product_id' => $product->id]);
        }

        // Save Options
        self::optionItems($request->op, $product->id, false);

        alert()->success(trans_db('dashboard.Product added successfully'), trans_db('dashboard.Success'));

        return redirect('/admin-2023/products/all');
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::find($id);
        if (! $product) {
            return redirect()->back()->withErrors(['msg' => 'Product not found']);
        }

        // ===== 1. معالجة الصور =====
        $primaryImage = null;
        $pdfFile = $product->pdf_file; // احتفظ بالقيمة الحالية إذا لم تُعدّل
        $videoLink = $request->video_link ?: null;

        // --- الصورة الأساسية ---
        if ($request->filled('cropped_image')) {
            $tempName = $request->cropped_image;
            $tempPath = public_path("website/images/temporary/{$tempName}");
            if (file_exists($tempPath)) {
                // احذف الصورة القديمة
                $oldTrans = $product->translation;
                if ($oldTrans && $oldTrans->primary_image) {
                    $oldImage = $oldTrans->primary_image;
                    $oldPath = str_replace('storage/', '', $oldImage);
                    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($oldPath)) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
                    } elseif (file_exists(public_path($oldImage))) {
                        unlink(public_path($oldImage));
                    } elseif (file_exists(public_path('website/images/products/' . $oldImage))) {
                        unlink(public_path('website/images/products/' . $oldImage));
                    }
                }

                $finalName = Str::random(15).'.jpg';
                $path = 'website' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'products';
                $fullStoragePath = storage_path('app/public' . DIRECTORY_SEPARATOR . $path);
                if (!file_exists($fullStoragePath)) {
                    mkdir($fullStoragePath, 0755, true);
                }
                rename($tempPath, $fullStoragePath . DIRECTORY_SEPARATOR . $finalName);
                $primaryImage = 'storage/website/images/products/' . $finalName;
            }
        } elseif ($request->hasFile('primary_image')) {
            // احذف الصورة القديمة
            $oldTrans = $product->translation;
            if ($oldTrans && $oldTrans->primary_image) {
                $oldImage = $oldTrans->primary_image;
                $oldPath = str_replace('storage/', '', $oldImage);
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($oldPath)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
                } elseif (file_exists(public_path($oldImage))) {
                    unlink(public_path($oldImage));
                } elseif (file_exists(public_path('website/images/products/' . $oldImage))) {
                    unlink(public_path('website/images/products/' . $oldImage));
                }
            }

            $file = $request->file('primary_image');
            $finalName = Str::random(15).'.'.$file->getClientOriginalExtension();
            $path = 'website' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'products';
            $fullStoragePath = storage_path('app/public' . DIRECTORY_SEPARATOR . $path);
            if (!file_exists($fullStoragePath)) {
                mkdir($fullStoragePath, 0755, true);
            }
            $file->move($fullStoragePath, $finalName);
            \App\Http\Controllers\helper\HelperController::syncToRootImages($fullStoragePath . DIRECTORY_SEPARATOR . $finalName, 'products/' . $finalName);
            $primaryImage = 'storage/website/images/products/' . $finalName;
        }

        // --- الملف PDF ---
        if ($request->hasFile('pdf_file')) {
            // احذف الملف القديم
            if ($product->pdf_file) {
                 $oldPdf = $product->pdf_file;
                 $oldPath = str_replace('storage/', '', $oldPdf);
                 if (\Illuminate\Support\Facades\Storage::disk('public')->exists($oldPath)) {
                     \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
                 } elseif (file_exists(public_path($oldPdf))) {
                     unlink(public_path($oldPdf));
                 } elseif (file_exists(public_path("website/pdf/{$oldPdf}"))) {
                     unlink(public_path("website/pdf/{$oldPdf}"));
                 }
            }
            $pdf = $request->file('pdf_file');
            $pdfName = Str::random(15).'.'.$pdf->getClientOriginalExtension();
            $path = 'website' . DIRECTORY_SEPARATOR . 'pdf';
            $fullStoragePath = storage_path('app/public' . DIRECTORY_SEPARATOR . $path);
            if (!file_exists($fullStoragePath)) {
                mkdir($fullStoragePath, 0755, true);
            }
            $pdf->move($fullStoragePath, $pdfName);
            $pdfFile = 'storage/website/pdf/' . $pdfName;
        }

        $cat = array_filter(explode(',', $request->product_categories), fn ($value) => ! is_null($value) && $value !== '');
        $categories = array_unique($cat);

        $opt = array_filter(explode(',', $request->product_options), fn ($value) => ! is_null($value) && $value !== '');
        $options = array_unique($opt);

        $rel = array_filter(explode(',', $request->related_products), fn ($value) => ! is_null($value) && $value !== '');
        $related = array_unique($rel);

        $bestSeller = self::validDate($request->best_seller, $request->best_seller_start, $request->best_seller_end);
        $hotDeals = self::validDate($request->hot_deals, $request->hot_deals_start, $request->hot_deals_end);
        $dealOfDay = self::validDate($request->deal_of_day, $request->deal_of_day_start, $request->deal_of_day_end);

        // ===== 2. تحديث المنتج الرئيسي =====
        $product->update([
            'status' => $request->status ?? 0,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'quantity' => $request->quantity,
            'views' => 0,
            'max_order' => $request->max_order,
            'cost' => $request->cost,
            'brand_id' => $request->brand_id,
            'model' => $request->model,
            'shipping' => $request->shipping,
            'shipping_category' => $request->shipping_category,
            'ignore_quantity' => isset($request->ignore_quantity) ? $request->ignore_quantity : 0,
            'best_seller' => isset($request->best_seller) ? $request->best_seller : 0,
            'hot_deals' => isset($request->hot_deals) ? $request->hot_deals : 0,
            'deal_of_day' => isset($request->deal_of_day) ? $request->deal_of_day : 0,
            'best_seller_start' => $bestSeller[0],
            'best_seller_end' => $bestSeller[1],
            'hot_deals_start' => $hotDeals[0],
            'hot_deals_end' => $hotDeals[1],
            'deal_of_day_start' => $dealOfDay[0],
            'deal_of_day_end' => $dealOfDay[1],
            'offer_type' => $request->offer_type,
            'product_categories' => collect($categories)->implode(','),
            'product_options' => collect($options)->implode(','),
            'related_products' => collect($related)->implode(','),
            'item_code' => $request->item_code,
            'barcode' => $request->barcode,
            'height' => $request->height,
            'width' => $request->width,
            'weight' => $request->weight,
            'tall' => $request->tall,
            'vendor_id' => isset($product) ? $product->vendor_id : 1,
            'weight_unit' => $request->weight_unit,
            'tall_unit' => $request->tall_unit,
            'short_url' => isset($product) && $product->short_url == null ? $product->short_url : Str::random(50),
        ]);

        // ===== 3. تحديث الترجمات لكل لغة =====
        foreach ($request->translations ?? [] as $langCode => $data) {
            if (empty($data['title'])) {
                continue;
            }

            $imageToUse = $primaryImage ?: $product->translations->where('lang_id', $langCode)->first()?->primary_image;

            ProductTranslation::updateOrCreate(
                ['product_id' => $product->id, 'lang_id' => $langCode],
                [
                    'title' => $data['title'],
                    'slug' => HelperController::make_slug($data['slug'] ?? $data['title']),
                    'description' => $data['description'] ?? '',
                    'categories_id' => reset($categories) ?? 1, // Ensure a default value if empty
                    'category_id' => reset($categories) ?? 1,
                    'meta_title' => $data['meta_title'] ?? '',
                    'meta_description' => $data['meta_description'] ?? '',
                    'meta_keywords' => $data['meta_keywords'] ?? '',
                    'primary_image' => $imageToUse,
                    'video_link' => $request->video_link,
                    'pdf_file' => $pdfFile,
                    // 'video' => $videoLink, // Removed: Column does not exist
                ]
            );
        }

        // ===== 4. تحديث الصور الإضافية (إن طُلب) =====
        if ($request->filled('delete_gallery')) {
            foreach ($request->delete_gallery as $imgId) {
                $img = ProductImage::find($imgId);
                if ($img && $img->image) {
                    $oldImage = $img->image;
                    $oldPath = str_replace('storage/', '', $oldImage);
                    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($oldPath)) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
                    } elseif (file_exists(public_path($oldImage))) {
                        unlink(public_path($oldImage));
                    } elseif (file_exists(public_path('website/images/products/' . $oldImage))) {
                        unlink(public_path('website/images/products/' . $oldImage));
                    }
                    $img->delete();
                }
            }
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $img) {
                $name = Str::random(15).'.'.$img->getClientOriginalExtension();
                $path = 'website' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'products';
                $fullStoragePath = storage_path('app/public' . DIRECTORY_SEPARATOR . $path);
                if (!file_exists($fullStoragePath)) {
                    mkdir($fullStoragePath, 0755, true);
                }
                $img->move($fullStoragePath, $name);
                \App\Http\Controllers\helper\HelperController::syncToRootImages($fullStoragePath . DIRECTORY_SEPARATOR . $name, 'products/' . $name);
                ProductImage::create(['product_id' => $product->id, 'image' => 'storage/website/images/products/' . $name]);
            }
        }

        // Sync Categories
        $cat = array_filter(explode(',', $request->product_categories), fn ($value) => ! is_null($value) && $value !== '');
        $categories = array_unique($cat);
        $product->categories()->sync($categories);

        // Update Related Products
        if (! empty($request->related_products)) {
            $rel = array_filter(explode(',', $request->related_products), fn ($value) => ! is_null($value) && $value !== '');
            $related = array_unique($rel);
            foreach ($related as $relate) {
                $test = ProductRelate::where('product_id', $product->id)->where('related_id', $relate)->first();
                if (empty($test)) {
                    ProductRelate::create([
                        'product_id' => $product->id,
                        'related_id' => $relate,
                    ]);
                }
            }
        }

        // Update Options
        self::optionItems($request->op, $product->id, true);

        // Update Dropzone Images (if using random_id during edit, usually product id is used directly but good to check)
        // If random_id is different from product_id, it means we might want to attach them, but in edit mode
        // usually random_id IS product_id. We skip this for edit unless we are sure.

        alert()->success(trans_db('dashboard.Product updated successfully'), trans_db('dashboard.Success'));

        return redirect('/admin-2023/products/all');
    }

    public static function storeProduct(Request $request, $type = null)
    {
        if ($type == null) {
            $test = ProductTranslation::where('title', $request->title)->first();
            if (! empty($test)) {
                return ['status' => false, 'message' => trans_db('dashboard.notsaved')];
            }
            $Createproduct = Product::create(self::productData($request));
        } else {
            $Createproduct = Product::where('id', $request->id)->first();
        }

        if ($request->primary_image == null && isset($Createproduct->translations) && $Createproduct->translations->primary_image == null) {
            return ['status' => false, 'message' => trans_db('dashboard.Image_required')];
        }

        $data = self::allUpload($request);
        $cat = array_filter(explode(',', $request->product_categories), fn ($value) => ! is_null($value) && $value !== '');
        $categories = array_unique($cat);

        $Createproduct->categories()->attach($categories);

        if (! empty($request->related_products)) {
            $rel = array_filter(explode(',', $request->related_products), fn ($value) => ! is_null($value) && $value !== '');
            $related = array_unique($rel);
            foreach ($related as $relate) {
                ProductRelate::create([
                    'product_id' => $Createproduct->id,
                    'related_id' => $relate,
                ]);
            }
        }

        $CreateTrans = ProductTranslation::create([
            'title' => strip_tags($request->title),
            'slug' => HelperController::make_slug($request->slug) ?? $request->title,
            'description' => $request->description,
            'categories_id' => reset($categories),
            'category_id' => reset($categories),
            'primary_image' => $request->has('primary_image') ? $data[0] : optional($Createproduct)->translations->primary_image,
            'pdf_file' => isset($data[1]) ? $data[1] : null,
            'video_link' => $request->video_link,
            'video_file' => ! empty($request->video_file) ? $data[2] : null,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'product_id' => $Createproduct->id,
            'lang_id' => app()->getLocale(),
        ]);

        $categoryID = ProductCategory::where('product_id', $Createproduct->id)->first();
        $categoryData = CategoryTranslation::where('category_id', $categoryID->category_id)->first();
        $data['activeCategory'] = str_replace('-', ' ', $categoryData->title);
        $image = QrCode::format('svg')
            ->size(600)
            ->margin(5)
            ->generate(
                LaravelLocalization::localizeUrl(
                    'product/'.intval($Createproduct->id).'/'.
                        htmlentities(urlencode(
                            \App\Http\Controllers\helper\HelperController::make_slug($Createproduct->translations->title).
                                '/'.\App\Http\Controllers\helper\HelperController::make_slug($data['activeCategory'])
                        ))
                )
            );
        $output_file = 'img-'.time().'.svg';
        Storage::disk('MyDisk')->put($output_file, $image); // storage/app/public/img/qr-code/img-1557309130.png
        $path = public_path('website/images/BarCode/').\Illuminate\Support\Carbon::now()->format('M-Y').'/';
        $toRemove = HelperController::getResourcePath().'public/';
        $url = str_replace($toRemove, '', $path);
        $data['fullUrl'] = env('APP_URL').$url.$output_file;
        $Createproduct->qr_code = $data['fullUrl'];
        $Createproduct->save();

        ProductImage::where('product_id', $request->random_id)->update(['product_id' => $Createproduct->id]);

        if ($CreateTrans) {

            self::optionItems(
                $request->op,
                $Createproduct->id,
                false
            );

            // self::images(
            //     $request->image ,
            //     $request->title ,
            //     $Createproduct->id,
            //     $CreateTrans->id ,
            //     app()->getLocale()
            // );
            return ['status' => true, 'message' => trans_db('dashboard.saved')];
        }

        return ['status' => false, 'message' => trans_db('dashboard.notsaved')];
    }

    public static function updateProduct(UpdateProductRequest $request)
    {
        $testDublicate = ProductTranslation::where('title', $request->title)
            ->where('product_id', '!=', $request->id)->first();
        if (! empty($testDublicate)) {
            session()->flash('msg', 'this title already taken..');

            return redirect()->back();
        }

        Product::observe(ProductObserver::class);

        $Product = Product::find($request->id);
        $Product->update(self::productData($request, $Product));

        $ProductTranslation = ProductTranslation::where('product_id', $request->id)
            ->where('lang_id', app()->getLocale())->first();

        $data = self::allUpload($request);
        $cat = array_filter(explode(',', $request->product_categories), fn ($value) => ! is_null($value) && $value !== '');
        $categories = array_unique($cat);
        $Product->categories()->sync($categories);

        if (! empty($request->related_products)) {
            $rel = array_filter(explode(',', $request->related_products), fn ($value) => ! is_null($value) && $value !== '');
            $related = array_unique($rel);
            foreach ($related as $relate) {
                $test = ProductRelate::where('product_id', $Product->id)->where('related_id', $relate)->first();
                if (empty($test)) {
                    ProductRelate::create([
                        'product_id' => $Product->id,
                        'related_id' => $relate,
                    ]);
                }
            }
        }

        $ProductTranslation->update([
            'title' => strip_tags($request->title),
            'slug' => HelperController::make_slug($request->slug) ?? $request->title,
            'description' => $request->description,
            'categories_id' => reset($categories),
            'category_id' => reset($categories),
            'primary_image' => $request->has('primary_image') ? $data[0] : $ProductTranslation->primary_image,
            'pdf_file' => isset($data[1]) ? $data[1] : $ProductTranslation->pdf_file,
            'video_link' => $request->video_link,
            'video_file' => ! empty($request->video_file) ? $data[2] : $ProductTranslation->video_file,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'product_id' => $Product->id,
            'lang_id' => app()->getLocale(),
        ]);

        if ($request->has('image')) {
            self::images(
                $request->image,
                strip_tags($request->title),
                $request->id,
                $ProductTranslation->id,
                app()->getLocale()
            );
        }

        self::optionItems(
            $request->op,
            $Product->id,
            true
        );

        return true;
    }

    public static function optionItems($options, $Createproduct, $update = false)
    {
        if (! empty($options)) {
            if ($update == true) {
                $allId_deleted = [];
                $allId_deleteds = [];
                // / delete records from table where deleted from blade.
                foreach ($options as $key => $optionPrimary) {
                    if (isset($optionPrimary['id'])) {
                        $allId_deleted[] = $optionPrimary['id'];
                    }
                }
                ProductOption::whereNotIn('id', $allId_deleted)->where('product_id', $Createproduct)->delete();

                foreach ($options as $key => $optionPrimary) {
                    if (isset($optionPrimary['item_id'])) {
                        foreach ($optionPrimary['item_id'] as $index => $key) {
                            $allId_deleteds[] = $optionPrimary['item_id'][$index];
                        }
                    }
                }
                ProductOptionItem::whereNotIn('id', $allId_deleteds)->where('product_id', $Createproduct)->delete();
            }

            foreach ($options as $key => $optionPrimary) {
                $canCreate = false;
                $testOptionNotInProduct = ProductOption::where('option_id', $optionPrimary['option_id'])
                    ->where('product_id', $Createproduct)->first();
                if (empty($testOptionNotInProduct)) {
                    $canCreate = true;
                }

                if ($update == false) {
                    if ($canCreate == true) {
                        $OptionItem = ProductOption::create([
                            'option_id' => $optionPrimary['option_id'],
                            'isRequired' => isset($optionPrimary['option_required']) && $optionPrimary['option_required'] == '1' ? '1' : '0',
                            'product_id' => $Createproduct,
                        ]);
                        $ProductOptionId = $OptionItem->id;
                    }
                }

                if ($update == true) {
                    if (! isset($optionPrimary['id'])) {
                        if ($canCreate == true) {
                            $OptionItem = ProductOption::create([
                                'option_id' => $optionPrimary['option_id'],
                                'isRequired' => isset($optionPrimary['option_required']) && $optionPrimary['option_required'] == '1' ? '1' : '0',
                                'product_id' => $Createproduct,
                            ]);
                            $ProductOptionId = $OptionItem->id;
                        }
                    } else {
                        $OptionItem = ProductOption::where('id', $optionPrimary['id'])
                            ->update([
                                'isRequired' => isset($optionPrimary['option_required']) && $optionPrimary['option_required'] == '1' ? '1' : '0',
                            ]);
                        $ProductOptionId = $optionPrimary['id'];
                    }
                }

                if (isset($ProductOptionId)) {
                    if (isset($optionPrimary['quantity']) && $optionPrimary['quantity'] != '') {
                        foreach ($optionPrimary['quantity'] as $index => $key) {
                            if (isset($optionPrimary['quantity'][$index]) && $optionPrimary['quantity'][$index] != '') {
                                if ($optionPrimary['difference_in_price'][$index] > 0) {
                                    $isPluse = true;
                                    $isMinus = false;
                                } else {
                                    $isPluse = false;
                                    $isMinus = true;
                                }

                                if ($optionPrimary['difference_in_weight'][$index] > 0) {
                                    $isPluse1 = true;
                                    $isMinus1 = false;
                                } else {
                                    $isPluse1 = false;
                                    $isMinus1 = true;
                                }
                                $difference_in_price = str_replace('-', '', $optionPrimary['difference_in_price'][$index]);
                                $difference_in_weight = str_replace('-', '', $optionPrimary['difference_in_weight'][$index]);

                                if (isset($optionPrimary['item_id'][$index]) && $optionPrimary['item_id'][$index] != '' && $optionPrimary['item_id'][$index] != null) {
                                    $pd = ProductOptionItem::where('id', $optionPrimary['item_id'][$index])->where('product_id', $Createproduct)->first();
                                    $pd->update([
                                        'quantity' => $optionPrimary['quantity'][$index],
                                        'difference_in_price' => $difference_in_price,
                                        'isPluse' => $isPluse,
                                        'isMinus' => $isMinus,
                                        'ignore_quantity' => $optionPrimary['ignore_quantity'][$index],
                                        'difference_in_weight' => $difference_in_weight,
                                        'isPluse_in_weight' => $isPluse1,
                                        'isMinus_in_weight' => $isMinus1,
                                    ]);
                                } else {
                                    $pd = ProductOptionItem::where('option_id', $optionPrimary['option_id'])
                                        ->where('option_item_id', $optionPrimary['option_item_id'][$index])
                                        ->where('product_option_id', $optionPrimary['quantity'][$index])
                                        ->where('product_id', $Createproduct)
                                        ->first();
                                    if (empty($pd)) {
                                        ProductOptionItem::create([
                                            'option_id' => $optionPrimary['option_id'],
                                            'option_item_id' => $optionPrimary['option_item_id'][$index],
                                            'product_id' => $Createproduct,
                                            'option_item_title' => $optionPrimary['option_item_title'][$index],
                                            'product_option_id' => $ProductOptionId,
                                            'quantity' => $optionPrimary['quantity'][$index],
                                            'difference_in_price' => $difference_in_price,
                                            'isPluse' => $isPluse,
                                            'isMinus' => $isMinus,
                                            'ignore_quantity' => $optionPrimary['ignore_quantity'][$index],
                                            'difference_in_weight' => $difference_in_weight,
                                            'isPluse_in_weight' => $isPluse1,
                                            'isMinus_in_weight' => $isMinus1,
                                            'lang_id' => app()->getLocale(),
                                        ]);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function delete(Request $request)
    {
        if (! in_array('44', Session::get('permissionData'))) {
            return redirect()->back();
        }
        Product::active()->where('id', $request->id)->delete();

        alert()->success(trans_db('dashboard.deleted'), trans_db('dashboard.deleted'));

        return redirect('admin-2023/products/all');
    }

    public function delete_image(Request $request)
    {
        if (! in_array('44', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $request->id != null ? $id = $request->random_id : $id = $request->random_id;
        if ($request->id !== null || $request->id != '') {
            $data = ProductImage::where('id', $request->id)->first();
        } else {
            $data = ProductImage::query();
            $file_ext = ['image/png', 'image/jpg', 'image/jpeg', 'image/avif', 'image/webp', 'image/jfif'];
            $extension = strtolower(File::mimeType(public_path('website/images/products/'.$request->file_name)));
            if (isset($request->file_name) && in_array($extension, $file_ext)) {
                $data = $data->where('image', str_replace(' ', '', $request->file_name));
            }
            $data = $data->where('product_id', $id)->first();
        }

        if ($data) {

            if (file_exists(public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'products'.DIRECTORY_SEPARATOR.$data->image))) {
                unlink('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'products'.DIRECTORY_SEPARATOR.$data->image);
            }
            $data->delete();

            alert()->success(trans_db('dashboard.deleted successfully'), trans_db('dashboard.congratulation'));
        } else {
            alert()->error(trans_db('dashboard.delete error'), trans_db('dashboard.attention'));
        }
        if (request()->ajax()) {
            return response()->json(['status' => $data != null ? true : false]);
        }

        return redirect()->back();
    }

    public function toggleLanding(Request $request)
    {
        if (! in_array('43', Session::get('permissionData'))) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $product = Product::findOrFail($request->product_id);
        $product->update([
            'show_in_landing' => $request->show_in_landing,
        ]);

        return response()->json(['success' => true]);
    }

    public function getProductOptionItems(Request $request)
    {
        $optionItems = Option::find($request->id);

        return response()->json([
            'data' => view('dashboard.admin.products.option_item', ['option' => $optionItems])->render(),
        ]);
    }

    public function change_status(Request $request)
    {
        $user = Product::find($request->product_id);
        $user->update([
            'status' => $request->product_status,
        ]);

        return response()->json(['data' => 'success']);
    }

    public function change_vendor(Request $request)
    {
        $user = Product::find($request->product_id);
        $user->update([
            'vendor_id' => $request->vendor_id,
        ]);

        return response()->json(['data' => 'success']);
    }

    public static function allUpload($request)
    {
        $ds = DIRECTORY_SEPARATOR;
        $primary_image = '';
        $pdf_file = '';
        $video_file = '';

        if ($request->has('primary_image')) {
            $primary_image = HelperController::make_slug($request->title).rand(10, 100).'.'.$request->file('primary_image')->getClientOriginalExtension();

            $path = public_path('website'.$ds.'images'.$ds.'products');
            $destination = public_path('website'.$ds.'images'.$ds.'products'.$ds.$primary_image);
            helperController::upload_images($path, $destination, $request->file('primary_image'), '576', '786', 'png');

            // $watermark = Image::make(public_path('WATER MARK.png'))->resize(576 , 1000);
            // $img = Image::make($destination)->insert($watermark);
            // $img->save($destination, 100 , 'png');

            $path = public_path('website'.$ds.'images'.$ds.'products'.$ds.'thumb');
            $destination = public_path('website'.$ds.'images'.$ds.'products'.$ds.'thumb'.$ds.$primary_image);
            HelperController::upload_images($path, $destination, $request->file('primary_image'), '300', '400');

            // $watermark = Image::make(public_path('WATER MARK.png'))->resize(250 , 250);
            // $img = Image::make($destination)->insert($watermark);
            // $img->save($destination, 100 , 'png');
        }

        if (! empty($request->pdf_file)) {
            $pdf_file = HelperController::make_slug($request->title).'.pdf';
            $request->file('pdf_file')->move(public_path('website/uploads/pdf/'), $pdf_file);
        }

        if (! empty($request->video_file)) {
            $video_file = HelperController::make_slug($request->title).'.mp4';
            $request->file('video_file')->move(public_path('website/uploads/videos/'), $video_file);
        }

        return [$primary_image, $pdf_file, $video_file];
    }

    public static function images($images, $product_price, $productId, $transId, $lang_id)
    {
        if (! empty($images)) {
            foreach ($images as $image) {
                if (! empty($image)) {
                    $imageSlug = HelperController::make_slug($product_price.rand(10, 100).'_'.str_replace(' ', '', Carbon::today()));
                    $image_name = str_replace(' ', '', $imageSlug).'.jpg';

                    $path = 'website' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'products';
                    $fullStoragePath = storage_path('app/public' . DIRECTORY_SEPARATOR . $path);
                    if (!file_exists($fullStoragePath)) {
                        mkdir($fullStoragePath, 0755, true);
                    }
                    $destination = $fullStoragePath . DIRECTORY_SEPARATOR . $image_name;
                    HelperController::upload_images($fullStoragePath, $destination, $image, '1000', '1000');
                    $relativePath = 'storage/website/images/products/' . $image_name;

                    ProductImage::create([
                        'image' => $relativePath,
                        'product_id' => $productId,
                        'translation_id' => $transId,
                        'lang_id' => $lang_id,
                    ]);
                }
            }
        } else {
            return false;
        }
    }

    public static function productData(Request $request, $Product = null)
    {
        $cat = array_filter(explode(',', $request->product_categories), fn ($value) => ! is_null($value) && $value !== '');
        $categories = array_unique($cat);

        $opt = array_filter(explode(',', $request->product_options), fn ($value) => ! is_null($value) && $value !== '');
        $options = array_unique($opt);

        $rel = array_filter(explode(',', $request->related_products), fn ($value) => ! is_null($value) && $value !== '');
        $related = array_unique($rel);

        $bestSeller = self::validDate($request->best_seller, $request->best_seller_start, $request->best_seller_end);
        $hotDeals = self::validDate($request->hot_deals, $request->hot_deals_start, $request->hot_deals_end);
        $dealOfDay = self::validDate($request->deal_of_day, $request->deal_of_day_start, $request->deal_of_day_end);

        // Sanitize integer inputs
        $maxOrder = intval($request->max_order);
        if ($maxOrder < 1) {
            $maxOrder = 1;
        }

        $quantity = intval($request->quantity);
        if ($quantity < 0) {
            $quantity = 0;
        }

        $data = [
            'lang_id' => app()->getLocale(),
            // 'categories_id' => $categories[1],
            // 'category' => $categories[1],
            'status' => $request->shipping_category == null ? 0 : (isset($Product) ? $Product->status : 0),
            'views' => 0,
            'price' => $request->price,
            'max_order' => $maxOrder,
            'sale_price' => $request->sale_price,
            'cost' => $request->cost,
            'brand_id' => $request->brand_id,
            'model' => $request->model,
            'shipping' => $request->shipping,
            'shipping_category' => $request->shipping_category,
            'quantity' => $quantity,
            'ignore_quantity' => isset($request->ignore_quantity) ? $request->ignore_quantity : 0,
            'best_seller' => isset($request->best_seller) ? $request->best_seller : 0,
            'hot_deals' => isset($request->hot_deals) ? $request->hot_deals : 0,
            'deal_of_day' => isset($request->deal_of_day) ? $request->deal_of_day : 0,
            'best_seller_start' => $bestSeller[0],
            'best_seller_end' => $bestSeller[1],
            'hot_deals_start' => $hotDeals[0],
            'hot_deals_end' => $hotDeals[1],
            'deal_of_day_start' => $dealOfDay[0],
            'deal_of_day_end' => $dealOfDay[1],
            'offer_type' => $request->offer_type,
            'product_categories' => collect($categories)->implode(','),
            'product_options' => collect($options)->implode(','),
            'related_products' => collect($related)->implode(','),
            'item_code' => $request->item_code,
            'barcode' => $request->barcode,
            'height' => $request->height,
            'width' => $request->width,
            'weight' => $request->weight,
            'tall' => $request->tall,
            'vendor_id' => isset($Product) ? $Product->vendor_id : 1,
            'weight_unit' => $request->weight_unit,
            'tall_unit' => $request->tall_unit,
            'short_url' => isset($Product) && $Product->short_url == null ? $Product->short_url : Str::random(50),
        ];

        // dd($data);
        return $data;
    }

    public static function validDate($checkedParent, $start, $end)
    {
        if ($checkedParent == 1) {
            if (isset($start) && isset($end)) {
                $Start = Carbon::createFromFormat('Y-m-d\TH:i', $start);
                $End = Carbon::createFromFormat('Y-m-d\TH:i', $end);
                $dateStart = strtotime($start);
                $dateEnd = strtotime($end);
                if ($dateEnd > $dateStart) {
                    return [$Start, $End];
                }
            }

            return [null, null];
        } else {
            return [null, null];
        }
    }

    public static function getLatLng($LatLng)
    {
        $lat = '';
        $lng = '';
        if (isset($LatLng)) {
            $data = str_replace(')', '', $LatLng);
            $datas = str_replace('(', '', $data);
            $data = explode(', ', $datas);
            $lat = $data[0];
            $lng = $data[1];
        }

        return ['lat' => $lat, 'lng' => $lng];
    }

    public function export_xls(Request $request)
    {
        return Excel::download(new ProductsDashboardExport, 'products.xlsx');
        // return Excel::download(new ProductsExport(), 'products.tsv');
    }

    public function readFiles(Request $request)
    {
        $images = ProductImage::where('product_id', $request->id)->get();
        $file_ext = ['image/png', 'image/jpg', 'image/jpeg', 'image/avif', 'image/webp', 'image/jfif'];
        $files_info = [];

        foreach ($images as $files) {
            $path = str_replace('storage/', '', $files->image);
            $fullPath = storage_path('app/public/' . $path);

            if (file_exists($fullPath)) {
                $extension = pathinfo($fullPath, PATHINFO_EXTENSION);
                if (in_array('image/' . $extension, $file_ext) || in_array($extension, ['png', 'jpg', 'jpeg', 'avif', 'webp', 'jfif'])) {
                    $size = filesize($fullPath);
                    $sizeinMB = round($size / (1024 * 1024), 2);

                    if ($sizeinMB <= 5) {
                        $files_info[] = [
                            'id' => $files->id,
                            'name' => basename($fullPath),
                            'size' => $size,
                            'path' => 'data:image/' . $extension . ';base64,' . base64_encode(file_get_contents($fullPath)),
                        ];
                    }
                }
            }
        }

        return response()->json($files_info);
    }

    public static function uploadImages(Request $request)
    {
        if (is_array($request->file)) {
            foreach ($request->file as $file) {
                $name = $file->getClientOriginalName();
                $image_name = str_replace(' ', '', $name);

                $productId = $request->random_id;

                $path = 'website' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'products';
                $fullStoragePath = storage_path('app/public' . DIRECTORY_SEPARATOR . $path);
                if (!file_exists($fullStoragePath)) {
                    mkdir($fullStoragePath, 0755, true);
                }
                $destination = $fullStoragePath . DIRECTORY_SEPARATOR . $image_name;
                HelperController::upload_images($fullStoragePath, $destination, $file);
                $relativePath = 'storage/website/images/products/' . $image_name;

                $data = [
                    'image' => $relativePath,
                    'product_id' => $productId,
                    'translation_id' => $productId,
                    'lang_id' => app()->getLocale(),
                ];

                $test = ProductImage::where($data)->exists();
                if ($test == false) {
                    ProductImage::create($data);
                }
            }
        } else {
            $file = $request->file('file');
            $name = $file->getClientOriginalName();
            $image_name = str_replace(' ', '', $name);

            $productId = $request->random_id;

            $path = 'website' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'products';
            $fullStoragePath = storage_path('app/public' . DIRECTORY_SEPARATOR . $path);
            if (!file_exists($fullStoragePath)) {
                mkdir($fullStoragePath, 0755, true);
            }
            $destination = $fullStoragePath . DIRECTORY_SEPARATOR . $image_name;
            HelperController::upload_images($fullStoragePath, $destination, $file);
            $relativePath = 'storage/website/images/products/' . $image_name;

            $data = [
                'image' => $relativePath,
                'product_id' => $productId,
                'translation_id' => $productId,
                'lang_id' => app()->getLocale(),
            ];

            $test = ProductImage::where($data)->exists();
            if ($test == false) {
                ProductImage::create($data);

                $path = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'products');
                $destination = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'products'.DIRECTORY_SEPARATOR.$image_name);
                // $destination = public_path('website' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'products' . DIRECTORY_SEPARATOR . str_replace(' ', '' ,$name));
                HelperController::upload_images($path, $destination, $request->file('file'), '576', '786');

                // $watermark = Image::make(public_path('WATER MARK.png'))->resize(576 , 1000);
                // $img = Image::make($destination)->insert($watermark);
                // $img->save($destination, 100 , 'png');

                $path = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'products'.DIRECTORY_SEPARATOR.'thumb');
                // $destination = public_path('website' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'products' . DIRECTORY_SEPARATOR . 'thumb' . DIRECTORY_SEPARATOR . str_replace(' ', '' ,$name));
                $destination = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'products'.DIRECTORY_SEPARATOR.'thumb'.DIRECTORY_SEPARATOR.$image_name);
                HelperController::upload_images($path, $destination, $request->file('file'), '300', '400');

                // $watermark = Image::make(public_path('WATER MARK.png'))->resize(576 , 1000);
                // $img = Image::make($destination)->insert($watermark);
                // $img->save($destination, 100 , 'png');
            }
        }

        return 'done';
    }

    public function searchProducts(Request $request)
    {
        $term = $request->input('search');
        $products = ProductTranslation::where('title', 'LIKE', '%'.$term.'%')->get();
        $data = [];
        foreach ($products as $product) {
            $data[] = [
                'id' => $product->product_id,
                'text' => $product->title,
            ];
        }

        return response()->json(['results' => $data]);
    }
}
