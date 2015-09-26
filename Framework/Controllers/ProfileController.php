<?php

namespace EShop\Controllers;

use EShop\Helpers\RouteService;
use EShop\Models\User;
use EShop\View;
use EShop\ViewModels\UserInformation;

/**
 * Class ProfileController
 * @package EShop\Controllers
 * @Authorize
 */
class ProfileController extends \EShop\Controllers\Controller
{
    /**
     * @var User
     */
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }

    public function get() {
        if(!$this->isLogged()) {
            RouteService::redirect('users', 'login', true);
        }
        $viewModel = new \EShop\ViewModels\ProfileInformation();

        try {
            $userInfo = $this->fillUserInformation($this->userModel);
            $viewModel->user = $userInfo;
        }catch (\Exception $e) {
            $viewModel->error = $e->getMessage();
            return new View($viewModel);
        }

        return new View($viewModel);
    }

    /**
     * @param $model
     * @return UserInformation
     */
    private function fillUserInformation(User $model){
        $id = $_SESSION['id'];
        $userInfo = $model->getInfo($id);
        $result = new UserInformation(
            $userInfo['username'],
            $userInfo['id'],
            $userInfo['full_name'],
            $userInfo['email'],
            $userInfo['age']
        );
        return $result;
    }
}