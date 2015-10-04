<?php

namespace EShop\Helpers;

class TokenHelper
{
    public static function setCSRFToken(){
        $_SESSION['formToken'] = uniqid(mt_rand(), true);
        return $_SESSION['formToken'];
    }

    public static function getCSRFToken() {
        if(!isset($_SESSION['formToken'])) {
            self::setCSRFToken();
        }
        return $_SESSION['formToken'];
    }
}