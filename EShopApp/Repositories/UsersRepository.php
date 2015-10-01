<?php

namespace EShop\Repositories;

use EShop\Config\AppConfig;
use EShop\Config\DatabaseConfig;
use EShop\Core\Database;
use EShop\Models\BindModels\RegisterBindingModel;
use EShop\Models\Cart;
use EShop\Models\MiniProduct;
use EShop\Models\User;
use EShop\Services\ElectronicShopData;
use EShop\ViewModels\UserViewModel;

class UsersRepository implements IRepository
{
    /**
     * @var Database
     */
    protected $db;
    const USERS_TABLENAME = 'users';
    const CART_TABLENAME = 'usercart';

    public function __construct() {
        $this->db = \EShop\Core\Database::getInstance(DatabaseConfig::DB_INSTANCE);
    }

    /**
     * @param $id
     * @return User
     */
    public function findById($id) {
        $data = $this->db->getEntityById(self::USERS_TABLENAME, $id);
        if($data == null) {
            return null;
        }
        $user = new UserViewModel($data);

        return $user;
    }

    public function findByUsername($username) {
        $data = $this->db->getEntityByColumnName(self::USERS_TABLENAME, 'username', $username);
        var_dump($username);
        if($data == null) {
            return null;
        }
        ;
        $user = new User($data);

        return $user;
    }

    public function create(RegisterBindingModel $user) {
        if($user->getPassword() != $user->getConfirmPassword()) {
            throw new \Exception('Passwords does not match');
        }
        $isCreated = $this->db->insertEntity(self::USERS_TABLENAME, array(
            'username' => $user->getUsername(),
            'password' => password_hash($user->getPassword(), AppConfig::PASSWORD_CRYPT_METHOD),
            'email' => $user->getEmail(),
            'cash' => $user->getCash(),
            'role_id' => $user->getRole()
        ));
        return $isCreated;
    }

    public function getUserProducts($id) {
        $data = $this->db->getUserProducts($id);
        $products = [];

        foreach ($data as $row) {
            $minifiedProduct = new MiniProduct($row);
            array_push($products, $minifiedProduct);
        }

        return $products;
    }

    public function sellItems($userId, $itemsTotalCash) {
        $user = $this->findById($userId);
        $userCurrentCash = $user->getCash();
        $userCurrentCash = $userCurrentCash + $itemsTotalCash;
        $isUpdated = $this->db->updateEntityById(self::USERS_TABLENAME, array(
            'cash' => $userCurrentCash
        ), $userId);
        return $isUpdated;
    }

    public function purchaseItems($userId, $itemsTotalCash) {
        $user = $this->findById($userId);
        $userCurrentCash = $user->getCash();
        $userCurrentCash = $userCurrentCash - $itemsTotalCash;
        $isUpdated = $this->db->updateEntityById(self::USERS_TABLENAME, array(
            'cash' => $userCurrentCash
        ), $userId);
        return $isUpdated;
    }

    public function remove($id)
    {
        // TODO: Implement remove() method.
    }
}