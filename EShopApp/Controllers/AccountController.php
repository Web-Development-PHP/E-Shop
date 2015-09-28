<?php

namespace EShop\Controllers;

use EShop\Config\RouteConfig;
use EShop\Helpers\RouteService;
use EShop\Models\BindModels;
use EShop\Models\User;
use EShop\Repositories\UsersRepository;
use EShop\View;
use EShop\ViewModels\ProfileViewModel;
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
        $currentUser = $this->_repository->findById($this->getCurrentUserId());
        if($currentUser != null) {
            $viewModel = new ProfileViewModel();
            $viewModel->userViewModel = $currentUser;
            $this->escapeAll($viewModel);
            $viewModel->render();
        }
    }

    /**
     * @param BindModels\RegisterBindingModel $userModel
     * @Route("register")
     */
    public function registerUser(BindModels\RegisterBindingModel $userModel) {
        var_dump($userModel);
        $userModel->setCash(self::DEFAULT_USER_CASH);
        $isRegistered = $this->_repository->create($userModel);
        if($isRegistered) {
            $user = $this->_repository->findByUsername($userModel->getUsername());
            $this->setIdInSession($user->getId());
            RouteService::redirect('account', 'profile', true);
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
}