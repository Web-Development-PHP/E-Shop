<?php

namespace EShop\Models\BindModels;

use EShop\Models\IBindingModel;

class AddProductBindingModel implements IBindingModel
{
    private $_productName;
    private $_productPrice;
    private $_categoryId;
    private $_quantity;

    public function __construct($bindingModel)
    {
        $this->setProductName($bindingModel['productName']);
        $this->setProductPrice($bindingModel['productPrice']);
        $this->setCategoryId($bindingModel['categoryId']);
        $this->setQuantity($bindingModel['quantity']);
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
}