<?php

namespace EShop\Core\Drivers;

abstract class DriverFactory
{
    const MYSQL_DRIVER = 'mysql';

    public static function create($driver, $user, $pass, $dbName, $host) {
        switch ($driver) {
            case DriverFactory::MYSQL_DRIVER:
                return new MySQLDriver($user, $pass, $dbName, $host);
        }
    }
}