<?php

namespace EShop\ViewModels;

use EShop\Config\FolderConfig;
use EShop\Models\Product;

class CategoryProductsViewModel extends ViewModel
{
    /**
     * @var Product[]
     */
    public $productViewModel = [];

    public function render()
    {
        $file = '/category/products/categoryProducts.php';;
        $this->loadTemplate($file, $this->productViewModel);
    }
}