<?php
/**
 * Created by PhpStorm.
 * User: Krisss
 * Date: 02.10.2015
 * Time: 11:27
 */

namespace EShop\Models\BindModels;


use EShop\Models\IBindingModel;

class DeleteCategoryBindingModel implements IBindingModel
{
    private $_categoryId;

    public function __construct($bindingModel)
    {
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
}