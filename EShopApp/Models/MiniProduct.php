<?php

namespace EShop\Models;

class MiniProduct
{
    private $_id;
    private $_userId;
    private $_username;
    private $_price;
    private $_productName;
    private $_categoryName;
    private $_categoryId;

    public function __construct($data)
    {
        $this->setId($data['productId']);
        $this->setUserId($data['userId']);
        $this->setUsername($data['username']);
        $this->setPrice($data['productPrice']);
        $this->setProductName($data['productName']);
        $this->setCategoryName($data['categoryName']);
        $this->setCategoryId($data['categoryId']);
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
    public function getUserId()
    {
        return $this->_userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->_userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->_username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->_username = $username;
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
    public function getProductName()
    {
        return $this->_productName;
    }

    /**
     * @param mixed $productName
     */
    public function setProductName($productName)
    {
        $this->_productName = $productName;
    }
}