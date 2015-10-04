<?php

namespace EShop\ViewModels;

use EShop\Config\AppUserRolesConfig;
use EShop\Config\FolderConfig;
use EShop\Helpers\ViewHelpers\FormViewHelper;
use EShop\Models\Product;

class CategoryProductsViewModel extends ViewModel
{
    /**
     * @var Product[]
     */
    public $productViewModel = [];

    public $currentCategoryId;

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
            \EShop\Helpers\ViewHelpers\FormViewHelper::initHiddenField()
                ->setName("categoryId")
                ->setValue($this->currentCategoryId)
                ->create();
            \EShop\Helpers\ViewHelpers\FormViewHelper::initNumberField()
                ->setName("quantity")
                ->setAttribute("placeholder", "Quantity")
                ->setAttribute('min', '1')
                ->create();
            \EShop\Helpers\ViewHelpers\FormViewHelper::initSubmitButton()
                ->setValue('Add Product')
                ->setAttribute('class', 'btn btn-default')
                ->create();

            \EShop\Helpers\ViewHelpers\FormViewHelper::setAction(\EShop\Config\RouteConfig::getBasePath(). 'products/addProduct');
            \EShop\Helpers\ViewHelpers\FormViewHelper::setMethod("post");
            \EShop\Helpers\ViewHelpers\FormViewHelper::render();
        }
    }

    public function renderEditProductButton($productName, $productId, $quantity)
    {
        if(AppUserRolesConfig::hasAddEditDeletePriviligies())  {
            FormViewHelper::init();
            FormViewHelper::setMethod("post");
            FormViewHelper::setAction(\EShop\Config\RouteConfig::getBasePath(). 'products/getEdit');
            FormViewHelper::initHiddenField()
                ->setName('productName')->setValue($productName)->create();
            FormViewHelper::initHiddenField()
                ->setName('productId')->setValue($productId)->create();
            FormViewHelper::initHiddenField()
                ->setName('quantity')->setValue($quantity)->create();
            FormViewHelper::initHiddenField()
                ->setName('categoryId')
                ->setValue(substr($_GET['uri'], strlen($_GET['uri'])- 1, strlen($_GET['uri'])))
                ->create();
            FormViewHelper::initSubmitButton()
                ->setValue('Edit')
                ->setAttribute('class', 'btn-default product-btn')
                ->create()
                ->render();
        }
    }

    public function renderDeleteProductButton($productId)
    {
        if(AppUserRolesConfig::hasAddEditDeletePriviligies()) {
            FormViewHelper::init();
            FormViewHelper::setMethod("post");
            FormViewHelper::setAction(\EShop\Config\RouteConfig::getBasePath() . 'products/deleteProduct');
            FormViewHelper::initHiddenField()
                ->setName('productId')->setValue($productId)->create();
            FormViewHelper::initHiddenField()
                ->setName('categoryId')
                ->setValue(substr($_GET['uri'], strlen($_GET['uri'])- 1, strlen($_GET['uri'])))
                ->create();
            FormViewHelper::initSubmitButton()
                ->setValue('Delete')
                ->setAttribute('class', 'btn-default product-btn')
                ->create()
                ->render();
        }
    }

    public function render()
    {
        $file = '/category/products/categoryProducts.php';;
        $this->loadTemplate($file, $this->productViewModel);
    }
}