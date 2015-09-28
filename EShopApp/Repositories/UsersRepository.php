<?php

namespace EShop\Repositories;

use EShop\Config\AppConfig;
use EShop\Config\DatabaseConfig;
use EShop\Core\Database;
use EShop\Models\BindModels\RegisterBindingModel;
use EShop\Models\BindModels\UserBindingModel;
use EShop\Models\User;
use EShop\ViewModels\UserViewModel;

class UsersRepository
{
    /**
     * @var Database
     */
    protected $db;
    const USERS_TABLENAME = 'users';

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

    public function removeById($id) {
        $this->db->deleteEntityByPrimaryKey(self::USERS_TABLENAME, 'id', $id);
    }

    public function changePassword($username, $newPassword) {
        $user = $this->findByUsername($username);
        if($user != null) {
            $this->db->updateEntityByColumn(self::USERS_TABLENAME, 'password', $newPassword, 'username', $username);
        }else {
            throw new \Exception('Error during change password');
        }
    }
}