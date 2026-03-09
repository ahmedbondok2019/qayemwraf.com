<?php

namespace App\Http\Controllers\helper;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\AreaTranslation;
use App\Models\City;
use App\Models\CityTranslation;
use App\Models\Zone;
use App\Models\ZoneTranslation;

class bostaController extends Controller
{
    public static function login()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://app.bosta.co/api/v2/users/login',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => "{\n  \"email\": \"notification@souqelmlabes.com\",\n  \"password\": \"souqelmlabes2244$@\"\n}",
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            dd('cURL Error #:'.$err);
        }

        return json_decode($response);
    }

    public static function getLoginData()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://app.bosta.co/api/v2/users/login',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => "{\n  \"email\": \"notification@souqelmlabes.coms.coms.coms.com\",\n  \"password\": \"souqelmlabes2244$@\"\n}",
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            dd('cURL Error #:'.$err);
        }

        return json_decode($response)->data->user->businessAdminInfo->businessId;
    }

    public static function createBussines($token, $vendor)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://app.bosta.co/api/v2/businesses',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => "{\n  \"name\": \" . $vendor->name . \",\n  \"industry\": \"Books, Arts and Media\",\n  \"monthlyShipmentVolume\": \"PRO_1\",\n  \"salesChannel\": [\n    \"Facebook Shop\",\n    \"Instagram\"\n  ]\n}",
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: '.$token,
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo 'cURL Error #:'.$err;
        } else {
            return $response;
        }
    }

    public static function createBussinesAddress($token, $vendor)
    {
        // $districtId = Zone::where('parent_id', '23')->first()->bostaDistrictId;
        $districtId = Zone::where('parent_id', $vendor->city_id)->first()->bostaDistrictId;
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://app.bosta.co/api/v2/pickup-locations',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => "{\n  \"address\": {\n    \"districtId\": \"$districtId\",\n    \"firstLine\": \"$vendor->address\"\n  },\n  \"contacts\": [\n    {\n      \"firstName\": \"$vendor->name\",\n      \"isDefault\": \"true\",\n      \"lastName\": \"$vendor->name\",\n      \"phone\": \"$vendor->phone\"\n    }\n  ],\n  \"locationName\": \"$vendor->address\"\n}",
            CURLOPT_HTTPHEADER => [
                'Authorization: '.$token,
                'Content-Type: application/json',
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo 'cURL Error #:'.$err;
        }

        return $response;
    }

    public static function pickup_locations($token)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'http://app.bosta.co/api/v2/pickup-locations',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Authorization: '.$token,
                'Content-Type: application/json',
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo 'cURL Error #:'.$err;
        }

        return json_decode($response);
    }

    public static function cities()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://app.bosta.co/api/v2/cities?countryId=60e4482c7cb7d4bc4849c4d5',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer undefined',
                'Content-Type: application/json',
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo 'cURL Error #:'.$err;
        }

        return json_decode($response)->data->list;
    }

    public static function getDistrictId($token, $cityId)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://app.bosta.co/api/v2/cities/'.$cityId.'/districts',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Authorization: '.$token,
                'Content-Type: application/json',
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo 'cURL Error #:'.$err;
        }

        return json_decode($response);
    }

    public static function getAllDistricts($token)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://app.bosta.co/api/v2/cities/getAllDistricts?countryId=60e4482c7cb7d4bc4849c4d5',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Authorization: '.$token,
                'Content-Type: application/json',
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo 'cURL Error #:'.$err;
        }

        return json_decode($response);
    }

    public static function createAllData($token)
    {
        $getAllDistricts = bostaController::getAllDistricts($token);
        foreach ($getAllDistricts->data as $District) {

            $area = Area::where('_id', $District->cityId)->exists();
            if (! $area) {
                $area = Area::create([
                    'lang_id' => 'ar',
                    '_id' => $District->cityId,
                    'code' => $District->cityCode,
                ]);

                AreaTranslation::create([
                    'area_id' => $area->id,
                    'title' => $District->cityOtherName,
                    'lang_id' => 'ar',
                ]);
                AreaTranslation::create([
                    'area_id' => $area->id,
                    'title' => $District->cityName,
                    'lang_id' => 'en',
                ]);

                foreach ($District->districts as $districts) {

                    $city = self::createCity($districts->zoneId, $area->id, 'ar');
                    if ($city) {
                        self::createCityTrans($city->id, $districts->zoneOtherName, $area->id, 'ar');
                        self::createCityTrans($city->id, $districts->zoneName, $area->id, 'en');

                        $zone = self::createZone(
                            $area->id, $city->id, 'ar', $districts->districtId,
                            $districts->pickupAvailability, $districts->dropOffAvailability
                        );
                        if ($zone) {
                            self::createZoneTrans($zone->id, $districts->districtOtherName, $city->id, 'ar');
                            self::createZoneTrans($zone->id, $districts->districtName, $city->id, 'en');
                        }
                    }
                }
            }
        }

        return $getAllDistricts;
    }

    public static function createCity($zoneId, $areaId, $lang)
    {
        $test = City::where([
            'parent_id' => $areaId,
            'bostaZoneId' => $zoneId,
            'lang_id' => $lang,
        ])->exists();

        if (! $test) {
            return City::create([
                'parent_id' => $areaId,
                'bostaZoneId' => $zoneId,
                'lang_id' => $lang,
            ]);
        }

        return null;
    }

    public static function createCityTrans($cityId, $zoneOtherName, $areaId, $lang)
    {
        $test = CityTranslation::where([
            'city_id' => $cityId,
            'title' => $zoneOtherName,
            'parent_id' => $areaId,
            'lang_id' => $lang,
        ])->exists();

        if (! $test) {
            CityTranslation::create([
                'city_id' => $cityId,
                'title' => $zoneOtherName,
                'parent_id' => $areaId,
                'lang_id' => $lang,
            ]);
        }
    }

    public static function createZone($areaId, $cityId, $lang, $districtId, $pickupAvailability, $dropOffAvailability)
    {
        $test = Zone::where([
            'area_id' => $areaId,
            'parent_id' => $cityId,
            'lang_id' => $lang,
            'bostaDistrictId' => $districtId,
            'pickupAvailability' => $pickupAvailability,
            'dropOffAvailability' => $dropOffAvailability,
        ])->exists();

        if (! $test) {
            return Zone::create([
                'area_id' => $areaId,
                'parent_id' => $cityId,
                'lang_id' => $lang,
                'bostaDistrictId' => $districtId,
                'pickupAvailability' => $pickupAvailability,
                'dropOffAvailability' => $dropOffAvailability,
            ]);
        }

        return null;
    }

    public static function createZoneTrans($zoneId, $districtOtherName, $cityId, $lang)
    {
        $test = ZoneTranslation::where([
            'zone_id' => $zoneId,
            'title' => $districtOtherName,
            'parent_id' => $cityId,
            'lang_id' => $lang,
        ])->exists();

        if (! $test) {
            ZoneTranslation::create([
                'zone_id' => $zoneId,
                'title' => $districtOtherName,
                'parent_id' => $cityId,
                'lang_id' => $lang,
            ]);
        }
    }
}
