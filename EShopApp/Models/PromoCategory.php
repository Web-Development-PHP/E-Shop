<?php

namespace EShop\Models;


class PromoCategory extends BaseModel
{
    private $_id;
    private $_categoryId;
    private $_categoryName;
    private $_discount;
    private $_promotedAt;

    public function __construct($bindingModel)
    {
        $this->setId($bindingModel['id']);
        $this->setCategoryId($bindingModel['category_id']);
        $this->setCategoryName($bindingModel['category_name']);
        $this->setDiscount($bindingModel['discount']);
        $this->setPromotedAt($bindingModel['promotedAt']);
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
    public function getCategoryName()
    {
        return $this->_categoryName;
    }

    /**
     * @param mixed $categoryName
     */
    public function setCategoryName($categoryName)
    {
        $this->_categoryName = $categoryName;
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