<?php

namespace EShop;
use EShop\Config\AppConfig;
use EShop\Config\FolderConfig;
use EShop\Config\RouteConfig;
use EShop\Helpers\RouteService;
use EShop\Helpers\TokenHelper;

require_once 'AutoLoader.php';
Autoloader::register();

class Router
{
    private static $_instance = null;
    public $roles = [];
    public $roleActionNames = [];

    private function __construct(){
    }

    public static function getInstance() {
        if(self::$_instance == null){
            self::$_instance = new \EShop\Router();
        }

        return self::$_instance;
    }

    public function getAllActionsCustomRoutes($class)
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

    public function getAllClassesCustomRoutes() {
        $classesRoutes = [];

        $declaredControllerFiles = scandir(FolderConfig::CONTROLLERS_DEFAULT_FOLDER);
        foreach($declaredControllerFiles as $fileName){
            if(strpos($fileName, '.php') != false){
                $controllerClassName = (substr($fileName,0,strlen($fileName)-4));
                $controllerFullClassName =
                    RouteConfig::CONTROLLER_DEFAULT_NAMESPACE .$controllerClassName;
                $controller = new $controllerFullClassName();
                $classCustomRoute = $this->getClassAnnotations($controller)[0];
                if($classCustomRoute){
                    $classesRoutes[$classCustomRoute] = $controllerClassName;
                }
            }
        }
        return $classesRoutes;
    }

    private function getClassAnnotations($class) {
        $refClass = new \ReflectionClass($class);
        $doc = $refClass->getDocComment();
        if($doc) {
            preg_match_all("/@Route\(\"(.+)\"\)/", $doc, $routes);
            preg_match_all("/@Authorize/", $doc, $authorizations);
            if(isset($routes[1][0], $authorizations[0])) {
                return array($routes[1][0], $authorizations[0]);
            }
        }
    }

    public function getControllerRolesAnnotation($class) {
        $refClass = new \ReflectionClass($class);
        $reflMethods = $refClass->getMethods();
        foreach ($reflMethods as $method) {
            $doc = $method->getDocComment();
            preg_match_all("/@(Admin)|@(Editor)|@(Guest)/", $doc, $userRoles);
            if($userRoles[0] !== null &&  !empty($userRoles[0])) {
                if($userRoles[0][0] !== null &&  !empty($userRoles[0][0])) {
                    foreach ($userRoles[0] as $value) {
                        if(!in_array($value, $this->roles)) {
                            array_push($this->roles, $value);
                            array_push($this->roleActionNames, [$method->getName() => $value]);
                        }
                    }
                }
            }
        }
        return $this->roles;
    }

    public function isInRole($currentActionName) {
        $currentUserRole = '@'.$_SESSION['role'];
        $isInRole = false;
        $rolesCount = count($this->roleActionNames);
        $i = 0;
        if(isset($this->roleActionNames[$i])) {
            foreach ($this->roleActionNames[$i] as $actionName => $roleName) {
                if($currentUserRole == '@Admin') {
                    $isInRole = true;
                    break;
                }elseif($currentUserRole == $roleName) {
                    $isInRole = true;
                    break;
                }elseif(strtolower($currentUserRole) != strtolower($roleName) &&
                    strtolower($actionName) != strtolower($currentActionName)) {
//                    var_dump($currentActionName);
//                    var_dump($actionName);
                    $isInRole = true;
                    break;
                }
                $i++;
            }
        }

        if($rolesCount === 0) {
            $isInRole = true;
        }

        if($isInRole === false) {
            throw new \Exception('You are not authorized');
        }
    }
}