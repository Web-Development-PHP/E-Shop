<?php

namespace EShop\Controllers;

use EShop\Config\RouteConfig;
use EShop\Helpers\RouteService;
use EShop\Models\BindModels;
use EShop\Models\User;
use EShop\Repositories\UsersRepository;
use EShop\Services\ElectronicShopData;
use EShop\View;
use EShop\ViewModels\ProfileViewModel;
use EShop\ViewModels\UserCartViewModel;
use EShop\ViewModels\UserProductsViewModel;
use EShop\ViewModels\UserViewModel;

/**
 * Class AccountController
 * @package EShop\Controllers
 */
class AccountController extends Controller
{
    /**
     * @var ElectronicShopData
     */
    private $_eshopData;
    const DEFAULT_USER_CASH = 150.00;   // Initial cash
    const DEFAULT_USER_ROLE = 2;        // Editor user role
    const ADMIN_ROLE = 'Admin';
    const EDITOR_ROLE = 'Editor';
    const GUEST_ROLE = 'Guest';

    public function __construct() {
        parent::__construct();
        $this->_eshopData = new ElectronicShopData();
    }

    public function index() {
    }

    /**
     * @Authorize
     */
    public function profile() {
//        $this->isInRole();
        $currentUser = $this->_eshopData->getUsersRepository()->findById($this->getCurrentUserId());
        if($currentUser != null) {
            $viewModel = new ProfileViewModel();
            $viewModel->userViewModel = $currentUser;
            $viewModel->userViewModel->setRoleName($this->getUserRoleName($currentUser->getRole()));
            $this->escapeAll($viewModel);
            $viewModel->render();
        }
    }

    /**
     * @param BindModels\RegisterBindingModel $userModel
     * @Route("register")
     */
    public function registerUser(BindModels\RegisterBindingModel $userModel) {

        $userModel->setCash(self::DEFAULT_USER_CASH);
        $userModel->setRole(self::DEFAULT_USER_ROLE);

        $isRegistered = $this->_eshopData->getUsersRepository()->create($userModel);
        if($isRegistered) {
            $user = $this->_eshopData->getUsersRepository()->findByUsername($userModel->getUsername());
            $this->_eshopData->getCartsRepository()->create($user->getId());
            $data = [
                "username" => $userModel->getUsername(),
                "password" => $userModel->getPassword()
            ];
            $loginDetails = new BindModels\LoginBindingModel($data);
            $this->loginUser($loginDetails);
        }
        //TODO throw more meaningful error message
        echo 'Register failed';
    }

    /**
     * @param BindModels\LoginBindingModel $loginBindingModel
     * @throws \Exception
     * @Route("login")
     */
    public function loginUser(BindModels\LoginBindingModel $loginBindingModel) {
        $this->isModelStateValid($loginBindingModel);
        var_dump($loginBindingModel);
        $username = $loginBindingModel->getUsername();
        $password = $loginBindingModel->getPassword();

        $user = $this->_eshopData->getUsersRepository()->findByUsername($username);
        if(!password_verify($password, $user->getPassword())){
            throw new \Exception('Invalid credentials');
        }
        $_SESSION['role'] = $this->getUserRoleName($user->getRole());
        $this->setIdInSession($user->getId());
        RouteService::redirect('account', 'profile', true);
    }

    public function logout() {
       if($this->isLogged()) {
           session_unset();
           session_destroy();
           RouteService::redirect('home', 'index', true);
       }
    }

    /**
     * @Authorize
     */
    public function viewCart() {
        $userId = $this->getCurrentUserId();
        $user = $this->_eshopData->getUsersRepository()->findById($userId);
        if($user == null) {
            throw new \Exception("Invalid user id");
        }
        $cartItems = $this->_eshopData->getCartsRepository()->findById($userId);
        if($cartItems) {
            $this->escapeAll($cartItems);
            $viewModel = new UserCartViewModel();
            $viewModel->cart = $cartItems;
            $viewModel->render();
        }
    }

