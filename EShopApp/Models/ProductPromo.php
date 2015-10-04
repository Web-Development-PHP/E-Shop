<?php

namespace EShop\Models;


class ProductPromo extends BaseModel
{
    private $_id;
    private $_discount;
    private $_promotedAt;
    private $_productId;
    private $_productName;

    public function __construct($data)
    {
        $this->setId($data['id']);
        $this->setDiscount($data['discount']);
        $this->setPromotedAt($data['promotedAt']);
        $this->setProductId($data['product_id']);
        $this->setProductName($data['product_name']);
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

    /**
     * @return mixed
     */
    public function getPromotedAt()
    {
        return $this->_promotedAt;
    }

    /**
     * @param mixed $promotedAt
     */
    public function setPromotedAt($promotedAt)
    {
        $this->_promotedAt = $promotedAt;
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
}