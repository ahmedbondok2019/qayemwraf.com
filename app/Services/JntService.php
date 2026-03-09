<?php

namespace App\Services;

use App\Models\LogApi;
use Illuminate\Support\Facades\Http;

class JntService
{
    protected $apiAccount;
    protected $customerCode;
    protected $privateKey;
    protected $baseUrl;

    public function __construct()
    {

        $this->apiAccount   = config('services.jnt.api_account');
        $this->customerCode = config('services.jnt.customer_code');
        $this->privateKey   = config('services.jnt.private_key');
        $this->baseUrl      = config('services.jnt.base_url');
    }

    /**
     * Create Order
     */
    public function createOrder(array $orderData)
    {
        
        // 1️⃣ البيانات الأساسية المطلوبة من J&T
          $payload = [
        'customerCode' => $this->customerCode,
        'operateType' => 'CREATE', // أو '1' حسب المطلوب
        'orderType'    => '2',
        'serviceType'  => '01',
        'deliveryType' => '03',
        'expressType'  => 'express',
        'payType'      => 'PP_PM',
    ];

        $finalData = array_merge($payload, $orderData);

        // 2️⃣ bizContent (JSON بدون أي تعديل بعد كده)
        $bizContent = json_encode($finalData, JSON_UNESCAPED_UNICODE);

        // 3️⃣ حساب الـ digest (التوقيع الصحيح)
        $digest = base64_encode(
            md5($bizContent . $this->privateKey, true)
        );

        // 4️⃣ timestamp بالمللي ثانية
        $timestamp = (string) round(microtime(true) * 1000);
//         dd([
//     'bizContent' => $bizContent,
//     'digest'     => base64_encode(md5($bizContent . $this->privateKey, true)),
//     'apiAccount' => $this->apiAccount,
//     'timestamp'  => (string) round(microtime(true) * 1000),
// ]);

        // 5️⃣ إرسال الطلب
$response = Http::asForm()->withHeaders([
    'apiAccount' => $this->apiAccount,
    'digest'     => $digest,
    'timestamp'  => $timestamp,
    'timezone'   => 'GMT+3',
])->post($this->baseUrl, [
    'bizContent' => $bizContent
]);
        

        // 6️⃣ تسجيل الطلب
        LogApi::create([
            'url' => $this->baseUrl,
            'body' => json_encode([
                'request' => [
                    'headers' => [
                        'apiAccount' => $this->apiAccount,
                        'digest'     => $digest,
                        'timestamp'  => $timestamp,
                    ],
                    'bizContent' => $bizContent,
                ],
                'response' => $response->json(),
            ]),
            'userFireBaseTokens' => 'jnt_create_order',
            'fire_base_result'  => $response->body(),
        ]);

        return $response->json() ?: ['raw' => $response->body()];
    }

    /**
     * Track Order
     */
    public function trackOrder(string $billCode)
    {
        $url = 'https://api.jtjms-sa.com/jms/order/orderTrace';

        $bizContent = json_encode([
            'customerCode' => $this->customerCode,
            'billCode'     => $billCode,
        ], JSON_UNESCAPED_UNICODE);

        $digest = base64_encode(
            md5($bizContent . $this->privateKey, true)
        );

        $timestamp = (string) round(microtime(true) * 1000);

        $response = Http::withHeaders([
            'apiAccount' => $this->apiAccount,
            'digest'     => $digest,
            'timestamp'  => $timestamp,
            'timezone'   => 'GMT+3',
            'Content-Type' => 'application/json',
        ])->post($url, [
            'bizContent' => $bizContent
        ]);

        return $response->json() ?: ['raw' => $response->body()];
    }
}
