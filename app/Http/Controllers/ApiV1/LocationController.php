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
 * @group Locations
 * 
 * APIs for retrieving countries, governorates, and cities.
 */
class LocationController extends Controller
{
    use ApiResponseTrait, ApiPaginationTrait;

    /**
     * Get All Countries
     * 
     * Returns a list of all active countries.
     */
    public function countries()
    {
        $countries = Country::active()->with('translation')->orderBy('sort_order')->get();

        return $this->successResponse(CountryResource::collection($countries));
    }

    /**
     * Get Governorates by Country
     * 
     * Returns a list of governorates for a specific country.
     * 
     * @urlParam country_id int required The ID of the country. Example: 1
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
     * Get Cities by Governorate
     * 
     * Returns a list of cities for a specific governorate.
     * 
     * @urlParam governorate_id int required The ID of the governorate. Example: 1
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
