<?php

namespace App\Providers;

use App\Models\Advertisement;
use App\Models\Blog;
use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\Country;
use App\Models\Currency;
use App\Models\CurrencyTranslation;
use App\Models\Setting;
use App\Models\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        JsonResource::withoutWrapping();

        if(Schema::hasTable('settings')){
            $setting = Setting::first() ?? new Setting();
            $popupAds = Schema::hasTable('advertisements') 
                ? Advertisement::where('location', 'popup')->active()->get() 
                : collect();
            View::share([
                'Setting' => $setting,
                'popupAds' => $popupAds,
                'Pages' => Schema::hasTable('pages') ? Page::active()->with('translation')->get() : collect(),
            ]);
        }
        // $parents = Category::whereNotNull('show_category')->pluck('parent_id')->whereNotNull('show_category');
        // $currency = Currency::where('status', 1)->first();
        // $currency_trans = CurrencyTranslation::where('currency_id', $currency->id)->where('lang_id', app()->getLocale())->first();
        // $rate = $currency->rate;

        View::share([
            // 'Categories' => CategoryTranslation::where('lang_id', app()->getLocale())->whereIn('category_id', $parents)->get(),
            // 'search_categories' => Category::whereNotNull('show_category')->whereHas('CategoryTranslation')->whereNotIn('id', $parents)->get(),
            // 'Currency' => $currency_trans,
            // 'currency' => $currency,
            // 'countries' => Country::where('status', 1)->get(),
            // // 'childs' => Category::where('parent_id', 0)->with('childs')->whereHas('CategoryTranslation')->get(),
            // 'rate' => $rate,
            // 'arabic' => \App\Http\Controllers\helper\HelperController::getArabicLangs(),
            // 'footer_blogs' => Blog::whereHas('BlogTranslation')->limit(5)->latest()->get(),
        ]);

        // Builder::macro('whereLike', function ($attributes, string $searchTerm) {
        //     $this->where(function (Builder $query) use ($attributes, $searchTerm) {
        //         foreach (Arr::wrap($attributes) as $attribute) {
        //             $query->when(
        //                 str_contains($attribute, '.'),
        //                 function (Builder $query) use ($attribute, $searchTerm) {
        //                     [$relationName, $relationAttribute] = explode('.', $attribute);

        //                     $query->orWhereHas($relationName, function (Builder $query) use ($relationAttribute, $searchTerm) {
        //                         $query->where($relationAttribute, 'LIKE', "%{$searchTerm}%");
        //                     });
        //                 },
        //                 function (Builder $query) use ($attribute, $searchTerm) {
        //                     $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
        //                 }
        //             );
        //         }
        //     });

        //     return $this;
        // });
    }
}
