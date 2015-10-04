<?php

namespace EShop\Models\BindModels;


use EShop\Models\IBindingModel;

class ReorderProductBindingModel implements IBindingModel
{
    private $_productId;
    private $_quantity;


    public function __construct($bindingModel)
    {
        $this->setProductId($bindingModel['productId']);
        $this->setQuantity($bindingModel['quantity']);
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
}