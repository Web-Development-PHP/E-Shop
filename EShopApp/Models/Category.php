<?php

namespace EShop\Models;

class Category extends BaseModel
{
    private $_id;
    private $_name;
    private $_products = [];

    /**
     * Category constructor.
     * @param $_id
     * @param $_name
     * @param array $_products
     */
    public function __construct($data)
    {
        $this->setId($data['id']);
        $this->setName($data['name']);
        $this->setProducts($data['products']);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->_id = $id;
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