<?php

namespace EShop\Controllers;

/**
 * @Route("pesho")
 */
class TestController extends \EShop\Controllers\Controller
{
    public function __construct() {
        parent::__construct();
    }

    /**
     * @Authorize
     * @Route("test")
     */
    public function index() {
        echo 'Index()';
    }

    /**
     * @Route("test2")
     */
    public function index2() {
        echo 'Index2()';
    }
}