<?php

namespace EShop\ViewModels;


use EShop\Config\AppUserRolesConfig;
use EShop\Helpers\ViewHelpers\FormViewHelper;
use EShop\Models\BindModels\EditProductBindingModel;
use EShop\Models\Category;
use EShop\Models\Product;

class EditProductViewModel extends ViewModel
{
    /**
     * @var EditProductBindingModel
     */
    public $productOldInformation;

    /**
     * @var Category[]
     */
    public $categories = [];

    public function renderProduct()
    {
        if(AppUserRolesConfig::hasAddEditDeletePriviligies())  {
            FormViewHelper::init();
            FormViewHelper::setAttribute('class', 'productForm');
            FormViewHelper::setMethod("post");
            FormViewHelper::setAction(\EShop\Config\RouteConfig::getBasePath(). 'products/edit');
            FormViewHelper::initTextField()
                ->setName('productName')
                ->setValue($this->productOldInformation->getProductName())
                ->setAttribute('class', 'form-group')
                ->create();
            FormViewHelper::initHiddenField()
                ->setName('productId')->setValue($this->productOldInformation->getProductId())->setAttribute('class', 'form-group')->create();
            FormViewHelper::initTextField()
                ->setName('quantity')->setValue($this->productOldInformation->getQuantity())->create();
            $select = FormViewHelper::initSelect();
            $select->setAttribute('class', 'form-group');
            $select->setName('categoryId');
            foreach ($this->categories as $category) {
                if($category->getId() == $this->productOldInformation->getCategoryId()) {
                    $select->addOption($category->getId(), $category->getName(), true);
                }else {
                    $select->addOption($category->getId(), $category->getName());
                }
            }
            $select->create();
            FormViewHelper::initSubmitButton()
                ->setValue('Edit')
                ->setAttribute('class', 'btn-primary btn-lg')
                ->create()
                ->render();
        }
    }

    public function render()
    {
        $file = '/category/products/editProduct.php';;
        $this->loadTemplate($file, $this->productOldInformation);
    }
}