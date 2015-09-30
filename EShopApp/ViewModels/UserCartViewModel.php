<?php
/**
 * Created by PhpStorm.
 * User: Krisss
 * Date: 29.09.2015
 * Time: 17:30
 */

namespace EShop\ViewModels;

use EShop\Config\FolderConfig;
use EShop\Models\Cart;

class UserCartViewModel extends ViewModel
{
    /**
     * @var Cart[]
     */
    public $cart = [];

    public function render()
    {
        $file = "/account/userCart.php";
        $this->loadTemplate($file, $this->cart);
    }
}