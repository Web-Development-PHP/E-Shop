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

    private $totalSum = 0;

    public function getProductsTotalSum() {
        foreach ($this->cart as $cartItem) {
            $this->totalSum += $cartItem->getProductPrice();
        }
        return $this->totalSum;
    }

    public function render()
    {
        $file = "/account/userCart.php";
        $this->loadTemplate($file, $this->cart);
    }
}