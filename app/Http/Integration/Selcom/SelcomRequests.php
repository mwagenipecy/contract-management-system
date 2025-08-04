<?php

namespace App\Http\Integration\Selcom;

use App\Http\Integration\Selcom\HttpHelper;
use App\Http\Integration\Selcom\Constants;


class SelcomRequests
{
    

    /**
     * @param array $data
     * @return array
     */
    public static function checkoutMinimal(array $data): array
    {
        return self::send($data,Constants::ENDPOINT_CHECKOUT_REQUEST);
    }

    public static function walletPayment(array $data): array
    {
        return self::send($data,Constants::ENDPOINT_WALLET_PAYMENT);
    }



    public static function send($data, $url){
        $authorization = base64_encode(Constants::API_KEY);
        $signed_fields = implode(',', array_keys($data));
        $timestamp = date('c');
        $digest = SelcomRequests::computeSignature($data, $signed_fields, $timestamp);
        
        return HttpHelper::send($url, $data, [
            "Content-type: application/json;charset=\"utf-8\"", "Accept: application/json", "Cache-Control: no-cache",
            "Authorization: SELCOM $authorization",
            "Digest-Method: HS256",
            "Digest: $digest",
            "Timestamp: $timestamp",
            "Signed-Fields: $signed_fields",
        ]);
    }

    public static function computeSignature($parameters, $signed_fields, $request_timestamp){
        $fields_order = explode(',', $signed_fields);
        $sign_data = "timestamp=$request_timestamp";
        foreach ($fields_order as $key) {
            $sign_data .= "&$key=".$parameters[$key];
        }
        //HS256 Signature Method
        return base64_encode(hash_hmac('sha256', $sign_data, Constants::API_SECRET, true));
    }

}