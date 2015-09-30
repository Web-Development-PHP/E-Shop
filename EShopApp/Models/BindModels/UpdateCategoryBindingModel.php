<?php
/**
 * Created by PhpStorm.
 * User: Krisss
 * Date: 28.09.2015
 * Time: 19:25
 */

namespace EShop\Models\BindModels;


use EShop\Models\IBindingModel;

class UpdateCategoryBindingModel implements IBindingModel
{
    private $_name;

    public function __construct($data) {
        $this->setName($data['name']);
    }
    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }


}