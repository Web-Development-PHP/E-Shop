<?php
/**
 * Created by PhpStorm.
 * User: Krisss
 * Date: 02.10.2015
 * Time: 17:00
 */

namespace EShop\Models;


class AjaxTest extends BaseModel
{
    private $_name;
    private $_email;

    public function __construct($data)
    {
        $this->setName($data['Name']);
        $this->setEmail($data['Email']);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * @return mixed
     */
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


}