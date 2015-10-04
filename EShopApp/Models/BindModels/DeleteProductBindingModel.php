<?php

namespace EShop\Models\BindModels;

use EShop\Models\IBindingModel;

class DeleteProductBindingModel implements IBindingModel
{
    private $_productId;
    protected $_categoryId;
    public function __construct($bindingModel)
    {
        $this->setProductId($bindingModel['productId']);
        $this->setCategoryId($bindingModel['categoryId']);
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
}