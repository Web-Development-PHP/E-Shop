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

    public function render()
    {
        include_once FolderConfig::VIEWS_DEFAULT_FOLDER . '/category/category.php';
        include_once FolderConfig::VIEWS_DEFAULT_FOLDER . '/category/addCategory.php';
    }
}