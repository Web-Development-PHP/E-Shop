<?php
//
//namespace EShop\Controllers;
//
//use EShop\Helpers\RouteService;
//use EShop\Models\User;
//use EShop\View;
//use EShop\ViewModels\LoginInformation;
//use EShop\ViewModels\RegisterInformation;
//use EShop\ViewModels\UserInformation;
//
///**
// * Class UsersController
// * @package EShop\Controllers
// */
//class UsersController extends Controller
//{
//    /**
//     * @var User
//     */
//    private $userModel;
//
//    public function __construct()
//    {
//        parent::__construct();
//        $this->userModel = new User();
//    }
//
//    /**
//     * @Route("register")
//     * @return View
//     */
//    public function register() {
//        $viewModel = new RegisterInformation();
//
//        if(isset($_POST['username'], $_POST['password'], $_POST['confirmPassword'], $_POST['email'])) {
//            try {
//                $username = $_POST['username'];
//                $password = $_POST['password'];
//                $confirmPass = $_POST['confirmPassword'];
//                $email = $_POST['email'];
//                $viewModel->success = 'Successfully registered user';
//
//                $this->userModel->register($username, $password, $confirmPass, $email);
//
//                $this->initLogin($username, $password);
//            }catch (\Exception $e) {
//                $viewModel->error = $e->getMessage();
//                return new View($viewModel);
//            }
//        }
//        return new View($viewModel);
//    }
//
//    public function login() {
//        $viewModel = new LoginInformation();
//
//        if(isset($_POST['username'], $_POST['password'])) {
//            try {
//                $username = $_POST['username'];
//                $password = $_POST['password'];
//                $viewModel->success = 'Successfully Logged user';
//                $this->initLogin($username, $password);
//            }catch (\Exception $e) {
//                $viewModel->error = $e->getMessage();
//                return new View($viewModel);
//            }
//        }
//
//        return new View($viewModel);
//    }
//
//    /**
//     * @Route("test")
//     */
//    public function t() {
//        echo 'This is TEST()';
//    }
//
//    protected function initLogin($username, $password) {
//        $this->userModel->login($username, $password);
//        RouteService::redirect('profile', 'get');
//    }
//}