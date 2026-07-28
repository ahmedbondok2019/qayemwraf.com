<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Governorate;
use App\Models\City;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Traits\ApiPaginationTrait;
use App\Http\Resources\ApiV1\CountryResource;

/**
 * @group 21. المناطق والدول (Locations)
 * 
 * يتولى جلب قائمة الدول المتاحة، المحافظات التابعة لدولة، والمدن التابعة لمحافظة.
 */
class LocationController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

    /**
     * جلب قائمة جميع الدول المتاحة
     * 
     * يعيد قائمة بجميع الدول النشطة في النظام.
     */
    public function countries()
    {
        $countries = Country::active()->with('translation')->orderBy('sort_order')->get();

        return $this->successResponse(CountryResource::collection($countries));
    }

    /**
     * جلب المحافظات التابعة لدولة محدودة
     * 
     * يعيد قائمة المحافظات النشطة التابعة لدولة محددة برقم الدولة (country_id).
     */
    public function governorates($country_id)
    {
        $governorates = Governorate::where('country_id', $country_id)->active()->with('translation')->get();

        return $this->successResponse($governorates->map(function($gov) {
            return [
                'id' => $gov->id,
                'name' => $gov->name,
            ];
        }));
    }

    /**
     * جلب المدن التابعة لمحافظة محددة
     * 
     * يعيد قائمة المدن النشطة التابعة لمحافظة محددة برقم المحافظة (governorate_id).
     */
    public function cities($governorate_id)
    {
        $cities = City::where('governorate_id', $governorate_id)->active()->with('translation')->get();

        return $this->successResponse($cities->map(function($city) {
            return [
                'id' => $city->id,
                'name' => $city->name,
            ];
        }));
    }
}
