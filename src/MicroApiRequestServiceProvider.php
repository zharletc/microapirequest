<?php

namespace Zharletc\Microapirequest;

use Exception;
use Illuminate\Support\ServiceProvider;

class MicroApiRequestServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $this->app->bind("MicroAPI", function () {
            if (config('microapirequest.app_namespace') == null) {
                  throw new MicroApiRequestException("config microapirequest.app_namespace not found");
            }

            $service_namespace = config('microapirequest.app_namespace')['http'];
            $service_name = $_SESSION['service_name'];
            if (class_exists($service_namespace . $service_name)) {
                unset($_SESSION['service_name']);
                $class = $service_namespace . $service_name;
                $object = new $class();
                return new $object;
            }
        });
    }
}
