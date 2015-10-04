<?php

namespace EShop\Models\BindModels;

use EShop\Models\IBindingModel;

class AddProductPromoBindingModel implements IBindingModel
{
    private $_productId;
    private $_discount;

    public function __construct($bindingMode)
    {
        $this->setProductId($bindingMode['productId']);
        $this->setDiscount($bindingMode['discount']);
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
    public function getDiscount()
    {
        return $this->_discount;
    }

    /**
     * @param mixed $discount
     */
    public function setDiscount($discount)
    {
        $this->_discount = $discount;
    }
}