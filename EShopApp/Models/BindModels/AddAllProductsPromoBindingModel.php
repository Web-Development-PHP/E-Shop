<?php


namespace EShop\Models\BindModels;


use EShop\Models\IBindingModel;

class AddAllProductsPromoBindingModel implements IBindingModel
{
    private $_discount;

    public function __construct($bindingModel){
        $this->setDiscount($bindingModel['discount']);
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