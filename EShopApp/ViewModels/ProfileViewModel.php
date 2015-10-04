<?php

namespace EShop\ViewModels;


use EShop\Config\AppUserRolesConfig;
use EShop\Config\FolderConfig;

class ProfileViewModel extends ViewModel
{
    public  $errors = false;
    public  $success;

    /**
     * @var UserViewModel
     */
    public $userViewModel = [];

    public function enterAdminPanel()
    {
        $html = "";
        if(AppUserRolesConfig::isAdmin()) {
            $url= \EShop\Config\RouteConfig::getBasePath() . 'admin/admin/adminPanel';
            $html .= "<a class='list-group-item' href=\"$url\">Admin Panel</a>";
            echo $html;
        }
    }

    public function renderAdminPanel()
    {

    }

    public function render()
    {
        $file =  '/account/profile.php';
        $this->loadTemplate($file, $this->userViewModel);
    }
}