<?php

namespace Zharletc\Microapirequest\Services;

use Illuminate\Support\Facades\Http;
use PharIo\Manifest\InvalidUrlException;

use function PHPUnit\Framework\throwException;

abstract class HttpClientService
{
    protected static $url;

    public static function request($method, $payloads){
        $res = null;
        switch($method){
            case "POST":
                $res = self::post($payloads);
                break;
            case "GET":
                $res = self::get($payloads);
                break;
            case "PUT":
                $res = self::put($payloads);
                break;
            case "PATCH":
                $res = self::patch($payloads);
                break;
            case "`DELETE`":
                $res = self::delete($payloads);
                break;

        }

        return $res;
    }

    public static function post($payloads){
        $res = Http::withHeaders($payloads['header'])->post(self::$url, $payloads['body']);
        return $res;
    }

    public static function get($payloads){
        $res = Http::withHeaders($payloads['header'])->get(self::$url, $payloads['query']);
        return $res;
    }

    public static function put($payloads){
        $res = Http::withHeaders($payloads['header'])->put(self::$url, $payloads['body']);
        return $res;
    }

    public static function delete($payloads){
        $res = Http::withHeaders($payloads['header'])->delete(self::$url, $payloads['body']);
        return $res;
    }

    public static function patch($payloads){
        $res = Http::withHeaders($payloads['header'])->patch(self::$url, $payloads['body']);
        return $res;
    }
}
