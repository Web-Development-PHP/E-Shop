<?php

namespace EShop\Repositories;


use EShop\Config\DatabaseConfig;
use EShop\Core\Database;
use EShop\Exceptions\InvalidUserOperationException;
use EShop\Models\BindModels\AddProductBindingModel;
use EShop\Models\BindModels\EditProductBindingModel;
use EShop\Models\Product;
use EShop\Models\ProductPromo;
use EShop\Models\ProductsPromo;
use EShop\Models\SoldProduct;

class ProductsRepository implements IRepository
{
    /**
     * @var Database
     */
    protected $db;
    const PRODUCTS_TABLENAME = 'products';
    const USERS_PRODUCTS_TABLENAME = 'users_products';
    const ALL_PRODUCTS_PROMO_TABLENAME = 'allproducts_promotion';
    const PRODUCTS_PROMO_TABLENAME = 'products_promotion';

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

    public function update(EditProductBindingModel $model)
    {
        $productId = $model->getProductId();
        $isUpdated = $this->db->updateEntityById(self::PRODUCTS_TABLENAME, array(
            'name' => $model->getProductName(),
            'category_id' => $model->getCategoryId(),
            'quantity' => $model->getQuantity()
        ), $productId);
        return $isUpdated;
    }

    public function getAll()
    {
        $data = $this->db->getAllEntities(self::PRODUCTS_TABLENAME, 'name');
        $data = array_filter($data, function($d) {
            return $d['is_sold'] == 0;
        });
        $products = [];
        foreach ($data as $p) {
            $product = new Product($p);
            $product->setName($p['name']);
            array_push($products, $product);
        }
        return $products;
    }

    public function isProductOnPromotion($productId)
    {
        $isOnPromo = $this->db->getEntityById(self::PRODUCTS_PROMO_TABLENAME, $productId);
        if($isOnPromo) {
            return true;
        }
        return false;
    }

    public function putPromotionOnProduct($productId, $discount)
    {
        $product = $this->db->getEntityById(self::PRODUCTS_TABLENAME, $productId);
        $priceWithDiscount = $product['price'] - ($product['price'] * ($discount / 100));

        $isUpdated = $this->db->updateEntityById(self::PRODUCTS_TABLENAME, array(
            "price" => $priceWithDiscount
        ), $productId);
        if(!$isUpdated) {
            throw new InvalidUserOperationException("Could not promote product");
        }
        $isAdded = $this->db->insertEntity(self::PRODUCTS_PROMO_TABLENAME, array(
            "discount" => $discount,
            "product_id" => $productId,
            "product_name" => $product['name']
        ));
        return $isAdded;
    }

    public function allCertainProductsInPromotion()
    {
        $data = $this->db->getAllEntities(self::PRODUCTS_PROMO_TABLENAME, 'promotedAt');
        $products = [];
        foreach ($data as $p) {
            $product = new ProductPromo($p);
            array_push($products, $product);
        }
        return $products;
    }

    public function allProductsPromotionAvailable()
    {
        $hasPromotion = $this->db->getAllEntities(self::ALL_PRODUCTS_PROMO_TABLENAME, 'id');
        if($hasPromotion) {
            return true;
        }
        return false;
    }

    public function getAllProductsPromotion()
    {
        $promotion = $this->db->getAllEntities(self::ALL_PRODUCTS_PROMO_TABLENAME, 'id');
        $promotions = [];
        foreach ($promotion as $p) {
            $promo = new ProductsPromo($p);
            array_push($promotions, $promo);
        }
        return $promotions;
    }

    public function putAllProductsOnPromotion($discount)
    {
        $allProducts = $this->getAll();
        foreach ($allProducts as $product) {
            $priceWithDiscount = $product->getPrice() - ($product->getPrice() * ($discount / 100));
            $isUpdated = $this->db->updateEntityById(self::PRODUCTS_TABLENAME, array(
                "price" =>$priceWithDiscount
            ), $product->getId());
            if(!$isUpdated) {
                throw new InvalidUserOperationException("Invalid operation");
            }
        }
        if($isUpdated) {
            $isAdded = $this->db->insertEntity(self::ALL_PRODUCTS_PROMO_TABLENAME, array(
                "discount" => $discount
            ));
        }
        return $isAdded;
    }

    public function removeAllProductsDiscount($id)
    {
        $condition = "id=$id";
        $promotion = $this->db->getAllEntitiesWithCondition(self::ALL_PRODUCTS_PROMO_TABLENAME, $condition, 'id');
        $discount = $promotion[0]['discount'];

        $allProducts = $this->db->getAllEntities(self::PRODUCTS_TABLENAME, 'id');
        foreach ($allProducts as $product) {
            $restoredPrice = $product['price'] + ($product['price'] * ($discount / 100));
            $isUpdated = $this->db->updateEntityById(self::PRODUCTS_TABLENAME,array(
                "price" => $restoredPrice
            ), $product['id']);
            if(!$isUpdated) {
                throw new InvalidUserOperationException("Error during remove promo");
            }
        }

        if($isUpdated) {
            $isDeleted = $this->db->deleteEntityById(self::ALL_PRODUCTS_PROMO_TABLENAME, $id);
        }
        return $isDeleted;
    }

    public function removeProductFromPromotion($id){
        $condition = "id=$id";
        $promotion = $this->db->getAllEntitiesWithCondition(self::PRODUCTS_PROMO_TABLENAME, $condition, 'id');
        $discount = $promotion[0]['discount'];
        var_dump($promotion);
        $product = $this->db->getEntityById(self::PRODUCTS_TABLENAME, $promotion[0]['product_id']);
        $restoredPrice = $product['price'] + ($product['price'] * ($discount / 100));

        $isUpdated = $this->db->updateEntityById(self::PRODUCTS_TABLENAME, array(
            "price" => $restoredPrice
        ), $product['id']);
        if(!$isUpdated) {
            throw new InvalidUserOperationException("Error during remove promo");
        }
        if($isUpdated) {
            $isDeleted = $this->db->deleteEntityById(self::PRODUCTS_PROMO_TABLENAME, $id);
        }
        return $isDeleted;
    }

    public function getSoldProducts()
    {
        $condition = "quantity < 0";
        $data = $this->db->getAllEntitiesWithCondition(self::PRODUCTS_TABLENAME, $condition, 'id');
        $soldProducts = [];
        foreach ($data as $p) {
            $product = new SoldProduct($p);
            array_push($soldProducts, $product);
        }
        return $soldProducts;
    }

    public function reorderProduct($productId, $reorderQuantity)
    {
        $isUpdated = $this->db->updateEntityById(self::PRODUCTS_TABLENAME, array(
            "quantity" => $reorderQuantity
        ), $productId);
        return $isUpdated;
    }

    public function remove($id)
    {
        $isDeleted = $this->db->updateEntityById(self::PRODUCTS_TABLENAME, array(
            "is_sold" => 1
        ), $id);
        return $isDeleted;
    }
}