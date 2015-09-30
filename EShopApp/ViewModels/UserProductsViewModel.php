<?php

namespace EShop\ViewModels;

use EShop\Models\MiniProduct;

class UserProductsViewModel extends ViewModel
{
    /**
     * @var MiniProduct[]
     */
    public $userProducts = [];

    public function render()
    {
        $file = "/account/user/products.php";
        $this->loadTemplate($file, $this->userProducts);
    }
}