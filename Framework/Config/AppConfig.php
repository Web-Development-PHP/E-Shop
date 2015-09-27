<?php

namespace EShop\Config;

abstract class AppConfig
{
    const DEFAULT_CONTROLLER = 'home';
    const DEFAULT_ACTION = 'index';
    const PASSWORD_CRYPT_METHOD = PASSWORD_DEFAULT;
}