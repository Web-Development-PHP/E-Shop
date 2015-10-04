<?php
/**
 * Created by PhpStorm.
 * User: Krisss
 * Date: 28.09.2015
 * Time: 19:11
 */

namespace EShop\Repositories;
use EShop\Config\DatabaseConfig;
use EShop\Core\Database;
use EShop\Exceptions\InvalidUserOperationException;
use EShop\Models\BindModels\CreateCategoryBindingModel;
use EShop\Models\BindModels\UpdateCategoryBindingModel;
use EShop\Models\Category;
use EShop\Models\Product;
use EShop\Models\PromoCategory;


class CategoriesRepository implements IRepository
{
    /**
     * @var Database
     */
    protected $db;
    const CATEGORIES_TABLENAME = 'categories';
    const PRODUCTS_TABLENAME = 'products';
    const PROMO_CATEGORIES_TABLENAME = 'categories_promotions';

    public function __construct() {
        $this->db = \EShop\Core\Database::getInstance(DatabaseConfig::DB_INSTANCE);
    }

    public function getAllProducts($userid, $cartId, $categoryId) {
        $data = $this->db->getAvailableProductsInCategory($userid, $cartId, $categoryId);
        $categoryProducts = [];
        foreach ($data as $prod) {
            $product = new Product($prod);
            if($product->getIsSold() == 0 ) {
                array_push($categoryProducts, $product);
            }
        }
        return $categoryProducts;
    }

    public function all() {
        $data = $this->db->getAllEntities(self::CATEGORIES_TABLENAME, 'name');
        $data = array_filter($data, function($d) {
            return $d['isDeleted'] == 0;
        });
        $categories = [];
        foreach ($data as $cat) {
            $category = new Category($cat);
            array_push($categories, $category);
        }
        return $categories;
    }

    public function findById($id) {
        $data = $this->db->getEntityById(self::CATEGORIES_TABLENAME, $id);
        if($data == null) {
            return null;
        }
        $category = new Category($data);

        return $category;
    }


    public function remove($id)
    {
        $cat = $this->findById($id);
        if($cat == null) {
            throw new \Exception("category with such id does not exist!");
        }
        $isDeleted = $this->db->updateEntityById(
            self::CATEGORIES_TABLENAME,
            array('isDeleted' => 1),
            $id
        );
        return $isDeleted;
    }

    public function create(CreateCategoryBindingModel $model)
    {
        $condition = "name='{$model->getName()}'";
        $alreadyExists = $this->db->getAllEntitiesWithCondition(self::CATEGORIES_TABLENAME, $condition, 'id');

        if($alreadyExists) {
            $isUpdated = $this->db->updateEntityById(self::CATEGORIES_TABLENAME, array(
                "isDeleted" => 0
            ), $alreadyExists[0]['id']);
            return $isUpdated;
        }
        $isCreated = $this->db->insertEntity(self::CATEGORIES_TABLENAME, array(
            'name' => $model->getName()
        ));

        return $isCreated;
    }

    public function update($id, UpdateCategoryBindingModel $model)
    {
        $isUpdated = $this->db->updateEntityById(
            self::CATEGORIES_TABLENAME,
            array('name' => $model->getName()),
            $id
        );
        return $isUpdated;
    }

    public function putCategoryProductsOnPromotion($categoryId, $discount, $categoryName)
    {
        $productsInCategory = $this->db->getAllEntitiesWithCondition(self::PRODUCTS_TABLENAME,
            "category_id=$categoryId", 'id');
        foreach ($productsInCategory as $product) {
            $priceWithDiscount = $product['price'] - ($product['price'] * ($discount / 100));
            $isUpdated = $this->db->updateEntityById(self::PRODUCTS_TABLENAME,array(
                "price" => $priceWithDiscount
            ), $product['id']);
        }
        if($isUpdated) {
            $isAdded = $this->db->insertEntity(self::PROMO_CATEGORIES_TABLENAME, array(
                "category_id" => $categoryId,
                "discount" => $discount,
                "category_name" => $categoryName
            ));
        }
        return $isAdded;
    }

    public function hasPromotions($categoryId)
    {
        $condition = "category_id = $categoryId AND isInPromotion=1";
        $hasPromotions = $this->db
            ->getAllEntitiesWithCondition(self::PROMO_CATEGORIES_TABLENAME, $condition, 'promotedAt');
        if($hasPromotions) {
            return true;
        }
        return false;
    }

    public function removeDiscountOnCategory($categoryId)
    {
        $condition = 'category_id = '.$categoryId;
        $categoryPromotion = $this->db
            ->getAllEntitiesWithCondition(self::PROMO_CATEGORIES_TABLENAME, $condition, 'promotedAt');
        $discount = $categoryPromotion[0]['discount'];

        $productsInCategory = $this->db->getAllEntitiesWithCondition(self::PRODUCTS_TABLENAME,
            "category_id=$categoryId", 'id');
        foreach ($productsInCategory as $product) {
            $restoredPrice = $product['price'] + ($product['price'] * ($discount / 100));

            $isUpdated = $this->db->updateEntityById(self::PRODUCTS_TABLENAME,array(
                "price" => $restoredPrice
            ), $product['id']);

        }
        if($isUpdated) {
            $remove = $this->db
                ->deleteEntityById(self::PROMO_CATEGORIES_TABLENAME, $categoryPromotion[0]['id']);
        }
        return $remove;
    }

    public function getPromotionsForCategories()
    {
        $promotions = $this->db->getAllEntities(self::PROMO_CATEGORIES_TABLENAME, 'promotedAt');
        $categoriesPromos = [];
        foreach ($promotions as $promo) {
            $promoCategory = new PromoCategory($promo);
            if($promo['isInPromotion'] == '1' ){
                array_push($categoriesPromos, $promoCategory);
            }
        }
        return $categoriesPromos;
    }
}