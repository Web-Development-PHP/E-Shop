<?php

namespace EShop\ViewModels;

use EShop\Config\AppUserRolesConfig;
use EShop\Helpers\ViewHelpers\FormViewHelper;
use EShop\Models\Product;
use EShop\Models\SoldProduct;

class SoldProductsViewModel extends ViewModel
{
    /**
     * @var SoldProduct[]
     */
    public $soldProducts = [];

    public function renderSoldProducts()
    {
        if(AppUserRolesConfig::hasAddEditDeletePriviligies()) {
            if($this->soldProducts) {
                FormViewHelper::init();
                FormViewHelper::setMethod("post");
                FormViewHelper::setAction(\EShop\Config\RouteConfig::getBasePath(). 'account/reorder');
                FormViewHelper::setAttribute('class', 'productForm');
                $select = FormViewHelper::initSelect();
                $select->setName('productId');
                foreach ($this->soldProducts as $product) {
                    $select->addOption($product->getId(), $product->getName());
                }
                $select->create();
                FormViewHelper::initNumberField()
                    ->setName('quantity')
                    ->setAttribute('min', '1')
                    ->setAttribute('placeholder', 'Order counts')
                    ->create();
                FormViewHelper::initSubmitButton()
                    ->setValue('Reorder')
                    ->setAttribute('class', 'btn btn-primary')
                    ->create();
                FormViewHelper::render();
            }
        }
    }

    public function render()
    {
        $file = "/account/user/soldProducts.php";
        $this->loadTemplate($file, $this->soldProducts);
    }
}