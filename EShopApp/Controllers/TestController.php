<?php

namespace EShop\Controllers;

/**
 * @Route("pesho")
 */
class TestController extends Controller
{
    public function __construct() {
        parent::__construct();
    }

    /**
     * @Admin

     */
    public function index() {

        echo 'Index()';
    }

    /**
     * @Editor
     * @Route("test2")
     */
    public function index2() {
        echo 'Index2()';
    }
}