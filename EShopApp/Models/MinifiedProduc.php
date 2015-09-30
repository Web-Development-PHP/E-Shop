<?php
/**
 * Created by PhpStorm.
 * User: Krisss
 * Date: 29.09.2015
 * Time: 17:44
 */

namespace EShop\Models;

class MinifiedProduct extends BaseModel
{
    private $_id;
    private $_price;
    private $_name;

    public function __construct($data)
    {
        $this->setId($data['id']);
        $this->setName($data['price']);
        $this->setName($data['name']);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->_price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->_price = $price;
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
}