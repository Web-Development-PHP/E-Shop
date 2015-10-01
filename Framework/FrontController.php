<?php
namespace EShop;
use EShop\Config\AppConfig;
use EShop\Config\FolderConfig;
use EShop\Config\RouteConfig;
use EShop\Helpers\ReflectionService;
use EShop\Helpers\TokenHelper;

session_start();
require_once 'AutoLoader.php';

\EShop\Autoloader::register();
class FrontController
{
    private $controllerName;
    private $actionName;
    private $requestParams = [];
    private $area = null;
    private $customRoute = null;
    private $controller;
    private static $_router;
    private static $_reflectionHelper;

    const CONTROLLER_SUFFIX = 'Controller';

    public function __construct(
        $controllerName = AppConfig::DEFAULT_CONTROLLER,
        $actionName = AppConfig::DEFAULT_ACTION,
        $requestParams = [])
    {
        $this->controllerName = $controllerName ? $controllerName : AppConfig::DEFAULT_CONTROLLER;
        $this->actionName = $actionName ? $actionName : AppConfig::DEFAULT_ACTION;
        $this->requestParams = $requestParams;
        self::$_router = Router::getInstance();
        self::$_reflectionHelper = ReflectionService::getInstance();
    }

    public function dispatch() {
        $this->initRoutes();
        $this->loadSpecialRoute();
        $this->initController();
        $this->initAction();
        View::$controllerName = $this->controllerName;
        View::$actionName = $this->actionName;

        $actionTypeParams = $this->getFuncParamsTypes($this->controller, $this->actionName);
        if(isset($actionTypeParams[0]) && strpos(strtolower($actionTypeParams[0]), 'bindingmodel') !== false){
            $bindingModelClass = $actionTypeParams[0];
            $bindingModel = new $bindingModelClass($_POST);
            ReflectionService::validateBindingModel($bindingModel);
            unset($_SESSION['formToken']);
            call_user_func(array($this->controller, $this->actionName), $bindingModel);

        }else {
            call_user_func_array([ $this->controller, $this->actionName ], $this->requestParams );
        }
        if( $_SERVER['REQUEST_METHOD'] == 'POST' ||
            $_SERVER['REQUEST_METHOD'] == 'PUT'  ||
            $_SERVER['REQUEST_METHOD'] == 'DELETE') {
            TokenHelper::setCSRFToken();
        }
        self::$_router->getControllerRolesAnnotation($this->controller);
        self::$_router->isInRole($this->actionName);
    }



    private function loadSpecialRoute() {
        $customRoutes = self::$_router->getAllClassesCustomRoutes();
        $this->controllerName = $this->parseSpecialRoute($this->controllerName, $customRoutes, self::CONTROLLER_SUFFIX);
        if($this->controllerName != '' && $this->controllerName != null &&
            strtolower($this->controllerName) != strtolower(AppConfig::DEFAULT_CONTROLLER)) {
            $this->customRoute = $this->controllerName;
        }else {
            $this->controllerName = AppConfig::DEFAULT_CONTROLLER;
        }
    }

    private function parseSpecialRoute($param, $customRoutes = [], $paramName) {
        if(in_array(strtolower($param), $customRoutes) ||
            array_key_exists(strtolower($param), $customRoutes)) {

            foreach ($customRoutes as $k => $v) {
                if ($k == strtolower($param)) {
                    $param = $v;
                    break;
                }
                if (str_replace('controller', '', strtolower($param)) == $v && $k != $v) {
                    throw new \Exception("This $paramName is pre defined by user");
                }
            }
        }
        return $param;
    }

    private function initAction() {
        $customRoutes = self::$_router->getAllActionsCustomRoutes($this->controller);
        $customRoutes = array_map('strtolower', $customRoutes);
        $customRoutes = array_change_key_case($customRoutes, CASE_LOWER);
        self::$_reflectionHelper->isActionAccessGrandet($customRoutes, $this->controller, $this->actionName);
        $this->actionName = $this->parseSpecialRoute($this->actionName, $customRoutes, 'Action');
        if ($this->actionName == '') {
            $this->actionName = AppConfig::DEFAULT_ACTION;
        }
    }


    private function initController() {
        if ($this->area != null) {
            $controllerName =
                RouteConfig::AREAS_DEFAULT_NAMESPACE
                . ucfirst($this->area)
                . DIRECTORY_SEPARATOR
                . 'Controllers'
                . DIRECTORY_SEPARATOR
                . $this->controllerName
                . self::CONTROLLER_SUFFIX;
        }elseif($this->customRoute != null) {
                $controllerName =
                    RouteConfig::CONTROLLER_DEFAULT_NAMESPACE
                    .$this->customRoute;
            $hasControllerSufix = substr($controllerName, strlen($controllerName) - 10, strlen($controllerName) - 1);
            if($hasControllerSufix != self::CONTROLLER_SUFFIX) {
                $controllerName .= self::CONTROLLER_SUFFIX;
            }

        }else {
            $controllerName =
                RouteConfig::CONTROLLER_DEFAULT_NAMESPACE
                . $this->controllerName
                . self::CONTROLLER_SUFFIX;
        }

        $this->controller = new $controllerName();
        self::$_reflectionHelper->isAccessGranted($controllerName);
    }

    private function initRoutes() {
        if(isset($_GET['uri'])) {
            $this->requestParams = explode('/', $_GET['uri']);
            $this->performAreaSearch();
            $this->controllerName = ucfirst(array_shift($this->requestParams));
            $this->actionName = ucfirst(array_shift($this->requestParams));
        }
    }

    private function performAreaSearch($folder = FolderConfig::AREAS_DEFAULT_FOLDER) {
        $areas = scandir($folder);
        if(in_array(ucfirst($this->requestParams[0]), $areas)) {
            $index = array_search(ucfirst($this->requestParams[0]), $areas);
            $this->area = $areas[$index];
            array_shift($this->requestParams);
        }
    }

    private function getFuncParamsTypes($class, $func) {
        $refFunc =  new \ReflectionMethod($class, $func);
        $params = [];
        foreach($refFunc->getParameters() as $param) {
            array_push($params, $param->getClass()->name);
        }

        return $params;
    }
}