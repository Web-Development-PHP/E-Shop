<?php
/**
 * Created by PhpStorm.
 * User: Krisss
 * Date: 30.09.2015
 * Time: 18:30
 */

namespace EShop\Repositories;


use EShop\Config\DatabaseConfig;
use EShop\Core\Database;
use EShop\Models\Cart;

class CartsRepository implements IRepository
{
    /**
     * @var Database
     */
    protected $db;
    const CARTS_TABLENAME = 'usercart';
    const CART_PRODUCTS_TABLENAME = 'cart_products';

    public function __construct()
    {
        $this->db = \EShop\Core\Database::getInstance(DatabaseConfig::DB_INSTANCE);
    }

    public function create($userId)
    {
        $isCreated = $this->db->insertEntity(self::CARTS_TABLENAME, array(
            'user_id' => $userId
        ));
        return $isCreated;
    }
    /**
     * @param $id - userId
     * @return array with items in cart for current user
     */
    public function findById($id)
    {
        $data = $this->db->getUserCart($id);
        $cartItems = [];
        foreach ($data as $c) {
            $cart = new Cart($c);
            array_push($cartItems, $cart);
        }
        return $cartItems;
    }

    /**
     * @param $userId
     * @return mixed cart id
     * @throws \Exception
     */
    public function getCartForCurrentUser($userId)
    {
        $cartId = $this->db->getCartByUserId($userId);
        if($cartId == null || $cartId['id'] == null) {
            throw new \Exception("This user does not have a cart.");
        }
        return $cartId['id'];
    }

    public function addToCart($cartId, $productId)
    {
        $isAdded = $this->db->insertEntity(self::CART_PRODUCTS_TABLENAME, array(
            'cart_id' => $cartId,
            'product_id' => $productId
        ));
        return $isAdded;
    }

    public function getProductsInCart($cartId)
    {
        $cartProducts = $this->db->getProductsInCart($cartId);
        return $cartProducts;
    }

    public function isProductInCart($cartId, $productId)
    {
        $isInCart = $this->db->isProductInCart($cartId, $productId);
        return $isInCart;
    }

    public function removeProductsFromCart($cartId, $productId)
    {
        $isRemoved = $this->db->deleteProductFromCart($cartId, $productId);
        return $isRemoved;
    }

    public function remove($id)
    {
        // TODO: Implement remove() method.
    }
}