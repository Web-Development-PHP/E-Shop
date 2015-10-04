<?php

namespace EShop\ViewModels;

use EShop\Config\AppUserRolesConfig;
use EShop\Config\FolderConfig;
use EShop\Helpers\TokenHelper;
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

    public function renderDeleteButton($categoryId)
    {
        if(AppUserRolesConfig::hasAddEditDeletePriviligies()) {

            FormViewHelper::init();
            FormViewHelper::setAttribute('class', 'delete-category-form');
            FormViewHelper::setMethod("post");
            FormViewHelper::setAction(\EShop\Config\RouteConfig::getBasePath(). 'categories/delete');
            FormViewHelper::initSubmitButton()
                ->setValue('Delete')
                ->setName('confirm')
                ->setAttribute('class', 'btn-delete-category')
                ->setAttribute('class', 'btn btn-danger btn-sm')
                ->create();
            FormViewHelper::initHiddenField()
                ->setName('categoryId')
                ->setValue($categoryId)
                ->create()
                ->render();
        }
    }

    public function renderAddProductMenu()
    {
        if(AppUserRolesConfig::hasAddEditDeletePriviligies()) {

            \EShop\Helpers\ViewHelpers\FormViewHelper::init();
            FormViewHelper::setAttribute('class', 'form-horizontal productForm');
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
                ->setAttribute("placeholder", "Quantity")
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
                ->setAttribute('class', 'btn btn-default')
                ->create();

            \EShop\Helpers\ViewHelpers\FormViewHelper::setAction(\EShop\Config\RouteConfig::getBasePath(). 'products/addProduct');
            \EShop\Helpers\ViewHelpers\FormViewHelper::setMethod("post");
            \EShop\Helpers\ViewHelpers\FormViewHelper::render();
        }
    }

    public function renderAddCategoryMenu()
    {
        if(AppUserRolesConfig::hasAddEditDeletePriviligies())  {
            FormViewHelper::init();
            FormViewHelper::setMethod("post");
            FormViewHelper::setAction(\EShop\Config\RouteConfig::getBasePath() . "categories/add");
            FormViewHelper::initTextField()
                ->setName('name')
                ->setAttribute('placeholder', 'Category name')
                ->setAttribute('class', 'add-category-field')
                ->create();
            FormViewHelper::initSubmitButton()
                ->setValue('Add Category')
                ->setAttribute('class', 'btn btn-default')
                ->create()
                ->render();
        }
    }

    public function render()
    {
        $file = '/category/category.php';
        $this->loadTemplate($file, $this->categoryViewModel);
    }
}