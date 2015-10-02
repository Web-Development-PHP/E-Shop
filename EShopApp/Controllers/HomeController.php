<?php


namespace EShop\Controllers;


use EShop\Helpers\RouteService;
use EShop\Models\BindModels\LoginBindingModel;
use EShop\ViewModels\HomeViewModel;
use EShop\ViewModels\LoginViewModel;
use EShop\ViewModels\RegisterViewModel;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
        $view = new HomeViewModel();
        $view->render();
    }

    public function login() {
        if($this->isLogged()) {
            RouteService::redirect('account', 'profile', true);
        }
        $v = new LoginViewModel();
        $v->render();
    }

    public function register() {
        if($this->isLogged()) {
            RouteService::redirect('account', 'profile', true);
        }
        $v = new RegisterViewModel();
        $v->render();
    }
}