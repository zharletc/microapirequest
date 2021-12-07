<?php

namespace Zharletc\Microapirequest\Services;

use Illuminate\Support\Facades\Http;
use Zharletc\Microapirequest\Builders\ResponseBuilder;

class MicroApiRequestService extends HttpClientService
{
    protected static $commonHeader = [];
    protected static $commonBody = [];
    private static $app_namespace = '';
    private static $service_name = '';
    private static $service_name_only = '';
    private static $store = [];
    private static $maker = "";
    private static $declaration = '
        function %s() {
            return call_user_func_array(
                %s::get(__FUNCTION__),
                func_get_args()
            );
        }
    ';

    public function __construct()
    {
    }

    public function __call($func, $params)
    {
        if (config('microapirequest.app_namespace') == null) {
            return false;
        }
        self::$app_namespace = config('microapirequest.app_namespace');
        self::$service_name = get_called_class();

        $temp =  explode("\\", self::$service_name);
        self::$service_name_only = end($temp);

        if (class_exists(self::$app_namespace['endpoint'] . self::$service_name_only . "\\" . $func)) {
            return self::createFunction($func, $params[0]);
        }
    }

    public static function createFunction($function, $payloads)
    {
        if (!empty(self::$store[$function])) {
            return $function($payloads);
        }

        self::add(
            $function,
            static function ($payloads = null) use ($function) {
                $class_name = self::$service_name;
                $object = new $class_name();

                $baseUri = $object::getBaseUri();
                $endpoint_class = self::$app_namespace['endpoint'] .  self::$service_name_only . "\\" . $function;

                $object = new $endpoint_class();
                $pathUri = $object::$uri;
                $method = $object::$method;

                self::$url = $baseUri . $pathUri;

                $payloads['header'] = array_merge($payloads['header'], self::$commonHeader);
                $payloads['body'] = array_merge($payloads['body'], self::$commonBody);

                $response = self::request($method, $payloads);
                $result = new ResponseBuilder($response);

                // $result = json_decode($response->body());

                return $result;
            }
        );

        eval(self::make());

        return $function($payloads);
    }

    private static function safeName($name)
    {
        // extra safety against bad function names
        $name = preg_replace('/[^a-zA-Z0-9_]/', "", $name);
        $name = substr($name, 0, 64);
        return $name;
    }

    public static function add($name, $func)
    {
        // prepares a new function for make()
        $name = self::safeName($name);
        self::$store[$name] = $func;
        self::$maker .= sprintf(self::$declaration, $name, __CLASS__);
    }

    public static function remove($name)
    {
        $name = self::safeName($name);
        self::$store[$name] = [];
        self::$maker = "";
    }

    public static function get($name)
    {
        // returns a stored callable
        return self::$store[$name];
    }

    public static function make()
    {
        // returns a string with all declarations
        return self::$maker;
    }
}
