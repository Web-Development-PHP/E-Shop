<?php

namespace EShop\Core;
use EShop\Config\DatabaseConfig;
use EShop\Core\Drivers;
class Database
{
    private static $_instances = array();

    /**
     * @var \PDO
     */
    private $db;

    private function __construct ($pdoInstance) {
        $this->db = $pdoInstance;
        $this->db->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
    }

    public static function getInstance ($instanceName = DatabaseConfig::DB_INSTANCE) {
        if(!isset(self::$_instances[$instanceName])) {
            throw new \Exception("Instance with this name does not exists.");
        }

        return static::$_instances[$instanceName];
    }

    public static function setInstance ($instanceName, $driver, $user, $pass, $dbName, $host = null) {
        $driver = \EShop\Core\Drivers\DriverFactory::create($driver, $user, $pass, $dbName, $host);

        $pdo = new \PDO($driver->getDsn(), $user, $pass, DatabaseConfig::$DB_PDO_OPTIONS);

        self::$_instances[$instanceName] = new self($pdo);
    }

    public function prepare($statement, array $driverOptions = []) {
        $statement = $this->db->prepare($statement, $driverOptions);

        return new \EShop\Core\Drivers\Statement($statement);
    }

    public function query($query) {
        return $this->db->query($query);
    }

    public function lastId($name = null) {
        return $this->db->lastInsertId($name);
    }

    public function beginTransaction() {
        return $this->db->beginTransaction();
    }

    public function commit() {
        return $this->db->commit();
    }

    public function escape($string) {
        return $this->db->quote($string);
    }

    public function rollBack() {
        return $this->db->rollBack();
    }

    public function getEntityByColumnName($fromTable, $columnName, $columnValue) {
        $stmt = $this->prepare("
            SELECT * FROM $fromTable
            WHERE $columnName = ?;
        ");
        try {
            $stmt->execute([  $columnValue ]);
            return $stmt->fetch();
        }catch(\PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @param $fromTable
     * @param $id
     * @return mixed
     */
    public function getEntityById($fromTable, $id) {
        $stmt = $this->prepare("
            SELECT * FROM $fromTable WHERE id = ?
        ");
        try {
            $stmt->execute([ $id ]);
            return $stmt->fetch();
        }catch(\PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @param $fromTable
     * @param null $limit
     * @param null $offset
     * @return array
     */
    public function getAllEntities($fromTable, $limit = null, $offset = null) {
        $stmt = $this->prepare("
        SELECT * FROM $fromTable LIMIT ? OFFSET ?
        ");
        try {
            $stmt->execute([ $limit, $offset ]);
            return $stmt->fetchAll();
        }catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @param $inTable
     * @param $entityData
     */
    public function insertEntity($inTable, $entityData) {
        $valuesCount = $this->getValuesCount($entityData);
        $columnNames = implode(', ', array_keys($entityData));
        $stmt = $this->prepare("
            INSERT INTO $inTable ($columnNames) VALUES($valuesCount)
        ");
        $this->beginTransaction();
        try {
            $stmt->execute(array_values($entityData));
        }catch (\PDOException $e) {
            echo $e->getMessage();
            $this->rollBack();
            return false;
        }
        $this->commit();
        return true;
    }

    /**
     * @param $tableName
     * @param $columnToUpdate
     * @param $columnNewData
     * @param $conditionColumn
     * @param $conditionValue
     */
    public function updateEntityByColumn(
            $tableName,
            $columnToUpdate,
            $columnNewData,
            $conditionColumn,
            $conditionValue)
    {
        $stmt = $this->prepare("
            UPDATE ? SET ? = ? WHERE ? = ?
        ");
        $this->beginTransaction();
        try {
            $stmt->execute(
                [
                    $tableName,
                    $columnToUpdate,
                    $columnNewData,
                    $conditionColumn,
                    $conditionValue
                ]
            );
        }catch (\PDOException $e) {
            echo $e->getMessage();
            $this->rollBack();
        }
        $this->commit();
    }

    /**
     * @param $tableName
     * @param $primaryKeyColumnName
     * @param $primaryKeyValue
     */
    public function deleteEntityByPrimaryKey($tableName, $primaryKeyColumnName, $primaryKeyValue) {
        $stmt = $this->prepare("
        DELETE FROM ? WHERE ? = ?
        ");

        $this->beginTransaction();
        try {
            $stmt->execute(
                [
                    $tableName,
                    $primaryKeyColumnName,
                    $primaryKeyValue
                ]
            );
        }catch (\PDOException $e) {
            echo $e->getMessage();
            $this->rollBack();
        }
        $this->commit();
    }

    private function getValuesCount($assoc) {
        $keys = array_values($assoc);
        $columns = '';
        foreach ($keys as $k) {
            $columns .= '?, ';
        }
        return substr($columns, 0, strlen($columns) - 2);
    }
}