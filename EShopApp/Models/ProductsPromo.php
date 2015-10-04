<?php

namespace EShop\Models;


class ProductsPromo extends BaseModel
{
    private $_id;
    private $_discount;
    private $_promotedAt;

    public function __construct($data)
    {
        $this->setId($data['id']);
        $this->setDiscount($data['discount']);
        $this->setPromotedAt($data['promotedAt']);
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
}