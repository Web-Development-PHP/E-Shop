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

    public function renderAddProductMenu()
    {
        if(AppUserRolesConfig::hasSufficientRoleRights(array(
            AppUserRolesConfig::ADMIN_ROLE,
            AppUserRolesConfig::EDITOR_ROLE))) {

            \EShop\Helpers\ViewHelpers\FormViewHelper::init();
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
                ->setValue(substr($_GET['uri'], strlen($_GET['uri'])- 1, strlen($_GET['uri'])))
                ->create();
            \EShop\Helpers\ViewHelpers\FormViewHelper::initNumberField()
                ->setName("quantity")
                ->setAttribute('min', '1')
                ->create();
            \EShop\Helpers\ViewHelpers\FormViewHelper::initSubmitButton()
                ->setValue('Add Product')
                ->create();

            \EShop\Helpers\ViewHelpers\FormViewHelper::setAction(\EShop\Config\RouteConfig::getBasePath(). 'products/addProduct');
            \EShop\Helpers\ViewHelpers\FormViewHelper::setMethod("post");
            \EShop\Helpers\ViewHelpers\FormViewHelper::render();
        }
    }

    public function render()
    {
        $file = '/category/products/categoryProducts.php';;
        $this->loadTemplate($file, $this->productViewModel);
    }
}