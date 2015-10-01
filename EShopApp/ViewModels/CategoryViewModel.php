<?php

namespace EShop\ViewModels;

use EShop\Config\FolderConfig;
use EShop\Helpers\TokenHelper;
use EShop\Helpers\ViewHelpers\Elements\CSRF;
use EShop\Helpers\ViewHelpers\Elements\HiddenField;
use EShop\Helpers\ViewHelpers\Elements\Select;
use EShop\Helpers\ViewHelpers\FormViewHelper;
use EShop\Models;

class CategoryViewModel extends ViewModel
{
    /**
     * @var Models\Category
     */
    public $categoryViewModel = [];

    public $categoryData = [];

    public function renderAddProductMenu()
    {
        \EShop\Helpers\ViewHelpers\FormViewHelper::initTextField()
            ->setName("productName")
            ->setAttribute('placeholder', 'Product name...')
            ->create();

        \EShop\Helpers\ViewHelpers\FormViewHelper::initTextField()
            ->setName("productPrice")
            ->setAttribute("placeholder", "Product price")
            ->create();

        \EShop\Helpers\ViewHelpers\FormViewHelper::initNumberField()
            ->setName("quantity")
            ->setAttribute('min', '1')
            ->create();

        $select = FormViewHelper::initSelect();
        $select->setName('categoryId');
        foreach ($this->categoryViewModel as $model) {
            $select->addOption($model->getId(), $model->getName());
        }
        $select->create();

        \EShop\Helpers\ViewHelpers\FormViewHelper::initSubmitButton()
            ->setValue('Add Product')
            ->create();

        \EShop\Helpers\ViewHelpers\FormViewHelper::setAction(\EShop\Config\RouteConfig::getBasePath(). 'products/addProduct');
        \EShop\Helpers\ViewHelpers\FormViewHelper::setMethod("post");
        \EShop\Helpers\ViewHelpers\FormViewHelper::render();
    }

    public function render()
    {
        $file = '/category/category.php';
        $this->loadTemplate($file, $this->categoryViewModel);
        $addCategoryTemplate =  '/category/addCategory.php';
        $this->loadTemplate($addCategoryTemplate, null);
    }
}