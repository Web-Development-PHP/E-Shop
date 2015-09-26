<?php

namespace EShop\Areas\Forum\Controllers;

class AboutController extends \EShop\Controllers\Controller
{
    public function __construct() {
        parent::__construct();
    }
    public function Index() {
        echo 'Hello this is AboutController';
    }
}