<?php

namespace EShop;
require_once 'FrontController.php';
use EShop\Config\AppConfig;
use EShop\Config\RouteConfig;
use EShop\Helpers\RouteService;

RouteService::init(RouteConfig::getBasePath());
final class App
{
    /**
     * @var FrontController
     */
    private $frontController;

    public function __construct()
    {
        $this->frontController = new \EShop\FrontController();

        \EShop\DependencyContainer\AppStarter::registerDbConfigurations();
    }

    public function start() {
        $this->frontController->dispatch();
    }
}