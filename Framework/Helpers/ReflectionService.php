<?php

namespace EShop\Helpers;

class ReflectionService
{
    private static $_instance = null;
    private function __construct() {
    }

    public static function getInstance() {
        if(self::$_instance == null) {
            self::$_instance = new \EShop\Helpers\ReflectionService();
        }
        return self::$_instance;
    }

    public function isAccessGranted($controller) {
        $authorizations = $this->getControllerAuthorization($controller);
        if(!empty($authorizations[0])) {
            if(!isset($_SESSION['id'])) {
                throw new \Exception("You are not authorized!");
            }
        }
    }

    public function getControllerAuthorization($class)
    {
        $refMethod = new \ReflectionClass($class);
        $doc = $refMethod->getDocComment();
        preg_match_all("/@Authorize/", $doc, $authorizations);
        return $authorizations[0];
    }

    public function getActionAuthorization($class, $action)
    {
        $refMethod = new \ReflectionMethod($class, $action);
        $doc = $refMethod->getDocComment();
        preg_match_all("/@Authorize/", $doc, $authorizations);
        return $authorizations[0];
    }

    public function isActionAccessGrandet($assoc, $controller, $actionName) {
        try {
            $authorizationAnnotation = $this->getActionAuthorization($controller, $actionName);
        }catch (\ReflectionException $e) {
        }
        if(!in_array($actionName, $assoc) && !empty($authorizationAnnotation[0])) {
            if(!isset($_SESSION['id'])) {
                throw new \Exception('You are not authorized');
            }
        }
        $arr = array_values($assoc);
        $arrKeys = array_keys($assoc);
        $index = 0;

        foreach ($arr as $value) {
            $authorization = $this->getActionAuthorization($controller, $value);
            foreach ($authorization as $auth) {

                if($auth == "@Authorize" &&
                    (strtolower($actionName) == $arrKeys[$index] || $actionName == $value)) {
                    if(!isset($_SESSION['id'])) {
                        throw new \Exception('You are not authorized');
                    }
                }
            }
            $index++;
        }
    }
}