<?php

namespace EShop\Controllers;
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
}