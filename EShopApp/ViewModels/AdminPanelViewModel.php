<?php
/**
 * Created by PhpStorm.
 * User: Krisss
 * Date: 02.10.2015
 * Time: 23:21
 */

namespace EShop\ViewModels;

use EShop\Config\AppUserRolesConfig;
use EShop\Helpers\ViewHelpers\FormViewHelper;
use EShop\Models\Category;
use EShop\Models\Product;
use EShop\Models\ProductPromo;
use EShop\Models\ProductsPromo;
use EShop\Models\PromoCategory;
use EShop\Models\User;

class AdminPanelViewModel extends ViewModel
{
    /**
     * @var User
     */
    public $adminData;

    /**
     * @var Category
     */
    public $categories = [];

    /**
     * @var Product[]
     */
    public $allProducts = [];

    /**
     * @var PromoCategory[]
     */
    public $categoryPromotions = [];

    /**
     * @var ProductsPromo[]
     */
    public $allProductsPromotion = [];

    /**
     * @var ProductPromo[]
     */
    public $productsOnPromotion = [];

    public function renderCustomPromoProducts()
    {
        if($this->productsOnPromotion) {
            $html = "<table border=\"1\" class='table table-striped table-hover'>";
            $html .= "<tr class='info'>";
            $html .= "<th>Product name</th>";
            $html .= "<th>Discount</th>";
            $html .= "<th>Promoted At</th>";
            $html .= "<th></th>";
            $html .= "</tr>";
            foreach ($this->productsOnPromotion as $prod) {
                $html .= "<tr>";
                $html .= "<td>{$prod->getProductName()}</td>";
                $html .= "<td>{$prod->getDiscount()} %</td>";
                $html .= "<td>{$prod->getPromotedAt()}</td>";
                $html .= '<td class="remove-btn">
                        <a href="'.\EShop\Config\RouteConfig::getBasePath().'admin/admin/removeProductFromPromotion/'.$prod->getId().'">
                        Remove from promo
                        </a>
                    </td>';
                $html .= "</tr>";
            }
            $html .= "</table>";
            echo $html;
        }
    }

    public function renderPromotionsForAllProducts()
    {
        if($this->allProductsPromotion) {
            $html = "<table border=\"1\" class='table table-striped table-hover'>";
            $html .= "<tr class='danger'>";
            $html .= "<th>Discount</th>";
            $html .= "<th>Promoted At</th>";
            $html .= "<th></th>";
            $html .= "</tr>";
            foreach ($this->allProductsPromotion as $promo) {
                $html .= "<tr>";
                $html .= "<td>{$promo->getDiscount()} %</td>";
                $html .= "<td>{$promo->getPromotedAt()}</td>";
                $html .= '<td class="remove-btn">
                        <a href="'.\EShop\Config\RouteConfig::getBasePath().'admin/admin/removeAllProductsDiscount/'.$promo->getId().'">
                        Remove Promotion
                        </a>
                    </td>';
                $html .= "</tr>";
            }
            $html .= "</table>";
            echo $html;
        }
    }

    public function renderPromotionsForCategory()
    {
        // DONT RENDER IF IS EMPTY
        if($this->categoryPromotions){
            $html = "<table border=\"1\" class='table table-striped table-hover'>";
            $html .= "<tr class='warning'>";
            $html .= "<th>Category name</th>";
            $html .= "<th>Category Discount</th>";
            $html .= "<th>Promoted At</th>";
            $html .= "<th></th>";
            $html .= "</tr>";
            foreach ($this->categoryPromotions as $catPromo) {
                $html .= "<tr>";
                $html .= "<td>{$catPromo->getCategoryName()}</td>";
                $html .= "<td>{$catPromo->getDiscount()} %</td>";
                $html .= "<td>{$catPromo->getPromotedAt()}</td>";
                $html .= '<td class="remove-btn">
                        <a href="'.\EShop\Config\RouteConfig::getBasePath().'admin/admin/removeCategoryDiscount/'.$catPromo->getCategoryId().'">
                        Remove Promotion
                        </a>
                    </td>';
                $html .= "</tr>";
            }
            $html .= "</table>";
            echo $html;
        }
    }

    public function renderCategoriesPromoMenu()
    {
        if(AppUserRolesConfig::isAdmin()) {
            FormViewHelper::init();
            FormViewHelper::setAttribute('class', 'productForm');
            FormViewHelper::setMethod("post");
            FormViewHelper::setAction(\EShop\Config\RouteConfig::getBasePath(). 'admin/admin/addPromotionOnCategory');
            FormViewHelper::initNumberField()
                ->setAttribute('placeholder', 'Category promo in %')
                ->setName('discount')
                ->setAttribute('class', 'discount')
                ->create();
            $select = FormViewHelper::initSelect();
            $select->setName("categoryId");
            foreach ($this->categories as $category) {
                $select->addOption($category->getid(), $category->getName());
            }
            $select->create();
            FormViewHelper::initSubmitButton()
                ->setValue('Add promotion')
                ->setAttribute('class', 'btn btn-primary')
                ->create();
            FormViewHelper::render();
        }
    }

    public function renderAllProductsPromoMenu()
    {
        if(AppUserRolesConfig::isAdmin()) {
            FormViewHelper::init();
            FormViewHelper::setMethod("post");
            FormViewHelper::setAction(\EShop\Config\RouteConfig::getBasePath(). 'admin/admin/putDiscountOnAllProducts');
            FormViewHelper::initNumberField()
                ->setAttribute('placeholder', 'All products promo in %')
                ->setName('discount')
                ->setAttribute('class', 'discount')
                ->create();
             FormViewHelper::initSubmitButton()
                 ->setValue('Add promotion')
                 ->setAttribute('class', 'btn btn-primary')
                 ->create()
                 ->render();
        }
    }

    public function renderCertainProductsPromoMenu()
    {
        if(AppUserRolesConfig::isAdmin()) {
            FormViewHelper::init();
            FormViewHelper::setMethod("post");
            FormViewHelper::setAction(\EShop\Config\RouteConfig::getBasePath(). 'admin/admin/addPromotionOnCertainProduct');
            $select = FormViewHelper::initSelect();
            $select->setName('productId');
            foreach ($this->allProducts as $product) {
                $select->addOption($product->getid(), $product->getName());
            }
            $select->create();
            FormViewHelper::initNumberField()
                ->setAttribute('placeholder', 'Product promo in %')
                ->setName('discount')
                ->setAttribute('class', 'discount')
                ->create();
            FormViewHelper::initSubmitButton()
                ->setValue('Add promotion')
                ->setAttribute('class', 'btn btn-primary')
                ->create();
            FormViewHelper::render();
        }
    }

    public function render()
    {
        $file = '/account/user/adminPanel.php';;
        $this->loadTemplate($file, $this->adminData);
    }
}