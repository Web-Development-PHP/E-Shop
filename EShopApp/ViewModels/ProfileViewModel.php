<?php

namespace EShop\ViewModels;


use EShop\Config\FolderConfig;

class ProfileViewModel extends ViewModel
{
    public  $errors = false;
    public  $success;

    /**
     * @var UserViewModel
     */
    public $userViewModel = [];

    public function render()
    {
        $file =  '/account/profile.php';
        $this->loadTemplate($file, $this->userViewModel);
    }
}