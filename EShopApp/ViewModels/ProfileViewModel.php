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
        include_once FolderConfig::VIEWS_DEFAULT_FOLDER . '/account/profile.php';
    }
}