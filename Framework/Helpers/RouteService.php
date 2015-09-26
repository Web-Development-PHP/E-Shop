<?php

namespace EShop\Helpers;

class RouteService
{
    private static $basePath;

    public static function init($basePath) {
        self::$basePath = $basePath;
    }

    /**
     * @param $controller
     * @param $action
     * @param bool|false $isExit
     */
    public static function redirect($controller, $action, $isExit = false)
    {
        $location = self::$basePath
            . $controller
            . DIRECTORY_SEPARATOR
            .$action;

        header("Location: $location");

        if($isExit) {
            exit;
        }
    }
}