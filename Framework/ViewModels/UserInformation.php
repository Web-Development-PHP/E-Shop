<?php

namespace EShop\ViewModels;
class UserInformation
{
    private $id;
    private $user;
    private $pass;
    private $email;
    private $fullName;
    private $age;

    public function __construct($user, $id = null, $fullName = null, $email = null, $age) {
        $this->setId($id)
            ->setUsername($user)
            ->setFullName($fullName)
            ->setEmail($email)
            ->setAge($age);
    }

    private function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    private function setUsername($user)
    {
        $this->user = $user;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    private function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }


    public function getFullName()
    {
        return $this->fullName;
    }

    private function setFullName($fullName)
    {
        $this->fullName = $fullName;
        return $this;
    }

    public function getAge()
    {
        return $this->age;
    }

    private function setAge($age)
    {
        $this->age = $age;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->user;
    }

    public function getPass()
    {
        return $this->pass;
    }
}