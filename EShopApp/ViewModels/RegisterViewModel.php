<?php
/**
 * Created by PhpStorm.
 * User: Krisss
 * Date: 27.09.2015
 * Time: 14:28
 */

namespace EShop\ViewModels;


use EShop\Config\FolderConfig;

class RegisterViewModel extends ViewModel
{

    public function render()
    {
        include_once FolderConfig::VIEWS_DEFAULT_FOLDER . "/home/register.php";
    }
}