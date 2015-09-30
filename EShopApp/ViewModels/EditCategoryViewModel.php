<?php

namespace EShop\ViewModels;

use EShop\Config\FolderConfig;
use EShop\Helpers\ViewHelpers\FormViewHelper;

class EditCategoryViewModel extends ViewModel
{
    public $categoryId;

    public function render()
    {
        $file =  '/category/editCategory.php';
        $this->loadTemplate($file, null);
    }
}