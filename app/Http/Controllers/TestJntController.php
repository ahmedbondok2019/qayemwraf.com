<?php

namespace App\Http\Controllers;

use App\Services\JntService;
use Illuminate\Http\Request;

class TestJntController extends Controller
{
    public function testOrder()
    {
        $jnt = new JntService();

        // نسخة جاهزة من بيانات الطلب مصححة
        $orderData = [
            "txlogisticId" => "43531454390",
            "expressType" => "express",
            "orderType" => "2",
            "serviceType" => "01",
            "deliveryType" => "03",
            "payType" => "PP_PM",
            "sender" => [
                "name" => "AAAAAA AAAAAAAAAA AAAAA",
                "company" => "0001",
                "postCode" => "06060",
                "mailBox" => "AAAAAA@LIVERPOOL.COM.MX",
                "mobile" => "59999999",
                "phone" => "59999999",
                "countryCode" => "MEXICO",
                "prov" => "CIUDAD DE MEXICO",
                "city" => "CUAUHTEMOC",
                "area" => "COLONIA CENTRO",
                "address" => "VENUSTIANO CARRANZA"
            ],
            "receiver" => [
                "name" => "OcAAAAAR AAAAA AAAA PaEÑA BEARNAL",
                "company" => "",
                "postCode" => "05348",
                "mailBox" => "AAAAAAA@MAIL.COM.MX",
                "mobile" => "599999999",
                "phone" => "599999999",
                "countryCode" => "MEXICO",
                "prov" => "CDMX",
                "city" => "CUAJIMALPA",
                "area" => "LOMAS DE SANTA FE",
                "address" => "Calle: MARIO AAAA AAAAAAA AAAAAA NumEx: 230 NumInt: AAAAA 233 AAAAAA Entre Calles: PROL PASEO DAE REFORMA Y VASCUO DE QUIROGA,"
            ],
            "sendStartTime" => "",
            "sendEndTime" => "2023-09-18 18:36:57",
            "goodsType" => "bm000006",
            "length" => "10",
            "width" => "10",
            "height" => "10",
            "weight" => "1",
            "totalQuantity" => "1",
            "itemsValue" => "0",
            "priceCurrency" => "MX",
            "remark" => "4353454390P0047323236268",
            "items" => [
                [
                    "itemType" => "bm000006",
                    "itemName" => "",
                    "itemValue" => "0",
                    "priceCurrency" => "",
                    "desc" => "",
                    "itemUrl" => ""
                ]
            ],
            "operateType" => "1"
        ];

        // إرسال الطلب
        $response = $jnt->createOrder($orderData);

        // إعادة الرد
        if (isset($response['raw_body'])) {
            return $response['raw_body'];
        }

        return response()->json($response);
    }
}