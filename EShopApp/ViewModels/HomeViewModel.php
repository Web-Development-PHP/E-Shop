<?php
/**
 * Created by PhpStorm.
 * User: Krisss
 * Date: 27.09.2015
 * Time: 13:37
 */

namespace EShop\ViewModels;


use EShop\Config\FolderConfig;

class HomeViewModel extends ViewModel
{
    public function render()
    {
        include_once FolderConfig::VIEWS_DEFAULT_FOLDER . "/home/home.php";
    }
}