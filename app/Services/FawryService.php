<?php

namespace App\Services;

use App\Models\LogApi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class FawryService
{
    public static function fawryPay(Request $request, $create, $OrderID)
    {
        $connectedString = ''.$OrderID->id.Auth::id().
            // $connectedString = "" . $OrderID->id . Auth::id() .
            str_replace('\/', '/', json_encode(LaravelLocalization::localizeUrl('fawryCallback'))).
             $create['fawryData'].
              '';

        $connectedString = str_replace('"', '', $connectedString);

        $signature = hash('sha256', str_replace('"', '', $connectedString));
        $yourdate = Carbon::tomorrow();
        $stamp = strtotime($yourdate); // get unix timestampa
        $time_in_ms = $stamp * 1000;

        $body = [
            'merchantCode' => '==',
            // 'merchantCode' => "",
            'merchantRefNum' => $OrderID->id,
            'paymentExpiry' => $time_in_ms,
            'customerProfileId' => Auth::id(),
            'customerMobile' => $create['address']->phone,
            'customerName' => $create['address']->name.' '.$create['address']->name,
            'customerEmail' => $create['address']->email ?? '',
            'amount' => number_format((float) $OrderID->total, 2, '.', ''),
            'currencyCode' => 'EGP',
            'chargeItems' => $create['fawryItems'],
            'signature' => $signature,
            'returnUrl' => LaravelLocalization::localizeUrl('fawryCallback'),
        ];

        $body = str_replace('\/', '/', json_encode($body));
        $curl = curl_init();

        LogApi::create([
            'notification' => 'before_fawry_go',
            'url' => $request->url(),
            'body' => $body,
            // 'signature_before' => $connectedString,
            // 'signature_after' => $signature,
        ]);

        curl_setopt_array($curl, [
            // CURLOPT_URL => 'https://atfawry.fawrystaging.com/fawrypay-api/api/payments/init',
            CURLOPT_URL => 'https://atfawry.com/fawrypay-api/api/payments/init',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
            ],
        ]);
        $response = curl_exec($curl);
        curl_close($curl);

        LogApi::create([
            'url' => $request->url(),
            'body' => $body,
            'signature_before' => $connectedString,
            'signature_after' => $signature,
        ]);

        return $response;
    }
}
