<?php

namespace EShop\Areas\Forum2\Controllers;

class About2Controller extends \EShop\Controllers\Controller
{
    public function __construct() {
        parent::__construct();
    }
    public function Index() {
        echo 'Hello this is About 2 Controller';
    }
}