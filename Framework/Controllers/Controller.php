<?php

namespace EShop\Controllers;
abstract class Controller
{
    protected function __construct() {
        $this->onInit();
    }

    public function index() {
        echo 'You have loaded default action';
    }

    /**
     * @Route("onInit")
     */
    protected function onInit() {
    }

    protected function isLogged() {
        return isset($_SESSION['id']);
    }
}