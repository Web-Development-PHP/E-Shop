<?php

namespace EShop\Controllers;

/**
 * @Authorize
 */
class TestController extends \EShop\Controllers\Controller
{
    public function __construct() {
        parent::__construct();
    }



    public function index() {
        echo 'Index()';
    }
}