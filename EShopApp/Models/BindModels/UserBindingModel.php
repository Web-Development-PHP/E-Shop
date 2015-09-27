<?php

namespace EShop\Models\BindModels;


class UserBindingModel
{
    private $_username;
    private $_password;
    private $_email;
    private $_fullName;
    private $_age;
    private $_role = null;
    private $_cash = null;

    public function __construct($bindingData){
        $this->setUsername($bindingData['username']);
        $this->setPassword($bindingData['password']);
        $this->setEmail($bindingData['email']);
        $this->setFullName($bindingData['full_name']);
        $this->setAge($bindingData['age']);
    }

    public function getFullName()
    {
        return $this->_fullName;
    }

    public function setFullName($fullName)
    {
        $this->_fullName = $fullName;
    }

    public function getAge()
    {
        return $this->_age;
    }

    public function setAge($age)
    {
        $this->_age = $age;
    }

    public function getUsername(){
        return $this->_username;
    }
    public function setUsername($value){
        $this->_username = $value;
    }

    public function getPassword(){
        return $this->_password;
    }
    public function setPassword($value){
        $this->_password = $value;
    }

    public function getEmail(){
        return $this->_email;
    }
    public function setEmail($value){
        $this->_email = $value;
    }

    public function getRole(){
        return $this->_role;
    }
    public function setRole($value){
        $this->_role = $value;
    }

    public function getCash(){
        return $this->_cash;
    }
    public function setCash($value){
        $this->_cash = $value;
    }
}