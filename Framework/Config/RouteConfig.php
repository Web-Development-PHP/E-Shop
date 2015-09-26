<?php

namespace EShop\Config;

abstract class RouteConfig
{
    const CONTROLLER_DEFAULT_NAMESPACE = 'EShop\\Controllers\\';
    const AREAS_DEFAULT_NAMESPACE = 'EShop\\Areas\\';

    public static function getBasePath() {
        $phpSelf = $_SERVER['PHP_SELF'];
        $index = basename($phpSelf);

        $basePath = str_replace($index, '', $phpSelf);
        return $basePath;
    }
}