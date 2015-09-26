<?php

namespace EShop\Config;

abstract class DatabaseConfig
{
    const DB_DRIVER = 'mysql';
    const DB_HOST = 'localhost';
    const DB_USER = 'root';
    const DB_PASSWORD = '';
    const DB_NAME = 'eshop';
    const DB_INSTANCE = 'app';
    public static $DB_PDO_OPTIONS =  array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
}