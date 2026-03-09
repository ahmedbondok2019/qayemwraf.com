<?php

namespace App\Http\Controllers;

use App\Exports\BrandsExport;
use App\Exports\CategoryExport;
use App\Exports\ProductsCategoryExport;
use App\Exports\ProductsExport;
use App\Exports\ProductsExportNew;
use App\Exports\ProductsGoogleExport;
use App\Exports\VendorsUsersExport;
use App\Http\Controllers\helper\HelperController;
use App\Http\Requests\home\ContactUsRequest;
use App\Models\About;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CustomerMessage;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\GalleryLink;
use App\Models\GalleryVideo;
use App\Models\Keyword;
use App\Models\Newsletter;
use App\Models\Offer;
use App\Models\OrderDetail;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductTranslation;
use App\Models\Rating;
use App\Models\Slider;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class WelcomeController extends WebController
{
    public function index()
    {
        $data['sliders'] = Slider::whereHas('SliderTranslation')->orderByDesc('id')->get();
        // $product = ProductCategory::pluck('product_id');
        $product = Product::pluck('id');
        $active_products = Product::active()->pluck('id');
        $Cat = ProductCategory::whereIn('product_id', $active_products)->pluck('category_id')->unique();
        $data['top_categories'] = Category::whereNotNull('show_category')->static()
            ->where('parent_id','!=', 0)->whereHas('CategoryTranslation')->get();
        // $data['home_categories'] = Category::whereNotNull('show_category')->where('parent_id', 0)->static()->whereIN('id', $Cat)->whereHas('CategoryTranslation')->limit(16)->get();
        $data['home_categories'] = Category::whereNotNull('show_category')
                                            ->where('parent_id', '!=', 0)
                                            ->whereIn('id', $Cat)
                                            ->whereHas('CategoryTranslation')
                                            ->inRandomOrder()
                                            ->limit(18)
                                            ->get();
        $data['static_category'] = Category::whereNotNull('show_category')->where('static', 1)->whereHas('CategoryTranslation')->first();

        $data['subcategories'] = Category::whereNotNull('show_category')->static()
            ->where('parent_id','!=', 0)->whereHas('CategoryTranslation')->get();
        $data['categories'] = Category::whereNotNull('show_category')->static()
            ->where('parent_id', 0)
            ->orWhere('parent_id',null)
            ->whereHas('CategoryTranslation')->get();

        // $categories = Category::whereIN('id', $productCat)->whereHas('CategoryTranslation')->pluck('id');
        // $orders = DB::table('order_details')
        //     ->select(DB::raw('count(*) as product_id'))
        //     ->groupBy('product_id')
        //     ->pluck('product_id');
        $orders = OrderDetail::groupBy('product_id')->pluck('product_id');

        $data['best'] = Product::active()->whereIn('id', $orders)
            // ->whereDate('best_seller_start' , '<=' , Carbon::now())
            // ->whereDate('best_seller_end', '>=' , Carbon::now())
            ->whereHas('translations')->inRandomOrder()->limit(15)->get();
        // $data['flash'] = Product::active()
        //     ->whereDate('deal_of_day_start' , '<=' , Carbon::now())
        //     ->whereDate('deal_of_day_end', '>=' , Carbon::now())
        //     ->whereHas('translations')->limit(15)->orderBy('deal_of_day_end')->get();
        $flashdeals = ProductsController::getFlashSale();
        // $data['days'] = $flashdeals[1];
        // $data['days_route'] = $flashdeals[3];
        $data['flash'] = Product::active()
            ->whereIn('id', explode(',', $flashdeals[0]))
            ->whereHas('translations')
            ->whereHas('categories')
            ->paginate(28);

        $data['products'] = Product::active()->whereIn('id', $product)->whereHas('translations')->limit(15)->orderByDesc('id')->get();
        $data['one_product'] = Product::active()->whereIn('id', $product)->whereHas('translations')->inRandomOrder()->first();
        $data['offers'] = Offer::whereHas('offer_translations', function ($query) {
            $query->where('position', 2);
        })->get();
        $data['blogs'] = Blog::whereHas('BlogTranslation')->limit(3)->latest()->get();
        $data['brands'] = Brand::whereHas('BrandTranslations')->where('status', 1)->get();
        $data['about'] = About::whereHas('AboutTranslation')->whereHas('AboutImages')->first();

        return view('dashboard.user.home', $data);
    }

    public function change_lang(Request $request)
    {
        config(['app.country' => $request->country]);
        App::setLocale($request->lang);

        return redirect()->route('welcome');
        // return redirect(\LaravelLocalization::getLocalizedURL($request->lang, null, [], true));
    }

    public function related_products($id)
    {
        return Product::active()->where('category', $id)->whereHas('translations')->limit(5)->get();
    }

    public function getProductSuggestions(Request $request)
    {
        $query = $request->keywords;
        // $category = $request->header_category;
        $products = ProductTranslation::where('title', 'LIKE', "%{$query}%");
        $activeProducts = Product::active()->pluck('id');
        // if($category != '' || $category != null){
        //     $productCat = ProductCategory::where('category_id', $category)->pluck('product_id');
        //     $products = $products->whereIn('product_id', $productCat);
        // }
        $products = $products->where('lang_id', app()->getLocale())->whereIn('product_id', $activeProducts)->get();

        $theKeyword = HelperController::make_slug($query);
        if (! empty($theKeyword) && strlen($theKeyword) > 3) {
            Keyword::create([
                'keyword' => $theKeyword,
            ]);
        }

        return response()->json([
            'data' => view('layouts.product_suggestions', ['products' => $products])->render(),
        ]);
    }

    public function about()
    {
        $data['about'] = About::whereHas('AboutTranslation')->with('AboutImages')->firstOrFail();

        return view('about', $data);
    }

    public function faqs()
    {
        $data['faqs'] = Faq::whereHas('FaqTranslation')->get();
        $data['Pages'] = Page::where('location', 1)->where('status', 1)->whereHas('PageTranslation')->get();

        return view('faqs', $data);
    }

    public function privacy()
    {
        // $data['terms'] = Setting::whereHas('FaqTranslation')->get();
        return view('privacy');
    }

    public function terms()
    {
        // $data['terms'] = Setting::whereHas('FaqTranslation')->get();
        return view('terms');
    }

    public function team()
    {
        $data['teams'] = Team::with('TeamTranslation')->with('TeamImages')->get();

        return view('team', $data);
    }

    public function gallery()
    {
        $data['galleries'] = Gallery::with('GalleryTranslation')->with('GalleryImages')->get();

        return view('gallery', $data);
    }

    public function gallery_details(Request $request)
    {
        $data['details'] = GalleryImage::where('gallery_id', $request->id)->get();
        $data['videos'] = GalleryVideo::where('gallery_id', $request->id)->get();
        $data['links'] = GalleryLink::where('gallery_id', $request->id)->get();

        return view('gallery', $data);
    }

    public function contact(Request $request)
    {
        $data = [];
        if (isset($request->keyword)) {
            $data['keyword'] = $request->keyword;
        }

        return view('contact', $data);
    }

    protected function verifyRecaptcha(Request $request)
    {
        if (! HelperController::verify($request->input('g-recaptcha-response'))) {
            throw ValidationException::withMessages([
                'g-recaptcha-response' => ['تحقق جوجل مطلوب'],
            ]);
        }
    }

    public function sendContact(ContactUsRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'contact_email' => 'required|email|max:255',
            'contact_name' => 'required|string',
            'contact_phone' => 'required|string',
            // 'contact_subject' => 'required|string',
            'contact_message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(
                ['msg' => '<div class="alert alert-danger">'.__('website.All_Required_Fields').'</div>']
            );
        }
        $test = CustomerMessage::where('contact_email', $request->contact_email)
            ->where('contact_message', $request->message)
            ->where('contact_name', $request->contact_name)
            // ->where('contact_subject', $request->contact_subject)
            ->first();
        if (empty($test)) {
            $inputs = Arr::except($request->all(), ['g_recaptcha_response']);
            CustomerMessage::create($inputs);

            return response()->json(['msg' => '<div class="alert alert-success">'.__('website.Sent Successfully').'</div>']);
        } else {
            return response()->json(['msg' => '<div class="alert alert-danger">'.__('website.Duplicate_Fields').'</div>']);
        }
    }

    public function product_pdf($fileName = null)
    {
        if ($fileName != null && file_exists(public_path().'/website/uploads/pdf/'.$fileName)) {
            $file = public_path().'/website/uploads/pdf/'.$fileName;
            $headers = [
                'Content-Type: application/pdf',
            ];

            return response()->download($file, $fileName, $headers);
        } else {
            alert()->error('file not found', __('dashboard.attention'));

            return redirect()->back();
        }
    }

    public static function getLangWord($text = '')
    {
        // $text = "";
        switch ($text == '' ? app()->getLocale() : $text) {
            case 'ar':
                $text = 'العربية';
                break;
            case 'en':
                $text = 'English';
                break;
            case 'tr':
                $text = 'Türkçe';
                break;
            case 'de':
                $text = 'Deutsch';
                break;
            case 'id':
                $text = 'Bahasa-Indonesia';
                break;
        }

        return $text;
    }

    public static function getLangWordDash($text = '')
    {
        // $text = "";
        switch ($text == '' ? app()->getLocale() : $text) {
            case 'ar':
                $text = 'ع';
                break;
            case 'en':
                $text = 'E';
                break;
            case 'tr':
                $text = 'T';
                break;
            case 'de':
                $text = 'D';
                break;
            case 'id':
                $text = 'B';
                break;
        }

        return $text;
    }

    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['newsletter' => '<div class="alert alert-danger alert-dismissable"><a class="panel-close close" data-dismiss="alert">×</a><i class="fa fa-coffee"></i> check <strong> all inputs.</strong>.</div>']);
        }

        $test = Newsletter::where('email', $request->email)->first();
        if (empty($test)) {
            Newsletter::create($request->all());

            return response()->json(['newsletter' => '<div class="alert alert-success alert-dismissable"><a class="panel-close close" data-dismiss="alert">×</a><i class="fa fa-coffee"></i> Your email <strong> added successfully.</strong>.</div>']);
        } else {
            return response()->json(['newsletter' => '<div class="alert alert-danger alert-dismissable"><a class="panel-close close" data-dismiss="alert">×</a><i class="fa fa-coffee"></i> your email <strong> sent already no need to send again.</strong>.</div>']);
        }
    }

    public static function replace_lang_alias($alias)
    {
        switch ($alias) {
            case 'ar':
                return 'العربية';
            case 'en':
                return 'english';
            case 'tr':
                return 'Türkçe';
            case 'fr':
                return 'french';
            case 'id':
                return 'Bahasa Indonesia';
            case 'de':
                return 'deutsch';
        }
    }

    public static function getWelcomeTrans()
    {
        switch (app()->getLocale()) {
            case 'ar':
                return 'مرحبا';
            case 'en':
                return 'welcome';
            case 'tr':
                return 'Hoşgeldiniz';
            case 'fr':
                return 'bienvenu';
            case 'id':
                return 'selamat datang';
            case 'de':
                return 'willkommen';
        }
    }

    public function typeahead()
    {
        return view('typeahead');
    }

    public static function getRate($product_id)
    {
        $rating = 0;
        $result = Rating::select(DB::raw('AVG(rating) as rating'))
            ->where('product_id', $product_id)->get();
        $total_row = $result->Count();

        if ($total_row > 0) {
            foreach ($result as $row) {
                $rating = round($row->rating);
            }
        } else {
            $total_row = 0;
        }

        $output = '<ul>';
        $color = '';
        for ($count = 1; $count <= 5; $count++) {
            if ($count <= $rating) {
                $icon = '<i class="icon-star voted"></i>';
            } else {
                $icon = '<i class="icon-star-empty"></i>';
            }
            $output .= '<li title="'.$count.'" id="'.$row->id.'-'.$count.'" data-index="'.$count.'"  data-business_id="'.$row->id.'" data-rating="'.$rating.'" style="cursor:pointer;padding:0.1em !important;list-style: none;display: inline-block;font-size:22px;">'.$icon.'</li>';
        }
        $output .= '</ul>';

        return ['output' => $output, 'total_row' => $total_row];
    }

    public function exportBrands(Request $request)
    {
        return Excel::download(new BrandsExport, 'brands.xls', \Maatwebsite\Excel\Excel::XLS);
    }

    public function exportCategory(Request $request)
    {
        return Excel::download(new CategoryExport, 'category.xls', \Maatwebsite\Excel\Excel::XLS);
    }

    public function exportUsers(Request $request)
    {
        return Excel::download(new VendorsUsersExport, 'users.xlsx');
    }

    public function export_products(Request $request)
    {
        // return Excel::download(new ProductsExport(), 'products.csv');
        return Excel::download(new ProductsExportNew, 'products.xlsx');
    }

    public function exportCsv(Request $request)
    {
        // return Excel::download(new ProductsExport(), 'products.csv');
        return Excel::download(new ProductsExport, 'products.xlsx');
    }

    public function exportCsvGoogle(Request $request)
    {
        // return Excel::download(new ProductsGoogleExport(), 'products.csv');
        return Excel::download(new ProductsGoogleExport, 'products.tsv');
    }

    public function export_all(Request $request)
    {

        // $categories =Category::whereHas('CategoryTranslation')->get();
        // foreach ($categories as $category){
        //     echo '<tr>';
        //         echo '<td>'.  $category->id .'</td>';
        //         echo '<td>'.  $category->CategoryTranslation->title .'</td>';
        //         echo '<td>'.  'https://souqelmlabes.com/ar/products/' . \App\Http\Controllers\helper\HelperController::make_slug(\Illuminate\Support\Str::limit($category->CategoryTranslation->title, '147', '...')) .'</td>';
        //         echo '<td> تصنيف </td>';
        //         echo '</td>';
        // }

        return Excel::download(new ProductsCategoryExport, 'products.xlsx');
    }

    public function testCode()
    {
        $image = QrCode::format('png')
            ->size(500)
            ->margin(10)
            ->generate(env('APP_URL').'ar');
        $output_file = 'img-'.time().'.png';
        Storage::disk('MyDisk')->put($output_file, $image); // storage/app/public/img/qr-code/img-1557309130.png
        $path = public_path('website/images/BarCode/').\Illuminate\Support\Carbon::now()->format('M-Y').'/';
        $toRemove = HelperController::getResourcePath().'public/';
        $url = str_replace($toRemove, '', $path);
        $fullUrl = env('APP_URL').$url.$output_file;

        return $fullUrl;

        $text = 'رمز التحقق للتسجيل في '.env('APP_NAME').' هو : 9999';

        return htmlentities(urlencode($text));
    }

    public function qr_code()
    {
        $image = QrCode::format('png')
            ->size(500)
            ->margin(0)
            ->generate(env('APP_URL').'ar');
        // $output_file = 'img-' . time() . '.png';
        $output_file = 'img-1700889728.png';
        Storage::disk('MyDisk')->put($output_file, $image); // storage/app/public/img/qr-code/img-1557309130.png
        // $path = public_path('website/images/BarCode/') . \Illuminate\Support\Carbon::now()->format('M-Y') . '/';
        $path = public_path('website/images/BarCode/Nov-2023/');
        $toRemove = HelperController::getResourcePath().'public/';
        $url = str_replace($toRemove, '', $path);
        $fullUrl = env('APP_URL').$url.$output_file;

        $image = QrCode::format('png')
            ->size(500)
            ->margin(0)
            ->generate('https://play.google.com/store/apps/details?id=com.madzun_store.madzun_store');
        // $output_file = 'img-' . time() . '.png';
        $output_file = 'img-play-google.png';
        Storage::disk('MyDisk')->put($output_file, $image); // storage/app/public/img/qr-code/img-1557309130.png
        // $path = public_path('website/images/BarCode/') . \Illuminate\Support\Carbon::now()->format('M-Y') . '/';
        $path = public_path('website/images/BarCode/Nov-2023/');
        $toRemove = HelperController::getResourcePath().'public/';
        $url = str_replace($toRemove, '', $path);
        $fullUrl = env('APP_URL').$url.$output_file;

        return "<table>
            <tr><td>
                <img src='https://souqelmlabes.com/website/images/BarCode/Nov-2023/img-1700889728.png'>
                <h2 style='text-align: center;'>Website</h2></td>
                <td><img src='https://souqelmlabes.com/website/images/BarCode/Nov-2023/img-play-google.png'>
                <h2 style='text-align: center;'>google Play</h2></td>
            </tr>
            </table>
        ";

        $text = 'رمز التحقق للتسجيل في '.env('APP_NAME').' هو : 9999';

        return htmlentities(urlencode($text));
    }
}
