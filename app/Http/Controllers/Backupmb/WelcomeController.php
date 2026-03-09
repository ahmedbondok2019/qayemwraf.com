<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\CategoryTranslation;
use App\Models\OptionTranslation;
use App\Models\Product;
use App\Models\ProductTranslation;
use App\Models\Setting;
use Illuminate\Http\Request;

class WelcomeController extends ApiController
{
    use ApiResponseTrait;

    public function welcome(Request $request)
    {
        $settings = Setting::first();

        parse_str(parse_url($settings->welcome_video, PHP_URL_QUERY), $my_array_of_vars);
        $videoId = $my_array_of_vars['v'];

        parse_str(parse_url($settings->learn_video, PHP_URL_QUERY), $my_array_of_vars);
        $secondVideoId = $my_array_of_vars['v'];

        $data = [
            'video_id' => $videoId,
            'second_video_id' => $secondVideoId,
            'slug' => $settings->app_meta_title_ar,
            'description' => strip_tags($settings->welcome_video_desc_ar),
        ];

        return $this->NewApiResponse($data, '', 'true', '200');
    }

    public function settings(Request $request)
    {
        $settings = Setting::first();

        parse_str(parse_url($settings->learn_video, PHP_URL_QUERY), $my_array_of_vars);
        // echo $my_array_of_vars['v'];
        // Output: ds-jXV1Tbn0
        $videoId = $my_array_of_vars['v'];

        $data = [
            'video_id' => $videoId,
        ];

        return $this->NewApiResponse($data, '', 'true', '200');
    }

    public function options(Request $request)
    {
        $options = OptionTranslation::where('lang_id', app()->getLocale())->select('option_id as id', 'title as text')->get();
        $data = [
            'results' => $options,
            'pagination' => [
                'more' => false,
            ],
        ];

        return response()->json($data);
    }

    public function product_categories(Request $request)
    {
        // احصل على جميع التصنيفات (بما فيها الفروع)
        $categories = CategoryTranslation::where('lang_id', app()->getLocale());

        // إذا كان هناك بحث
        if ($request->filled('search')) {
            $categories = $categories->where('title', 'like', '%'.$request->search.'%');
        }

        // إذا كنت تريد تصفية حسب IDs محددة (اختياري)
        if ($request->filled('id')) {
            $ids = array_filter(explode(',', $request->id), fn ($v) => ! empty($v));
            $categories = $categories->whereIn('category_id', $ids);
        }

        $categories = $categories->select('category_id as id', 'title as text')->get();

        return response()->json([
            'results' => $categories,
            'pagination' => ['more' => false],
        ]);
    }

    public function related_products(Request $request)
    {
        if (isset($request->id)) {
            $rel = array_filter(explode(',', $request->related_products), fn ($value) => ! is_null($value) && $value !== '');
            $relate = array_unique($rel);
        }

        $parents = Product::query();
        if (isset($request->id)) {
            $parents = $parents->whereIn('id', $relate);
        }
        $parents = $parents->pluck('id');

        $related = ProductTranslation::where('lang_id', app()->getLocale())
            ->whereIn('product_id', $parents);
        if (isset($request->search)) {
            $related = $related->where('title', 'like', '%'.$request->search.'%');
        }
        $related = $related->select('product_id as id', 'title as text')->get();

        $data = [
            'results' => $related,
            'pagination' => [
                'more' => false,
            ],
        ];

        return response()->json($data);
    }
}
