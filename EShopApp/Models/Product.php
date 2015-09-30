<?php

namespace EShop\Models;

class Product
{
    private $_id;
    private $_name;
    private $_categoryId;
    private $_quantity;
    private $_price;
    private $_isSold;
    private $_categoryName;

    public function __construct($data){
        $this->setId($data['id']);
        $this->setName($data['productName']);
        $this->setCategoryId($data['category_id']);
        $this->setCategoryName($data['categoryName']);
        $this->setQuantity($data['quantity']);
        $this->setPrice($data['price']);
        $this->setIsSold($data['is_sold']);
    }

    /**
     * @return mixed
     */
    public function getCategoryName()
    {
        return $this->_categoryName;
    }

    /**
     * @param mixed $categoryName
     */
    public function setCategoryName($categoryName)
    {
        $this->_categoryName = $categoryName;
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
    public function getCategoryId()
    {
        return $this->_categoryId;
    }

    /**
     * @param mixed $categoryId
     */
    public function setCategoryId($categoryId)
    {
        $this->_categoryId = $categoryId;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->_quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity)
    {
        $this->_quantity = $quantity;
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
    public function getIsSold()
    {
        return $this->_isSold;
    }

    /**
     * @param mixed $isSold
     */
    public function setIsSold($isSold)
    {
        $this->_isSold = $isSold;
    }
}