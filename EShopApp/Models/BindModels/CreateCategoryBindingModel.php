<?php
/**
 * Created by PhpStorm.
 * User: Krisss
 * Date: 28.09.2015
 * Time: 19:19
 */

namespace EShop\Models\BindModels;

use EShop\Models\IBindingModel;

class CreateCategoryBindingModel implements IBindingModel
{
    private $_name;
    protected $_products = [];

    public function __construct($data) {
        $this->setName($data['name']);
        $this->setProducts($data['products']);
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

    /**
     * @return array
     */
    public function getProducts()
    {
        return $this->_products;
    }

    /**
     * @param array $products
     */
    public function setProducts($products)
    {
        $this->_products = $products;
    }
}