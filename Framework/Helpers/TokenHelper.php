<?php

namespace EShop\Helpers;

class TokenHelper
{
    public static function setCSRFToken(){
        $_SESSION['formToken'] = uniqid(mt_rand(), true);
    }

    public static function getCSRFToken() {
        return $_SESSION['formToken'];
    }
}