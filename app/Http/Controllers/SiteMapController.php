<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\helper\helperController;
use App\Http\Controllers\helper\HelperController as HelperHelperController;
use App\Models\BlogTranslation;
use App\Models\CategoryTranslation;
use App\Models\ProductTranslation;
use App\Models\SiteMap;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class SiteMapController extends Controller
{
    public static function create_sitemap(Request $request)
    {
        // //// delete old data.
        siteMap::truncate();
        // dd(resource_path());
        // File::deleteDirectory('/home/izosw0ytauwy/public_html/mini-youtube.com/sitemap');

        // /////// create blogs sitemaps
        $path = HelperController::getResourcePath().'sitemap';

        if (! File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        $sitemap_id = SiteMap::where('category_id', '<>', '')
            ->where('lang_id', app()->getLocale())
            ->orderBy('id', 'desc')->first();

        if (isset($sitemap_id) && $sitemap_id != '') {
            $package = CategoryTranslation::where('category_id', '>', $sitemap_id->category_id)->skip(0)->take(4000)->where('lang_id', app()->getLocale())->orderby('id', 'asc')->get()->toArray();
        } else {
            $package = CategoryTranslation::skip(0)->take(4000)->where('lang_id', app()->getLocale())->orderby('id', 'asc')->get()->toArray();
        }

        $products = array_chunk($package, 400);
        $count_arrays = count($products);

        for ($i = 0; $i < $count_arrays; $i++) {
            $sitemap = siteMap::count();
            $count = $sitemap + 1;
            $name = 'sitemap_'.$count.'.xml';

            $products_sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
            $products_sitemap .= '<?xml-stylesheet type="text/xsl" href="'.env('APP_URL').'public/css/sitemap_css/main-sitemap.xsl"?>';
            $products_sitemap .= '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd http://www.google.com/schemas/sitemap-image/1.1 http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

            foreach ($products[$i] as $vid) {
                $replaced_title = HelperController::make_slug($vid['title']);
                $products_sitemap .= '<url>';
                $products_sitemap .= '<loc>https://souqelmlabes.com/'.app()->getLocale().'/products/'.$replaced_title.'</loc>';
                $products_sitemap .= '<changefreq>monthly</changefreq>';
                $products_sitemap .= '<priority>0.8</priority>';
                $products_sitemap .= '</url>';
            }

            $products_sitemap .= '</urlset>';

            File::put($path.'/'.$name, $products_sitemap);

            $insert_map = new siteMap;
            $insert_map->file_name = $name;
            $insert_map->category_id = $vid['id'];
            $insert_map->lang_id = app()->getLocale();
            $insert_map->save();
        }

        // //////// create blog sitemaps

        $sitemap_blog_id = siteMap::where('blog_id', '<>', '')
            ->where('lang_id', app()->getLocale())
            ->orderBy('id', 'desc')->first();

        if (isset($sitemap_blog_id) && $sitemap_blog_id != '') {
            $blog = BlogTranslation::where('blog_id', '>', $sitemap_blog_id->blog_id)->where('lang_id', app()->getLocale())->skip(0)->take(4000)->orderby('id', 'asc')->get()->toArray();
        } else {
            $blog = BlogTranslation::skip(0)->take(4000)->where('lang_id', app()->getLocale())->orderby('id', 'asc')->get()->toArray();
        }

        $blogs = array_chunk($blog, 2000);
        $count_arrays_blog = count($blogs);

        for ($i = 0; $i < $count_arrays_blog; $i++) {
            $sitemap = siteMap::count();
            $count = $sitemap + 1;
            $name = 'sitemap_'.$count.'.xml';

            $blog_sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
            $blog_sitemap .= '<?xml-stylesheet type="text/xsl" href="'.env('APP_URL').'"public/css/sitemap_css/main-sitemap.xsl"?>';
            $blog_sitemap .= '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd http://www.google.com/schemas/sitemap-image/1.1 http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

            foreach ($blogs[$i] as $blog) {
                $replaced_title = helperController::make_slug($blog['title']);

                $blog_sitemap .= '<url>';
                $blog_sitemap .= ' <loc>https://souqelmlabes.com/'.app()->getLocale().'/blog/'.$blog['id'].'/'.$replaced_title.'</loc>';
                $blog_sitemap .= ' <changefreq>monthly</changefreq>';
                $blog_sitemap .= ' <priority>0.8</priority>';
                $blog_sitemap .= '</url>';
            }

            $blog_sitemap .= '</urlset>';

            File::put($path.'/'.$name, $blog_sitemap);

            $insert_map = new siteMap;
            $insert_map->file_name = $name;
            $insert_map->blog_id = $blog['id'];
            $insert_map->lang_id = app()->getLocale();
            $insert_map->save();
        }

        // //////// create products sitemaps

        $sitemap_product_id = siteMap::where('product_id', '<>', '')
            ->where('lang_id', app()->getLocale())
            ->orderBy('id', 'desc')->first();

        if (isset($sitemap_product_id) && $sitemap_product_id != '') {
            $product = ProductTranslation::where('product_id', '>', $sitemap_product_id->product_id)->where('lang_id', app()->getLocale())->skip(0)->take(4000)->orderby('id', 'asc')->get()->toArray();
        } else {
            $product = ProductTranslation::skip(0)->take(4000)->where('lang_id', app()->getLocale())->orderby('id', 'asc')->get()->toArray();
        }

        $products = array_chunk($product, 2000);
        $count_arrays_product = count($products);

        for ($i = 0; $i < $count_arrays_product; $i++) {
            $sitemap = siteMap::count();
            $count = $sitemap + 1;
            $name = 'sitemap_'.$count.'.xml';

            $product_sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
            $product_sitemap .= '<?xml-stylesheet type="text/xsl" href="'.env('APP_URL').'"public/css/sitemap_css/main-sitemap.xsl"?>';
            $product_sitemap .= '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd http://www.google.com/schemas/sitemap-image/1.1 http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

            foreach ($products[$i] as $product) {
                $replaced_title = helperController::make_slug($product['title']);

                $product_sitemap .= '<url>';
                $product_sitemap .= ' <loc>https://souqelmlabes.com/'.app()->getLocale().'/product/'.$product['product_id'].'/'.$replaced_title.'</loc>';
                $product_sitemap .= ' <changefreq>monthly</changefreq>';
                $product_sitemap .= ' <priority>0.8</priority>';
                $product_sitemap .= '</url>';
            }

            $product_sitemap .= '</urlset>';

            File::put($path.'/'.$name, $product_sitemap);

            $insert_map = new siteMap;
            $insert_map->file_name = $name;
            $insert_map->product_id = $product['id'];
            $insert_map->lang_id = app()->getLocale();
            $insert_map->save();
        }

        return 'done';
    }

    // //////////////////////////////////////////////////////////////
    public function index(Request $request)
    {
        // //////// create index file.
        $sitemap = siteMap::all();

        $index = '<?xml version="1.0" encoding="UTF-8"?>';
        $index .= '<?xml-stylesheet type="text/xsl" href="'.env('APP_URL').'"public/css/sitemap_css/main-sitemap.xsl"?>';
        $index .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($sitemap as $maps) {
            $index .= '<sitemap>';
            $index .= '<loc>https://souqelmlabes.com/'.app()->getLocale().'/sitemap/'.$maps->file_name.'</loc>';
            $index .= '</sitemap>';
        }

        $index .= '</sitemapindex>';

        $response = Response::make($index);
        $response->header('Content-Type', 'text/xml');

        return $response;
    }

    public function view_sitemap(Request $request)
    {
        $path = HelperHelperController::getResourcePath().'sitemap';
        $sitemap = siteMap::where('file_name', $request->name)->firstOrFail();

        if (isset($sitemap->file_name) && $sitemap->file_name != '') {
            if (file_exists($path.'/'.$sitemap->file_name)) {
                return response(file_get_contents($path.'/'.$sitemap->file_name), 200, [
                    'Content-Type' => 'application/xml',
                ]);
            }
        }

        return redirect(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::localizeURL('/'));
    }
}
