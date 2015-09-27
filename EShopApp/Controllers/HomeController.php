<?php


namespace EShop\Controllers;


use EShop\Models\BindModels\LoginBindingModel;
use EShop\ViewModels\HomeViewModel;
use EShop\ViewModels\LoginViewModel;
use EShop\ViewModels\RegisterViewModel;

class HomeController extends Controller
{

    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
        $view = new HomeViewModel();
        $view->render();
    }

    public function login() {
        $v = new LoginViewModel();
        $v->render();
    }

    public function register() {
        $v = new RegisterViewModel();
        $v->render();
    }
}