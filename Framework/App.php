<?php

namespace EShop;
require_once 'FrontController.php';
use EShop\Config\AppConfig;
use EShop\Config\RouteConfig;
use EShop\Exceptions\InvalidCredentialsException;
use EShop\Exceptions\InvalidUserInputException;
use EShop\Exceptions\InvalidUserOperationException;
use EShop\Exceptions\UnauthorizedException;
use EShop\Helpers\RouteService;
use EShop\Helpers\TokenHelper;

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
        if(!isset($_SESSION['formToken'])) {
            TokenHelper::setCSRFToken();
        }
        try
        {
            $this->frontController->dispatch();
        }
        catch (InvalidCredentialsException $credError)
        {
            echo $credError->getMessage();
        }
        catch(InvalidUserInputException $inputError)
        {
            echo $inputError->getMessage();
        }
        catch(InvalidUserOperationException $userOperError)
        {
            echo $userOperError->getMessage();
        }
        catch(UnauthorizedException $unathourError)
        {
            echo $unathourError->getMessage();
        }
        // TODO TRY CATCH ERRORS BEFORE DISPATCH
    }
}