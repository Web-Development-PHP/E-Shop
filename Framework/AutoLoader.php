<?php

namespace EShop;
use EShop\Config\RouteConfig;

final class AutoLoader
{
    public static function register() {
        spl_autoload_register(function($class) {
            $pathParams = explode("\\", $class);
            $path = implode(DIRECTORY_SEPARATOR, $pathParams);
            $path = str_replace($pathParams[0], "", $path);
            require_once $path . '.php';
        });
    }
}