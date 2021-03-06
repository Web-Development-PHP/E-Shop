<?php

namespace EShop\Controllers;

use EShop\Config\AppUserRolesConfig;
use EShop\Config\RouteConfig;
use EShop\Exceptions\InvalidCredentialsException;
use EShop\Exceptions\InvalidUserInputException;
use EShop\Exceptions\InvalidUserOperationException;
use EShop\Helpers\RouteService;
use EShop\Models\BindModels;
use EShop\Models\User;
use EShop\Repositories\UsersRepository;
use EShop\Services\ElectronicShopData;
use EShop\View;
use EShop\ViewModels\AdminPanelViewModel;
use EShop\ViewModels\EditUserViewModel;
use EShop\ViewModels\ProfileViewModel;
use EShop\ViewModels\SoldProductsViewModel;
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

    public function __construct()
    {
        parent::__construct();
        $this->_eshopData = new ElectronicShopData();
    }

    public function index() { }

    // GET account/profile
    /**
     * @Authorize
     */
    public function profile()
    {
        $currentUser = $this->_eshopData->getUsersRepository()->findById($this->getCurrentUserId());
        if($currentUser != null) {
            $viewModel = new ProfileViewModel();
            $viewModel->userViewModel = $currentUser;
            $viewModel->userViewModel->setRoleName(AppUserRolesConfig::getUserRoleName($currentUser->getRole()));
            $viewModel->render();
        }
    }

    // POST account/register
    /**
     * @param BindModels\RegisterBindingModel $userModel
     * @Route("register")
     */
    public function registerUser(BindModels\RegisterBindingModel $userModel)
    {
        $userModel->setCash(self::DEFAULT_USER_CASH);
        $userModel->setRole(AppUserRolesConfig::DEFAULT_USER_ROLE);

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

    // POST account/login
    /**
     * @param BindModels\LoginBindingModel $loginBindingModel
     * @throws \Exception
     * @Route("login")
     */
    public function loginUser(BindModels\LoginBindingModel $loginBindingModel)
    {
        $username = $loginBindingModel->getUsername();
        $password = $loginBindingModel->getPassword();

        $user = $this->_eshopData->getUsersRepository()->findByUsername($username);
        if($user == null || !password_verify($password, $user->getPassword())){
            throw new InvalidCredentialsException('Invalid credentials');
        }
        $_SESSION['role'] = AppUserRolesConfig::getUserRoleName($user->getRole());
        $this->setIdInSession($user->getId());
        RouteService::redirect('account', 'profile', true);
    }

    // POST account/changePassword
    /*
     * @Authorize
     */
    public function changePassword(BindModels\ChangePasswordBindingModel $model)
    {
        if($model->getNewPassword() != $model->getConfirmPassword()) {
            throw new InvalidUserInputException("Entered passwords does not match!");
        }
        $userId = $this->getCurrentUserId();
        $isPasswordChanged = $this->_eshopData->getUsersRepository()
            ->changePassword($userId, $model->getNewPassword());
        if($isPasswordChanged) {
            RouteService::redirect('account', 'profile', true);
        }
        echo "Error during change password";
    }

    // GET account/renderChangePasswordMenu
    /**
     * @Authorize
     */
    public function renderChangePasswordMenu()
    {
        $viewModel = new EditUserViewModel();
        $viewModel->render();
    }

    // POST account/logout
    /**
     * @Authorize
     */
    public function logout() {
       if($this->isLogged()) {
           session_unset();
           session_destroy();
           RouteService::redirect('home', 'index', true);
       }
    }

    // GET account/viewCart
    /**
     * @Authorize
     */
    public function viewCart()
    {
        $userId = $this->getCurrentUserId();
        $user = $this->_eshopData->getUsersRepository()->findById($userId);
        if($user == null) {
            throw new \Exception("Invalid user id");
        }
        $cartItems = $this->_eshopData->getCartsRepository()->findById($userId);
        if($cartItems) {
            $viewModel = new UserCartViewModel();
            $viewModel->cart = $cartItems;
            $viewModel->render();
        }
    }

    // POST account/addToCart
    /**
     * @param $productId
     * @throws InvalidUserOperationException
     * @throws \Exception
     * @Authorize
     */
    public function addToCart($productId)
    {
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
            throw new InvalidUserOperationException("You already added product to your cart");
        }
        $isAdded = $this->_eshopData->getCartsRepository()->addToCart($cartId, $productId);
        if($isAdded) {
            // TODO ADD SUCCESS MSG (WITH NOTY)
            RouteService::redirect('categories', 'products/' . $product->getCategoryId(), true);
        }
        echo 'failed to added product to cart';
    }

    // POST account/checkoutCart
    /**
     * @param $cartId
     * @throws InvalidUserOperationException
     * @throws \Exception
     * @Authorize
     */
    public function checkoutCart($cartId)
    {
        $userId = $this->getCurrentUserId();
        $user = $this->_eshopData->getUsersRepository()->findById($userId);
        if($user == null) {
            throw new \Exception("Invalid user id");
        }
        // CART BELONGS TO CURRENT USER
        $userCartId = $this->_eshopData->getCartsRepository()->getCartForCurrentUser($userId);
        if($userCartId != $cartId) {
            throw new InvalidUserOperationException("You cannot check out another user cart");
        }
        // GET PRODUCTS IN CART
        $cartProducts = $this->_eshopData->getCartsRepository()->getProductsInCart($cartId);
        if(!$cartProducts) {
            throw new InvalidUserOperationException("You dont have any products in your cart.");
        }
        // CHECK IF TOTAL SUM OF PRODUCTS IS LESS THAN USER CASH
        $cartProductsTotalSum = $this->getProductsTotalSum($cartProducts);
        if($cartProductsTotalSum > $user->getCash()) {
            throw new InvalidUserOperationException("You do not have enough cash to buy all the products in your cart.");
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
                    throw new InvalidUserOperationException("You already have product {$product['name']} in your products inventory");
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

    // POST GET/removeProductFromCart
    /**
     * @Route("removeProduct")
     * @Authorize
     */
    public function removeProductFromCart($cartId, $productId)
    {
        $isProductInCart = $this->_eshopData->getCartsRepository()->isProductInCart($cartId, $productId);
        if(!$isProductInCart) {
            throw new InvalidUserOperationException("You are trying to remove a product that is not in your cart");
        }
        $isRemoved = $this->_eshopData->getCartsRepository()->removeProductsFromCart($cartId, $productId);
        if($isRemoved) {
            RouteService::redirect('account', 'viewCart', true);
        }
    }

    // POST GET/viewMyProducts
    /**
     * @throws \Exception
     * @Route("products")
     * @Authorize
     */
    public function viewMyProducts()
    {
        $userId = $this->getCurrentUserId();
        $user = $this->_eshopData->getUsersRepository()->findById($userId);
        if($user == null) {
            throw new \Exception("Invalid user id");
        }
        $userProducts = $this->_eshopData->getUsersRepository()->getUserProducts($userId);
        if($userProducts) {
            $viewModel = new UserProductsViewModel();
            $viewModel->userProducts = $userProducts;
            $viewModel->render();
        }
    }
    // POST account/sellProduct
    /**
     * @param $productId
     * @throws InvalidUserOperationException
     * @throws \Exception
     * @Authorize
     */
    public function sellProduct($productId)
    {
        $userId = $this->getCurrentUserId();
        $user = $this->_eshopData->getUsersRepository()->findById($userId);
        if($user == null) {
            throw new \Exception("Invalid user id");
        }

        $product = $this->_eshopData->getProductsRepository()->findById($productId);

        $isQuantityDescreased = $this->_eshopData->getProductsRepository()->sellProduct($product->getId());
        if(!$isQuantityDescreased) {
            throw new InvalidUserOperationException("You dont have enough quantity left of this product.");
        }
        if($isQuantityDescreased) {
            $isProductRemovedFromUser =
                $this->_eshopData->getProductsRepository()->removeProductFromUser($userId, $productId);
            if(!$isProductRemovedFromUser) {
                throw new \Exception("Error during selling your product.");
            }
        }
        if($isProductRemovedFromUser) {
            $updateUserCash =
                $this->_eshopData->getUsersRepository()->sellItems($userId, $product->getPrice());
            if(!$updateUserCash) {
                throw new \Exception("Error during selling your product.");
            }
        }
        if($updateUserCash) {
            RouteService::redirect('account', 'profile', true);
        }
    }

    /**
     * @Editor
     * @Admin
     */
    public function getSoldProducts()
    {
        $soldProducts = $this->_eshopData->getProductsRepository()->getSoldProducts();
        $viewModel = new SoldProductsViewModel();
        $viewModel->soldProducts = $soldProducts;
        $viewModel->render();
    }

    /**
     * @param BindModels\ReorderProductBindingModel $model
     * @throws InvalidUserInputException
     * @throws InvalidUserOperationException
     * @throws \Exception
     * @Authorize
     * @Admin
     * @Editor
     */
    public function reorder(BindModels\ReorderProductBindingModel $model)
    {
        if($model->getQuantity() < 2) {
            throw new InvalidUserInputException("You cannot order less than 1 item quantity");
        }
        $productExists = $this->_eshopData->getProductsRepository()->findById($model->getProductId());
        if($productExists == null) {
            throw new InvalidUserOperationException("The selected product does not exist anymore.");
        }
        $isUpdated = $this->_eshopData->getProductsRepository()
            ->reorderProduct($model->getProductId(), $model->getQuantity());
        if($isUpdated) {
            RouteService::redirect('categories', 'products/' . $productExists->getCategoryId(), true);
        }
        echo 'Error during reorder product';
    }

    private function getProductsTotalSum($cartProducts)
    {
        $totalPrice = 0.0;
        foreach ($cartProducts as $product) {
            $totalPrice += $product['price'];
        }
        return $totalPrice;
    }
}