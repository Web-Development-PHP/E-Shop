<?php

namespace EShop\Controllers;

use EShop\Config\RouteConfig;
use EShop\Helpers\RouteService;
use EShop\Models\BindModels;
use EShop\Models\User;
use EShop\Repositories\UsersRepository;
use EShop\View;
use EShop\ViewModels\ProfileViewModel;
use EShop\ViewModels\UserCartViewModel;
use EShop\ViewModels\UserViewModel;

/**
 * Class AccountController
 * @package EShop\Controllers
 */
class AccountController extends Controller
{
    /**
     * @var UsersRepository
     */
    private $_repository;
    const DEFAULT_USER_CASH = 150.00;
    const DEFAULT_USER_ROLE = 2;        // Editor user role
    const ADMIN_ROLE = 'Admin';
    const EDITOR_ROLE = 'Editor';
    const GUEST_ROLE = 'Guest';

    public function __construct() {
        parent::__construct();
        $this->_repository = new UsersRepository();
    }

    public function index() {

    }

    /**
     * @Authorize
     */
    public function profile() {
//        $this->isInRole();
        $currentUser = $this->_repository->findById($this->getCurrentUserId());
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
        $isRegistered = $this->_repository->create($userModel);
        if($isRegistered) {
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

        $user = $this->_repository->findByUsername($username);
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
        $cartItems = $this->_repository->viewCart($userId);
        $this->escapeAll($cartItems);
        $viewModel = new UserCartViewModel();
        $viewModel->cart = $cartItems;
        $viewModel->render();
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
}