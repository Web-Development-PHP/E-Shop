<?php
/**
 * Created by PhpStorm.
 * User: Krisss
 * Date: 27.09.2015
 * Time: 13:37
 */

namespace EShop\ViewModels;


use EShop\Config\FolderConfig;
use EShop\Helpers\ViewHelpers\FormViewHelper;

class HomeViewModel extends ViewModel
{
    public function render()
    {
        $file=  "/home/home.php";
        $this->loadTemplate($file, null);
    }
}