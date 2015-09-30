<?php

namespace EShop\ViewModels;

use EShop\Config\FolderConfig;
use EShop\Models;

class CategoryViewModel extends ViewModel
{
    /**
     * @var Models\Category
     */
    public $categoryViewModel = [];

    public $categoryData = [];

    public function render()
    {
        $file = '/category/category.php';
        $this->loadTemplate($file, $this->categoryViewModel);
        $addCategoryTemplate =  '/category/addCategory.php';
        $this->loadTemplate($addCategoryTemplate, null);
    }
}