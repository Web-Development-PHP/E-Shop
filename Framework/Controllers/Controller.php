<?php

namespace EShop\Controllers;
use EShop\Models\IBindingModel;

abstract class Controller
{
    protected $isPost = false;

    protected function __construct() {
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $this->isPost = true;
        }
        $this->onInit();
    }

    abstract public function index();

    protected function onInit() {
    }

    protected function isLogged() {
        return isset($_SESSION['id']);
    }

    protected function setIdInSession($id) {
        $_SESSION['id'] = $id;
    }

    protected function getCurrentUserId() {
        if($this->isLogged()) {
            return $_SESSION['id'];
        }
        return null;
    }

    protected function populateWithPost ($obj = NULL)
    {
        if(is_object($obj)) {

        } else {
            $obj = new \stdClass();
        }

        foreach ($_POST as $var => $value) {
            $obj->$var = trim($value); //here you can add a filter, like htmlentities ...
        }

        return $obj;
    }

    protected function escapeAll($toEscape) {
        if(is_array($toEscape)) {
            foreach ($toEscape as $key => &$value) {
                if(is_object($value)) {
                    $reflection = new \ReflectionClass($value);
                    $properties = $reflection->getProperties();

                    foreach ($properties as &$property) {
                        $property->setAccessible(true);
                        $property->setValue($value, $this->escapeAll($property->getValue($value)));
                    }
                }elseif(is_array($value)) {
                    $this->escapeAll($value);
                }else {
                    $value = htmlspecialchars($value);
                }
            }
        }elseif(is_object($toEscape)) {
            $reflection = new \ReflectionClass($toEscape);
            $properties = $reflection->getProperties();

            foreach ($properties as &$property) {
                $property->setAccessible(true);
                $property->setValue($toEscape, $this->escapeAll($property->getValue($toEscape)));
            }
        }else {
            $toEscape = htmlspecialchars($toEscape);
        }

        return $toEscape;
    }

    protected function isModelStateValid($postData) {
        foreach ($postData as $k => $v) {
            if(empty($v)) {
                throw new \Exception("Model state is not valid $k cannot be empty!");
            }
        }
    }
}