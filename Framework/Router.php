<?php

namespace EShop;
use EShop\Config\AppConfig;
use EShop\Config\RouteConfig;
use EShop\Helpers\RouteService;

require_once 'AutoLoader.php';
Autoloader::register();

class Router
{
//    public static $requestParams = [];
//    public static $controller;// = AppConfig::DEFAULT_CONTROLLER;
//    public static $action;// = AppConfig::DEFAULT_ACTION;

    private static $_instance = null;


    private function __construct(){
    }

    public static function getInstance() {
        if(self::$_instance == null){
            self::$_instance = new \EShop\Router();
        }
        return self::$_instance;
    }
}