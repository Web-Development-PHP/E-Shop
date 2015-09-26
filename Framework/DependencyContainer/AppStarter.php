<?php

namespace EShop\DependencyContainer;
final class AppStarter
{
    private function __construct() {
    }

    public static function registerDbConfigurations() {
        \EShop\Core\Database::setInstance(
            \EShop\Config\DatabaseConfig::DB_INSTANCE,
            \EShop\Config\DatabaseConfig::DB_DRIVER,
            \EShop\Config\DatabaseConfig::DB_USER,
            \EShop\Config\DatabaseConfig::DB_PASSWORD,
            \EShop\Config\DatabaseConfig::DB_NAME,
            \EShop\Config\DatabaseConfig::DB_HOST
        );
    }
}