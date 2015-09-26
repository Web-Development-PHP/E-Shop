<?php
namespace EShop;
use EShop\Config\AppConfig;
use EShop\Config\FolderConfig;
use EShop\Config\RouteConfig;

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

    const CONTROLLER_SUFFIX = 'Controller';

    public function __construct(
        $controllerName = AppConfig::DEFAULT_CONTROLLER,
        $actionName = AppConfig::DEFAULT_ACTION,
        $requestParams = [])
    {
        $this->controllerName = $controllerName ? $controllerName : AppConfig::DEFAULT_CONTROLLER;
        $this->actionName = $actionName ? $actionName : AppConfig::DEFAULT_ACTION;
        $this->requestParams = $requestParams;
    }

    public function dispatch() {
        $this->initRoutes();
        $this->initController();
        $this->initAction();
        View::$controllerName = $this->controllerName;
        View::$actionName = $this->actionName;

        call_user_func_array(
            [
                $this->controller,
                $this->actionName
            ],
            $this->requestParams
        );
    }

    private function initAction() {
        $customRoutes = $this->getAllActionsCustomRoutes($this->controller);
        $customRoutes = array_map('strtolower', $customRoutes);
//        var_dump($customRoutes);
//        var_dump($this->actionName);
        if(in_array(strtolower($this->actionName), $customRoutes) ||
            array_key_exists(strtolower($this->actionName), $customRoutes)) {

            foreach ($customRoutes as $k => $v) {
                if($k == strtolower($this->actionName)) {
                   $this->actionName = $v;
                    break;
                }
                if(strtolower($this->actionName) == $v && $k != $v) {
                    throw new \Exception('This action is pre defined by user');
                }
            }
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
                // TODO
        }else {
            $controllerName =
                RouteConfig::CONTROLLER_DEFAULT_NAMESPACE
                . $this->controllerName
                . self::CONTROLLER_SUFFIX;
        }

        $this->controller = new $controllerName();
        $this->isAccessGranted($controllerName);
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

    private function getAllActionsCustomRoutes($class)
    {
        $refClass = new \ReflectionClass($class);
        $refFuncs = $refClass->getMethods();
        $funcsRoutes = [];
        foreach($refFuncs as $refFunc){
            $doc = $refFunc->getDocComment();
            preg_match_all("/@Route\(\"(.+)\"\)/", $doc, $routes);
            if(count($routes[1]) > 0){
                $customRoute = $routes[1][0];
                $funcsRoutes[$customRoute] =  $refFunc->getName();
            }
        }

        return $funcsRoutes;
    }

    private function getAllClassesCustomRoutes() {
        $classesRoutes = [];

        $declaredControllerFiles = scandir('Controllers');
       // var_dump($declaredControllerFiles);
        foreach($declaredControllerFiles as $fileName){
            if(strpos($fileName, '.php') != false){
                $controllerClassName = (substr($fileName,0,strlen($fileName)-4));
                $controllerFullClassName =
                    RouteConfig::CONTROLLER_DEFAULT_NAMESPACE .$controllerClassName;

                $controller = new $controllerFullClassName();
                $classCustomRoute = $this->getClassAnnotations($controller)[0];
                var_dump($classCustomRoute);
                if(trim($classCustomRoute) != ""){
                    $classesRoutes[$classCustomRoute] = $controllerClassName;
                }
            }
        }

        return $classesRoutes;
    }

    private function isAccessGranted($controller) {
        $authorizations = $this->getControllerAuthorization($controller);
        if(!empty($authorizations[0])) {
            if(!isset($_SESSION['id'])) {
                throw new \Exception("You are not authorized!");
            }
        }
    }

    // Reflection
    private function getClassAnnotations($class) {
        $refClass = new \ReflectionClass($class);
        $doc = $refClass->getDocComment();
        if($doc) {
            preg_match_all("/@Route\(\"(.+)\"\)/", $doc, $routes);
            preg_match_all("/@Authorize/", $doc, $authorizations);
            var_dump($routes);
            return array($routes[1][0], $authorizations[0]);
        }
    }

    private function getActionAuthorization($class, $action)
    {
        $refMethod = new \ReflectionMethod($class, $action);
        $doc = $refMethod->getDocComment();
        preg_match_all("/@Authorize/", $doc, $authorizations);
        return $authorizations[0];
    }

    private function getControllerAuthorization($class)
    {
        $refMethod = new \ReflectionClass($class);
        $doc = $refMethod->getDocComment();
        preg_match_all("/@Authorize/", $doc, $authorizations);
       // var_dump($authorizations);
        return $authorizations[0];
    }
}