<?php

namespace EShop\ViewModels;

class UserViewModel extends ViewModel
{
    private $_username;
    private $_password;
    private $_email;
    private $_fullName;
    private $_age;
    private $_cash = null;

    public function __construct($viewData){
        $this->setUsername($viewData['username']);
        $this->setEmail($viewData['email']);
        $this->setFullName($viewData['full_name']);
        $this->setAge($viewData['age']);
        $this->setCash($viewData['cash']);
    }


    public function getUsername()
    {
        return $this->_username;
    }

    public function setUsername($username)
    {
        $this->_username = $username;
    }

    public function getPassword()
    {
        return $this->_password;
    }


    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->_email = $email;
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

    public function getCash()
    {
        return $this->_cash;
    }
    public function setCash($cash)
    {
        $this->_cash = $cash;
    }




    public function render()
    {
        // TODO: Implement render() method.
    }
}