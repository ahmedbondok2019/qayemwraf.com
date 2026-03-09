<?php

namespace App\Http\Controllers\Vendor;

use App\Exports\ProductsExport;
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
use App\Observers\ProductObserver;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Maatwebsite\Excel\Facades\Excel;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProductsController extends VendorBackendController
{
    public function index()
    {
        // $data['products'] = Product::orderByDesc('id')->paginate(25);
        return view('dashboard.vendor.products.index');
    }

    public function create()
    {
        $parents = Category::whereNotNull('show_category')->select('parent_id')->pluck('parent_id');
        $data['categories'] = Category::whereNotNull('show_category')->whereNotIn('id', $parents)->with('childs')
            ->with('CategoryTranslation')->orderby('view')->get();

        $data['brands'] = Brand::whereHas('BrandTranslations')->get();
        $data['shipping_categories'] = ShippingCategory::whereHas('translations')->get();

        return view('dashboard.vendor.products.create', $data);
    }

    public function addTrans(Request $request)
    {
        $test = ProductTranslation::where('product_id', $request->product_id)
            ->where('vendor_id', Auth::id())->where('lang_id', app()->getLocale())->first();
        if (isset($test)) {
            alert()->error(__('dashboard.Duplicate_TitleOrLanguage'), __('dashboard.attention'));

            return redirect('/vendor/products/edit/'.$request->product_id);
        }

        $data['title'] = __('dashboard.CreateNewProducTrans');
        $data['id'] = $request->product_id;

        return view('dashboard.vendor.products.trans', $data);
    }

    public function edit(Request $request)
    {
        $data['details'] = Product::where('id', $request->id)->where('vendor_id', Auth::id())->first();
        if ($data['details'] == null) {
            return redirect('/vendor/products/all');
        }
        if ($data['details']->translations == null) {
            return redirect('/vendor/products/addTrans/'.$request->id);
        }
        $data['id'] = $request->id;
        $parents = Category::whereNotNull('show_category')->select('parent_id')->pluck('parent_id');
        $data['categories'] = Category::whereNotNull('show_category')->whereNotIn('id', $parents)->with('childs')
            ->with('CategoryTranslation')->orderby('view')->get();
        $data['products'] = Product::all();
        $data['brands'] = Brand::whereHas('BrandTranslations')->get();
        $data['options'] = Option::all();
        $data['shipping_categories'] = ShippingCategory::whereHas('translations')->get();

        return view('dashboard.vendor.products.edit', $data);
    }

    public function store(CreateProductRequest $request)
    {
        $data = self::storeProduct($request);
        if ($data['status'] == true) {
            alert()->success($data['message'], __('dashboard.congratulation'));

            return redirect(LaravelLocalization::localizeUrl('/vendor/products/all'));
        } else {
            alert()->error($data['message'], __('dashboard.attention'));

            return redirect(LaravelLocalization::localizeUrl('/vendor/products/create'));
        }
    }

    public function update(UpdateProductRequest $request)
    {
        $data = self::updateProduct($request);

        if ($data == true) {
            alert()->success(__('dashboard.saved'), __('dashboard.congratulation'));
        } else {
            alert()->error(__('dashboard.notsaved'), __('dashboard.attention'));
        }

        return redirect('vendor/products/all');
    }

    public static function storeProduct(CreateProductRequest $request, $type = null)
    {
        if ($type == null) {
            $test = ProductTranslation::where('title', $request->title)->first();
            if (! empty($test)) {
                return ['status' => false, 'message' => __('dashboard.notsaved')];
            }
            $Createproduct = Product::create(self::productData($request));
        } else {
            $Createproduct = Product::where('id', $request->id)->first();
        }

        if ($request->primary_image == null && isset($Createproduct->translations) && $Createproduct->translations->primary_image == null) {
            return ['status' => false, 'message' => __('dashboard.Image_required')];
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
            'primary_image' => $request->has('primary_image') ? $data[0] : optional(optional($Createproduct)->translations)->primary_image,
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
        $image = QrCode::format('png')
            ->size(600)
            ->margin(5)
            ->generate(
                LaravelLocalization::localizeUrl(
                    'product/'.intval($Createproduct->id).'/'.
                        htmlentities(urlencode(
                            HelperController::make_slug($Createproduct->translations->title).
                                '/'.HelperController::make_slug($data['activeCategory'])
                        ))
                )
            );
        $output_file = 'img-'.time().'.png';
        Storage::disk('MyDisk')->put($output_file, $image); // storage/app/public/img/qr-code/img-1557309130.png
        $path = public_path('website/images/BarCode/').\Illuminate\Support\Carbon::now()->format('M-Y').'/';
        $toRemove = HelperController::getResourcePath().'public/';
        $url = str_replace($toRemove, '', $path);
        $data['fullUrl'] = env('APP_URL').$url.$output_file;
        $Createproduct->qr_code = $data['fullUrl'];
        $Createproduct->save();

        if ($CreateTrans) {

            self::optionItems(
                $request->op,
                $Createproduct->id,
                false
            );

            ProductImage::where('product_id', $request->random_id)->update(['product_id' => $Createproduct->id]);

            // self::images(
            //     $request->image ,
            //     $request->title ,
            //     $Createproduct->id,
            //     $CreateTrans->id ,
            //     app()->getLocale()
            // );
            return ['status' => true, 'message' => __('dashboard.saved')];
        }

        return ['status' => false, 'message' => __('dashboard.notsaved')];
    }

    public function addProductTrans(CreateProductRequest $request)
    {
        $test = ProductTranslation::where('product_id', $request->id)
            ->where('lang_id', app()->getLocale())->first();
        if (isset($test)) {
            alert()->error(__('dashboard.Duplicate_TitleOrLanguage'), __('dashboard.attention'));

            return redirect('/vendor/products/addTrans/'.$request->id);
        }

        $data = self::storeProduct($request, 'trans');
        if ($data == true) {
            alert()->success(__('dashboard.saved'), __('dashboard.congratulation'));

            return redirect('/vendor/products/all');
        } else {
            alert()->error(__('dashboard.notsaved'), __('dashboard.attention'));

            return redirect('/vendor/products/addTrans/'.$request->product_id);
        }
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
                $request->title,
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
                            'isRequired' => isset($optionPrimary['option_required']) ? true : false,
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
                                'isRequired' => isset($optionPrimary['option_required']) ? true : false,
                                'product_id' => $Createproduct,
                            ]);
                            $ProductOptionId = $OptionItem->id;
                        }
                    } else {
                        $OptionItem = ProductOption::where('id', $optionPrimary['id'])
                            ->update([
                                'isRequired' => isset($optionPrimary['option_required']) ? true : false,
                            ]);
                        $ProductOptionId = $optionPrimary['id'];
                        // dd($ProductOptionId);
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
        Product::where('vendor_id', Auth::id())->where('id', $request->id)->delete();

        alert()->success(__('dashboard.deleted'), __('dashboard.deleted'));

        return redirect('vendor/products/all');
    }

    public function delete_image(Request $request)
    {
        if ($request->id !== null || $request->id != '') {
            $data = ProductImage::find($request->id);
        } else {
            $data = ProductImage::where('image', str_replace(' ', '', $request->file_name))->where('product_id', $request->random_id)->first();
        }
        if ($data) {
            if (file_exists(public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'products'.DIRECTORY_SEPARATOR.$data->image))) {
                unlink('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'products'.DIRECTORY_SEPARATOR.$data->image);
            }
            $data->delete();

            alert()->success(__('dashboard.Deleted Successfully..'), __('dashboard.congratulation'));
        } else {
            alert()->error(__('dashboard.delete error'), __('dashboard.attention'));
        }
        if (request()->ajax()) {
            return response()->json(['status' => $data != null ? true : false]);
        }

        return redirect()->back();
    }

    public function getProductOptionItems(Request $request)
    {
        $optionItems = Option::find($request->id);

        return response()->json([
            'data' => view('dashboard.vendor.products.option_item', ['option' => $optionItems])->render(),
        ]);
    }

    public function change_status(Request $request)
    {
        if (in_array($request->product_status, ['2', '0'])) {

            Product::observe(ProductObserver::class);

            $user = Product::find($request->product_id);
            $user->update([
                'status' => $request->product_status,
            ]);

            return response()->json(['data' => 'success']);
        }

        return response()->json(['data' => 'failed']);
    }

    public static function allUpload($request)
    {
        $primary_image = '';
        $pdf_file = '';
        $video_file = '';
        $ds = DIRECTORY_SEPARATOR;

        if ($request->has('primary_image')) {
            $primary_image = HelperController::make_slug($request->title).rand(10, 100).'.'.$request->file('primary_image')->getClientOriginalExtension();

            $path = public_path('website'.$ds.'images'.$ds.'products');
            $destination = public_path('website'.$ds.'images'.$ds.'products'.$ds.$primary_image);
            helperController::upload_images($path, $destination, Input::file('primary_image'), '288', '393', 'png');

            // $watermark = Image::make(public_path('WATER MARK.png'))->resize(576 , 786);
            // $img = Image::make($destination)->insert($watermark);
            // $img->save($destination, 100 , 'png');

            $path = public_path('website'.$ds.'images'.$ds.'products'.$ds.'thumb');
            $destination = public_path('website'.$ds.'images'.$ds.'products'.$ds.'thumb'.$ds.$primary_image);
            HelperController::upload_images($path, $destination, Input::file('primary_image'), '288', '393');

            // $watermark = Image::make(public_path('WATER MARK.png'))->resize(576 , 786);
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
                $imageSlug = HelperController::make_slug($product_price.rand(10, 100).'_'.str_replace(' ', '', Carbon::today()));
                $image_name = str_replace(' ', '', $imageSlug).'.'.$image->getClientOriginalExtension();

                ProductImage::create([
                    'image' => $image_name,
                    'product_id' => $productId,
                    'translation_id' => $transId,
                    'lang_id' => $lang_id,
                ]);

                $path = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'products');
                $destination = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'products'.DIRECTORY_SEPARATOR.$image_name);
                HelperController::upload_images($path, $destination, $image, '576', '786');

                // $watermark = Image::make(public_path('WATER MARK.png'))->resize(576 , 786);
                // $img = Image::make($destination)->insert($watermark);
                // $img->save($destination, 100 , 'png');
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

        $data = [
            'lang_id' => app()->getLocale(),
            // 'categories_id' => $categories[1],
            // 'category' => $categories[1],
            'status' => $request->shipping_category == null ? 0 : (isset($Product) ? $Product->status : 0),
            'views' => 0,
            'price' => $request->price,
            'max_order' => $request->max_order,
            'sale_price' => $request->sale_price,
            'cost' => $request->cost,
            'brand_id' => $request->brand_id,
            'model' => $request->model,
            'shipping' => isset($Product) ? $Product->shipping : 0,
            'shipping_category' => isset($Product) ? $Product->shipping_category : 0,
            'quantity' => $request->quantity,
            'ignore_quantity' => isset($request->ignore_quantity) ? $request->ignore_quantity : 0,
            'best_seller' => isset($request->best_seller) ? $request->best_seller : 0,
            'hot_deals' => isset($request->hot_deals) ? $request->hot_deals : 0,
            'deal_of_day' => isset($request->deal_of_day) ? $request->deal_of_day : 0,
            'deal_of_day_end' => $request->deal_of_day == 1 ? Carbon::now()->addDay(1) : null,
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
            'vendor_id' => Auth::id(),
            'weight_unit' => $request->weight_unit,
            'tall_unit' => $request->tall_unit,
            'short_url' => isset($Product) && $Product->short_url != null ? $Product->short_url : Str::random(50),
        ];

        // dd($data);
        return $data;
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
        Session::put(['user_id' => Auth::id()]);

        return Excel::download(new ProductsExport, 'products.xlsx');
        // return Excel::download(new ProductsExport(), 'products.tsv');
    }

    public function readFiles(Request $request)
    {
        $images = ProductImage::where('product_id', $request->id)->get();
        $directory = 'website/images/products';
        $files_info = [];
        $file_ext = ['image/png', 'image/jpg', 'image/jpeg', 'image/avif', 'image/webp', 'image/jfif'];

        foreach ($images as $files) {
            if (file_exists(public_path('website/images/products/'.$files->image))) {
                if (file_get_contents('https://souqelmlabes.coms.com/website/images/products/'.$files->image)) {
                    $extension = strtolower(File::mimeType(public_path('website/images/products/'.$files->image)));

                    if (in_array($extension, $file_ext)) { // Check file extension
                        $filename = File::name(public_path('website/images/products/'.$files->image));
                        $size = File::size(public_path('website/images/products/'.$files->image)); // Bytes
                        $sizeinMB = round($size / (1000 * 1024), 2); // MB

                        if ($sizeinMB <= 2) { // Check file size is <= 2 MB
                            $files_info[] = [
                                'id' => $files->id,
                                'name' => $filename,
                                'size' => $size,
                                'path' => 'data:'.$extension.';base64,'.base64_encode(file_get_contents('https://souqelmlabes.coms.coms.com/website/images/products/'.$files->image)),
                            ];
                        }
                    } else {
                        $files_info[] = $extension;
                    }
                }
            }
        }

        return response()->json($files_info);
    }

    public static function uploadImages(Request $request)
    {
        // dd($request->all());
        if (is_array($request->file)) {
            foreach ($request->file as $file) {
                $name = $file->getClientOriginalName();
                $imageSlug = HelperController::make_slug($name.rand(10, 100).'_'.str_replace(' ', '', Carbon::today()));
                $image_name = str_replace(' ', '', $imageSlug).'.'.$file->getClientOriginalExtension();

                $productId = $request->random_id;

                $data = [
                    // 'image' => $image_name,
                    'image' => str_replace(' ', '', $name),
                    'product_id' => $productId,
                    'translation_id' => $productId,
                    'lang_id' => app()->getLocale(),
                ];

                $test = ProductImage::where($data)->exists();
                if ($test == false) {
                    ProductImage::create($data);

                    $path = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'products');
                    // $destination = public_path('website' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'products' . DIRECTORY_SEPARATOR . $image_name);
                    $destination = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'products'.DIRECTORY_SEPARATOR.str_replace(' ', '', $name));
                    HelperController::upload_images($path, $destination, $file, '576', '786');

                    // $watermark = Image::make(public_path('WATER MARK.png'))->resize(576 , 786);
                    // $img = Image::make($destination)->insert($watermark);
                    // $img->save($destination, 100 , 'png');

                    $path = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'products'.DIRECTORY_SEPARATOR.'thumb');
                    $destination = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'products'.DIRECTORY_SEPARATOR.'thumb'.DIRECTORY_SEPARATOR.str_replace(' ', '', $name));
                    HelperController::upload_images($path, $destination, $request->file('file'), '576', '786');

                    // $watermark = Image::make(public_path('WATER MARK.png'))->resize(576 , 786);
                    // $img = Image::make($destination)->insert($watermark);
                    // $img->save($destination, 100 , 'png');
                }
            }
        } else {
            $name = $request->file('file')->getClientOriginalName();
            $imageSlug = HelperController::make_slug($name.rand(10, 100).'_'.str_replace(' ', '', Carbon::today()));
            $image_name = str_replace(' ', '', $imageSlug).'.jpg';

            // $productId = Str::random(80);
            $productId = $request->random_id;

            $data = [
                // 'image' => $image_name,
                'image' => $image_name,
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

                // $watermark = Image::make(public_path('WATER MARK.png'))->resize(576 , 786);
                // $img = Image::make($destination)->insert($watermark);
                // $img->save($destination, 100 , 'png');

                $path = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'products'.DIRECTORY_SEPARATOR.'thumb');
                // $destination = public_path('website' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'products' . DIRECTORY_SEPARATOR . 'thumb' . DIRECTORY_SEPARATOR . str_replace(' ', '' ,$name));
                $destination = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'products'.DIRECTORY_SEPARATOR.'thumb'.DIRECTORY_SEPARATOR.$image_name);
                HelperController::upload_images($path, $destination, $request->file('file'), '576', '250');

                // $watermark = Image::make(public_path('WATER MARK.png'))->resize(576 , 786);
                // $img = Image::make($destination)->insert($watermark);
                // $img->save($destination, 100 , 'png');
            }
        }

        return 'done';
    }
}
