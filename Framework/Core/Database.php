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

    public function getAllEntitiesByColumnName($fromTable, $columnName,$columnValue, $limit = null, $offset = null) {
        if($limit && $offset) {
            $stmt = $this->prepare("
            SELECT * FROM $fromTable WHERE $columnName = ? LIMIT ? OFFSET ?");
        }else {
            $stmt = $this->prepare(" SELECT * FROM $fromTable WHERE $columnName = ?");
        }
        try {
            if($limit && $offset) {
                $stmt->execute([ $columnValue, $limit, $offset ]);
            }else {
                $stmt->execute( [ $columnValue] );
            }
            return $stmt->fetchAll();
        }catch (\PDOException $e) {
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
        if($limit && $offset) {
            $stmt = $this->prepare("
            SELECT * FROM $fromTable LIMIT ? OFFSET ?");
        }else {
            $stmt = $this->prepare(" SELECT * FROM $fromTable ");
        }
        try {
            if($limit && $offset) {
                $stmt->execute([ $limit, $offset ]);
            }else {
                $stmt->execute();
            }
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
     * @param $entityData
     * @param $id
     * @return bool
     */
    public function updateEntityById($tableName, $entityData, $id)
    {
        $valuesCount = $this->getValuesCount($entityData);
        $columnNames = implode(', ', array_keys($entityData));

        $stmt = $this->prepare("
            UPDATE $tableName SET $columnNames = $valuesCount WHERE id = ?
        ");
        $params = [];
        array_push($entityData, $id);
        array_push($params, array_values($entityData));

        $this->beginTransaction();
        try {
            $stmt->execute( $params[0] );
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
     * @param $id
     * @return bool
     */
    public function deleteEntityById($tableName, $id) {
        $stmt = $this->prepare("
        DELETE FROM $tableName WHERE id = ?
        ");

        $this->beginTransaction();
        try {
            $stmt->execute( [ $id ] );
        }catch (\PDOException $e) {
            echo $e->getMessage();
            $this->rollBack();
            return false;
        }
        $this->commit();
        return true;
    }

    private function getValuesCount($assoc) {
        $keys = array_values($assoc);
        $columns = '';
        foreach ($keys as $k) {
            $columns .= '?, ';
        }
        return substr($columns, 0, strlen($columns) - 2);
    }


    /**
     * ---------CUSTOM QUERIES--RELATED-TO-E-SHOP----
     *
     */

    /**
     * @param $userId
     * @return mixed
     */
    public function getUserCart($userId) {
        $stmt = $this->prepare("
            SELECT
              cp.id as cartProductId,
              c.id,
              u.username,
              p.id as productId,
              p.price,
              p.name
            FROM users u
            JOIN usercart c ON c.user_id = u.id
            JOIN cart_products cp ON cp.cart_id = c.id
            JOIN products p ON cp.product_id = p.id
            WHERE u.id = ?;
        ");
        try{
            $stmt->execute([$userId]);
            return $stmt->fetchAll();
        }catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @param $cartId
     * @return array
     */
    public function getProductsInCart($cartId) {
        $stmt = $this->prepare("
            SELECT
	        p.id, p.name, p.price
            FROM cart_products cp
            JOIN products p ON cp.product_id = p.id
            WHERE cp.cart_id = ?;
        ");
        try{
            $stmt->execute([$cartId]);
            return $stmt->fetchAll();
        }catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getUserProducts($userId) {
        $stmt = $this->prepare("
            SELECT
            u.id as userId,
            u.username,
            p.id as productId,
            p.name as productName,
            p.price as productPrice
            FROM
            users_products up
            JOIN products p ON up.product_id = p.id
            JOIN users u ON u.id = up.user_id
            WHERE u.id = ?;
        ");
        try{
            $stmt->execute([$userId]);
            return $stmt->fetchAll();
        }catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getAvailableProductsInCategory($userId, $currentUserCartId, $categoryId) {
        $stmt = $this->prepare("
            SELECT
            p.category_id,
            c.name as categoryName,
            p.id,
            p.name as productName,
            p.quantity,
            p.price,
            p.is_sold
            FROM products p
            JOIN categories c ON c.id = p.category_id
            WHERE p.is_sold = 0
              AND p.id NOT IN (SELECT up.product_id FROM users_products up WHERE up.user_id = ?)
              AND p.id NOT IN (SELECT cp.product_id FROM cart_products cp WHERE cp.cart_id = ?)
              AND c.id = ?
        ");
        try{
            $stmt->execute([$userId, $currentUserCartId, $categoryId]);
            return $stmt->fetchAll();
        }catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getCartByUserId($userId) {
        $stmt = $this->prepare("
            SELECT
             id
            FROM usercart uc
            WHERE uc.user_id = ?

        ");
        try{
            $stmt->execute([$userId]);
            return $stmt->fetch();
        }catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @param $cartId
     * @param $productId
     * @return bool
     */
    public function isProductInCart($cartId, $productId) {
        $stmt = $this->prepare("
            SELECT
            id
            FROM
            cart_products
            WHERE cart_id = ? AND product_id = ?
        ");
        try{
            $stmt->execute([$cartId, $productId]);
            return $stmt->rowCount() > 0;
        }catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function deleteProductFromCart($cartId, $productId) {
        $stmt = $this->prepare("
            DELETE
            FROM cart_products
            WHERE cart_id= ?  AND product_id= ?
        ");
        try{
            $stmt->execute([$cartId, $productId]);
            return $stmt->rowCount() > 0;
        }catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
}