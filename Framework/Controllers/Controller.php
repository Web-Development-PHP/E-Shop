<?php

namespace EShop\Controllers;
use EShop\Helpers\RouteService;
use EShop\Helpers\TokenHelper;
use EShop\Models\IBindingModel;

abstract class Controller
{
    protected $isPost = false;
    protected $roles = [];

    protected function __construct() {
        $this->onInit();
    }

    abstract public function index();

    protected function onInit() { }

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
}