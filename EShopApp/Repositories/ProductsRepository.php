<?php

namespace EShop\Repositories;


use EShop\Config\DatabaseConfig;
use EShop\Core\Database;
use EShop\Models\BindModels\AddProductBindingModel;
use EShop\Models\Product;

class ProductsRepository implements IRepository
{
    /**
     * @var Database
     */
    protected $db;
    const PRODUCTS_TABLENAME = 'products';
    const USERS_PRODUCTS_TABLENAME = 'users_products';

    public function __construct()
    {
        $this->db = \EShop\Core\Database::getInstance(DatabaseConfig::DB_INSTANCE);
    }

    public function findById($id)
    {
        $data = $this->db->getEntityById(self::PRODUCTS_TABLENAME, $id);
        if($data == null) {
            throw new \Exception("Product with such id does not exists");
        }
        $product = new Product($data);
        return $product;
    }

    public function sellProduct($productId)
    {
        $product = $this->findById($productId);
        $quantity = intval($product->getQuantity()) - 1;
        $isUpdated = $this->db->updateEntityById(self::PRODUCTS_TABLENAME, array(
            'quantity' => $quantity
        ), $productId);
        return $isUpdated;
    }

    public function removeProductFromUser($userId, $productId) {
        $isDeleted = $this->db->deleteProductFromUser($userId, $productId);
        return $isDeleted;
    }

    public function transferProductToUser($userId, $productId) {
        $isCreated = $this->db->insertEntity(self::USERS_PRODUCTS_TABLENAME, array(
            'user_id' => $userId,
            'product_id' => $productId
        ));
        return $isCreated;
    }

    public function create(AddProductBindingModel $model)
    {
        $isCreated = $this->db->insertEntity(self::PRODUCTS_TABLENAME, array(
            'name' =>$model->getProductName(),
            'category_id' =>$model->getCategoryId(),
            'quantity' =>$model->getQuantity(),
            'price' =>$model->getProductPrice()
        ));
        return $isCreated;
    }

    public function remove($id)
    {
        // TODO: Implement remove() method.
    }
}