    public function addToCart($productId) {
        $userId = $this->getCurrentUserId();
        $user = $this->_eshopData->getUsersRepository()->findById($userId);
        if($user == null) {
            throw new \Exception("Invalid user id");
        }
        $cartId = $this->_eshopData->getCartsRepository()->getCartForCurrentUser($userId);

        $product = $this->_eshopData->getProductsRepository()->findById($productId);
        if($product->getQuantity() <= 0) {
            throw new \Exception("There is no quantity left of current product. We're sorry");
        }
        //CART ALREADY HAS THIS PRODUCT
        $isProductInCart = $this->_eshopData->getCartsRepository()->isProductInCart($cartId, $productId);
        if($isProductInCart) {
            throw new \Exception("You already added product to your cart");
        }
        $isAdded = $this->_eshopData->getCartsRepository()->addToCart($cartId, $productId);
        if($isAdded) {
            // TODO ADD SUCCESS MSG (WITH NOTY)
            RouteService::redirect('categories', 'products/' . $product->getCategoryId(), true);
        }
        echo 'failed to added product to cart';
    }

    public function checkoutCart($cartId)
    {
        $userId = $this->getCurrentUserId();
        $user = $this->_repository->findById($userId);
        if($user == null) {
            throw new \Exception("Invalid user id");
        }

        // CART BELONGS TO CURRENT USER
        $userCartId = $this->_eshopData->getCartsRepository()->getCartForCurrentUser($userId);
        if($userCartId != $cartId) {
            throw new \Exception("You cannot check out another user cart");
        }
        // GET PRODUCTS IN CART
        $cartProducts = $this->_eshopData->getCartsRepository()->getProductsInCart($cartId);
        if(!$cartProducts) {
            throw new \Exception("You dont have any products in your cart.");
        }
        // CHECK IF TOTAL SUM OF PRODUCTS IS LESS THAN USER CASH
        $cartProductsTotalSum = $this->getProductsTotalSum($cartProducts);
        if($cartProductsTotalSum > $user->getCash()) {
            throw new \Exception("You do not have enough cash to buy all the products in your cart.");
        }
        // UPDATE USER CASH
        $isCashUpdated = $this->_eshopData->getUsersRepository()->purchaseItems($userId, $cartProductsTotalSum);
        if(!$isCashUpdated) {
            throw new \Exception("Error during checkout cart. Sorry for the inconvenience. Please try again.");
        }
        if($isCashUpdated) {
            // UPDATE PRODUCT QUANTITY
            foreach ($cartProducts as $product) {
                $isProductsQuantityUpdated = $this->_eshopData->getProductsRepository()->sellProduct($product['id']);
                if(!$isProductsQuantityUpdated) {
                    throw new \Exception("Product with name [{$product['name']}] does not have enough quantity left.");
                }
            }
        }
        if($isProductsQuantityUpdated) {
            // TRANSFER PRODUCTS TO USER_PRODUCTS
            foreach ($cartProducts as $product) {
                $areProductsSuccessfullyTransferedToUser =
                    $this->_eshopData
                        ->getProductsRepository()
                        ->transferProductToUser($userId, $product['id']);
                if(!$areProductsSuccessfullyTransferedToUser) {
                    throw new \Exception("You already have product {$product['name']} in your products inventory");
                }
            }
        }
        if($areProductsSuccessfullyTransferedToUser) {
            // REMOVE PRODUCTS FROM CART
            foreach ($cartProducts as $product) {
                $isRemovedFromCart =
                    $this->_eshopData
                        ->getCartsRepository()
                        ->removeProductsFromCart($cartId, $product['id']);
                if(!$isRemovedFromCart) {
                    throw new \Exception("Error during cart checkout. Sorry for the inconvenience");
                }
            }
        }

        RouteService::redirect('account', 'profile', true);
    }

    /**
     * @throws \Exception
     * @Route("products")
     */
    public function viewMyProducts() {
        $userId = $this->getCurrentUserId();
        $user = $this->_eshopData->getUsersRepository()->findById($userId);
        if($user == null) {
            throw new \Exception("Invalid user id");
        }
        $userProducts = $this->_eshopData->getUsersRepository()->getUserProducts($userId);
        if($userProducts) {
            $this->escapeAll($userProducts);
            $viewModel = new UserProductsViewModel();
            $viewModel->userProducts = $userProducts;
            $viewModel->render();
        }
    }

    // ADD Role Id and their corresponding names from the Database
    private function getUserRoleName($roleId) {
        switch($roleId) {
            case '1':
                return self::ADMIN_ROLE;
            case '2':
                return self::EDITOR_ROLE;
            case '3':
                return self::GUEST_ROLE;
            default:
                return 'Invalid user role id';
        }
    }
    
    private function getProductsTotalSum($cartProducts) {
        $totalPrice = 0.0;
        foreach ($cartProducts as $product) {
            $totalPrice += $product['price'];
        }
        return $totalPrice;
    }
}