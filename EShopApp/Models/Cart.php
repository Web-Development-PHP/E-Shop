<?php

namespace EShop\Models;

class Cart
{
    private $_id;
    private $_cartOwner;
    private $_productId;
    private $_productName;
    private $_productPrice;

    public function __construct($data){
        $this->setId($data['id']);
        $this->setCartOwner($data['username']);
        $this->setProductId($data['productId']);
        $this->setProductName($data['name']);
        $this->setProductPrice($data['price']);
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
    public function getCartOwner()
    {
        return $this->_cartOwner;
    }

    /**
     * @param mixed $cartOwner
     */
    public function setCartOwner($cartOwner)
    {
        $this->_cartOwner = $cartOwner;
    }

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->_productId;
    }

    /**
     * @param mixed $productId
     */
    public function setProductId($productId)
    {
        $this->_productId = $productId;
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

    /**
     * @return mixed
     */
    public function getProductPrice()
    {
        return $this->_productPrice;
    }

    /**
     * @param mixed $productPrice
     */
    public function setProductPrice($productPrice)
    {
        $this->_productPrice = $productPrice;
    }
}