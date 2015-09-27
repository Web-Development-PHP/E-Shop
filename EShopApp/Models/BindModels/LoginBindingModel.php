<?php
/**
 * Created by PhpStorm.
 * User: Krisss
 * Date: 27.09.2015
 * Time: 13:27
 */

namespace EShop\Models\BindModels;


class LoginBindingModel
{
    private $_username;
    private $_password;

    public function __construct($bindingData){
        $this->setUsername($bindingData['username']);
        $this->setPassword($bindingData['password']);
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
}