<?php

namespace EShop\Controllers;

use EShop\Helpers\RouteService;
use EShop\Models\BindModels;
use EShop\Models\User;
use EShop\Repositories\UsersRepository;
use EShop\View;
use EShop\ViewModels\ProfileViewModel;
use EShop\ViewModels\UserViewModel;

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

    public function profile() {
        if(!$this->isLogged()) {
            RouteService::redirect('home', 'index', true);
        }
        $currentUser = $this->_repository->findById($this->getCurrentUserId());

        if($currentUser != null) {
            $viewModel = new ProfileViewModel();
            $viewModel->userViewModel = $currentUser;
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
}