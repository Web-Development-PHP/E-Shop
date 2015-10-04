<?php

namespace EShop\Models\BindModels;

use EShop\Models\IBindingModel;

class AddCategoryPromoBindingModel implements IBindingModel
{
    private $_categoryId;
    private $_discount;

    public function __construct($bindingModel)
    {
        $this->setCategoryId($bindingModel['categoryId']);
        $this->setDiscount($bindingModel['discount']);
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