<?php
/**
 * Created by PhpStorm.
 * User: Krisss
 * Date: 27.09.2015
 * Time: 14:28
 */

namespace EShop\ViewModels;


use EShop\Config\FolderConfig;

class LoginViewModel extends  ViewModel
{

    public function render()
    {
        $file =  "/home/login.php";
        $this->loadTemplate($file, null);
    }
}