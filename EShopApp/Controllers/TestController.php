<?php

namespace EShop\Controllers;

/**
 * @Authorize
 * @Route("pesho")
 */
class TestController extends \EShop\Controllers\Controller
{
    public function __construct() {
        parent::__construct();
    }

    /**
     * @Route("test")
     */
    public function index() {
        echo 'Index()';
    }
}