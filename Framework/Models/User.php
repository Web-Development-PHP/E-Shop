<?php

namespace EShop\Models;

use EShop\Config\DatabaseConfig;
use EShop\Core\Database;

class User extends BaseModel
{
    const PASSWORD_ENCRYPTION_METHOD = PASSWORD_DEFAULT;

    public function edit($username, $password, $confirmPassword) {
        if(!$this->exists($username)) {
            throw new \Exception("User with this username does not exits");
        }
        if($password != $confirmPassword) {
            throw new \Exception('Passwords doesnt match');
        }

        $result = $this->getDb()->prepare("
            UPDATE users SET password = ? WHERE username = ?
        ");

        $result->execute(
            [
                password_hash($password, \EShop\Models\User::PASSWORD_ENCRYPTION_METHOD),
                $username
            ]
        );

        if($result->rowCount() > 0) {
            return true;
        }

        throw new \Exception('Unable to update profile');
    }

    public function register($username, $password, $confirmPassword, $email) {
        if($this->exists($username)) {
            throw new \Exception("User with this username already exists");
        }
        if($password != $confirmPassword) {
            throw new \Exception('Passwords does not match');
        }

        $result = $this->getDb()->prepare("
            INSERT INTO users (username, password, email)
            VALUES(?, ?, ?);
        ");

        $result->execute(
            [
                $username,
                password_hash($password, \EShop\Models\User::PASSWORD_ENCRYPTION_METHOD),
                $email
            ]
        );

        if($result->rowCount() > 0) {
            $userId = $this->getDb()->lastId();
            $this->setIdInSession($userId);
            return true;
        }else {
            throw new \Exception('User register failed');
        }
    }

    public function login($username, $password) {
        if(!$this->exists($username)) {
            throw new \Exception('User with this username doesnt exists');
        }
        $result = $this->getDb()->prepare("
        SELECT
          id, username, password, email, full_name, age
          FROM users
          WHERE username = ?;
        ");

        $result->execute([ $username ]);

        if($result->rowCount() < 0) {
            throw new \Exception('Invalid credentials');
        }

        $userRow = $result->fetch();

        if(password_verify($password, $userRow['password'])) {
            $this->setIdInSession($userRow['id']);
            return true;
        }else {
            throw new \Exception('Invalid credentials!!!');
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getInfo($id) {
        $result = $this->getDb()->prepare("
            SELECT
            id, username, password, full_name, email, age
            FROM users
            WHERE id = ?
        ");

        $result->execute([ $id ]);
        if($result->rowCount() < 0) {
            throw new \Exception('User with such id does not exists');
        }
        return $result->fetch();
    }

    private function setIdInSession($id) {
        $_SESSION['id'] = $id;
    }

    /**
     * @param $username
     * @return bool
     */
    private function exists($username) {
        $result = $this->getDb()->prepare("SELECT id FROM users WHERE username = ?");
        $result->execute([$username]);
        return $result->rowCount() > 0;
    }
}