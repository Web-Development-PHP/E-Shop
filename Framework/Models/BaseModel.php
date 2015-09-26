<?php

namespace EShop\Models;

use EShop\Config\DatabaseConfig;
use EShop\Core\Database;

abstract class BaseModel
{
    /**
     * @var Database
     */
    private $db;

    public function __construct() {
        $this->db = Database::getInstance(DatabaseConfig::DB_INSTANCE);
    }

    /**
     * @return Database
     */
    protected function getDb()
    {
        return $this->db;
    }
}