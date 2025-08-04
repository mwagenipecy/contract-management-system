<?php

namespace App\Http\Integration\Selcom;

class HttpHelper
{



    const SHOW_REQUEST_JSON = 0;
    const DEBUG = 0;

    /**
     * @param $url
     * @param $data
     * @param $headers
     * @return array
     */
    public static function send($url,$data,$headers)
    {

        $data = json_encode($data,JSON_UNESCAPED_SLASHES);
        if (self::SHOW_REQUEST_JSON) {
            exit($data);
        }

        if (self::DEBUG) { echo ('URL:'.$url."\n".'Request: ' . $data . "\n"); }

        //dd($headers);
        $ch = curl_init();

        set_time_limit(60);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);


        if ($http_status == 200) {
            if (self::DEBUG) { echo ('Response: ' . $response . "\n"); }
            $data = json_decode($response,true);
        } else {
            $error = sprintf('HTTP Status : %s, Error: %s, Response: %s', $http_status, $error,$response);
            $data = null;
            if (self::DEBUG) { echo ($error . "\n"); }

        }

        return ['http_status' => $http_status, 'data' => $data, 'error' => $error];
    }

    public static function guessFailureReason($httpCode, $error)
    {
        if ($httpCode == 401 || $httpCode == 403) {
            return "AUTHENTICATION";
        } else if ($httpCode == 408 || preg_match("/timeout/",strtolower($error))) {
            return "TIMEOUT";
        }

        return 'NETWORK';
    }
}