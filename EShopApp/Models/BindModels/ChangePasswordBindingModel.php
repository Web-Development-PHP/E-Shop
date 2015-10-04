<?php
/**
 * Created by PhpStorm.
 * User: Krisss
 * Date: 03.10.2015
 * Time: 22:38
 */

namespace EShop\Models\BindModels;


use EShop\Models\IBindingModel;

class ChangePasswordBindingModel implements IBindingModel
{
    private $_newPassword;
    private $_confirmPassword;

    public function __construct($bindingModel)
    {
        $this->setNewPassword($bindingModel['newPassword']);
        $this->setConfirmPassword($bindingModel['confirmPassword']);
    }

    /**
     * @return mixed
     */
    public function getNewPassword()
    {
        return $this->_newPassword;
    }

    /**
     * @param mixed $newPassword
     */
    public function setNewPassword($newPassword)
    {
        $this->_newPassword = $newPassword;
    }

    /**
     * @return mixed
     */
    public function getConfirmPassword()
    {
        return $this->_confirmPassword;
    }

    /**
     * @param mixed $confirmPassword
     */
    public function setConfirmPassword($confirmPassword)
    {
        $this->_confirmPassword = $confirmPassword;
    }
}