<?php

namespace Zharletc\Microapirequest\Facades;

use Illuminate\Support\Facades\Facade;

class MicroApiRequestFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        $class_name_array = explode('\\',get_called_class());
        $service_name = end($class_name_array);
        $_SESSION['service_name'] = $service_name;
        return "MicroAPI";
    }
}
