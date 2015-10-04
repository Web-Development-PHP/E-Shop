<?php
/**
 * Created by PhpStorm.
 * User: Krisss
 * Date: 02.10.2015
 * Time: 18:31
 */

namespace EShop\Models\BindModels;

use EShop\Models\IBindingModel;

class EditProductBindingModel implements IBindingModel
{
    private $_productName;
    private $_productId;
    private $_quantity;
    private $_categoryId;

    public function __construct($bindingModel)
    {
        $this->setProductId($bindingModel['productId']);
        $this->setProductName($bindingModel['productName']);
        $this->setCategoryId($bindingModel['categoryId']);
        $this->setQuantity($bindingModel['quantity']);
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