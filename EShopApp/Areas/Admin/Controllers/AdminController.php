<?php

namespace EShop\Areas\Admin\Controllers;
use EShop\Exceptions\InvalidUserInputException;
use EShop\Exceptions\InvalidUserOperationException;
use EShop\Helpers\RouteService;
use EShop\Models\BindModels\AddAllProductsPromoBindingModel;
use EShop\Models\BindModels\AddCategoryPromoBindingModel;
use EShop\Models\BindModels\AddProductPromoBindingModel;
use EShop\Services\ElectronicShopData;
use EShop\ViewModels\AdminPanelViewModel;

/**
 * Class AdminController
 * @package EShop\Areas\Admin\Controllers
 * @Authorize
 * @Admin
 */
class AdminController extends \EShop\Controllers\Controller
{
    /**
     * @var ElectronicShopData
     */
    private $_eshopData;

    public function __construct()
    {
        parent::__construct();
        $this->_eshopData = new ElectronicShopData();
    }

    public function index()
    {
        echo 'This is admin controller';
    }

    public function adminPanel()
    {
        $user = $this->_eshopData->getUsersRepository()->findById($this->getCurrentUserId());
        $user = $this->_eshopData->getUsersRepository()->findByUsername($user->getUsername());
        $categories = $this->_eshopData->getCategoriesRepository()->all();
        $allProducts = $this->_eshopData->getProductsRepository()->getAll();
        $allPromotions = $this->_eshopData->getCategoriesRepository()->getPromotionsForCategories();
        $allProductsPromotions = $this->_eshopData->getProductsRepository()->getAllProductsPromotion();
        $promotionOfCustomProducts =$this->_eshopData->getProductsRepository()->allCertainProductsInPromotion();
        $viewModel = new AdminPanelViewModel();
        $viewModel->allProductsPromotion = $allProductsPromotions;
        $viewModel->categoryPromotions = $allPromotions;
        $viewModel->productsOnPromotion = $promotionOfCustomProducts;
        $viewModel->categories = $categories;
        $viewModel->allProducts = $allProducts;
        $viewModel->adminData = $user;
        $viewModel->render();
    }

    public function addPromotionOnCategory(AddCategoryPromoBindingModel $model)
    {
        $hasPromotions = $this->_eshopData->getCategoriesRepository()->hasPromotions($model->getCategoryId());
        if($hasPromotions) {
            throw new InvalidUserOperationException("There is already a promotion for this category");
        }
        if($model->getDiscount() <= 0) {
            throw new InvalidUserInputException("Discount cannot be less or equal to 0.");
        }
        $category = $this->_eshopData->getCategoriesRepository()->findById($model->getCategoryId());
        if($category == null) {
            throw new InvalidUserInputException("Selected category does not exists.");
        }
        $isUpdated = $this->_eshopData
            ->getCategoriesRepository()
            ->putCategoryProductsOnPromotion($model->getCategoryId(), $model->getDiscount(), $category->getName());
        if($isUpdated) {
            RouteService::redirect('admin/admin', 'adminPanel', true);
        }
        echo 'Error during add category promo.';
    }

    public function addPromotionOnCertainProduct(AddProductPromoBindingModel $model)
    {
        if($model->getDiscount() < 1) {
            throw new InvalidUserInputException("Discount cannot be less or equal to 0.");
        }
        $alreadyInPromotion = $this->_eshopData->getProductsRepository()->isProductOnPromotion($model->getProductId());
        if($alreadyInPromotion) {
            throw new InvalidUserOperationException("This product is already in promotion");
        }
        $isPromotionAdded = $this->_eshopData->getProductsRepository()
            ->putPromotionOnProduct($model->getProductId(), $model->getDiscount());
        if($isPromotionAdded) {
            RouteService::redirect('admin/admin', 'adminPanel', true);
        }
        echo "Error during promoting a product";
    }

    public function removeCategoryDiscount($categoryId)
    {
        $isRemoved = $this->_eshopData->getCategoriesRepository()->removeDiscountOnCategory($categoryId);
        if($isRemoved) {
            RouteService::redirect('admin/admin', 'adminPanel', true);
        }
        echo 'Error during remove from promotion.';
    }

    public function removeProductFromPromotion($id)
    {
        $isRemoved = $this->_eshopData->getProductsRepository()->removeProductFromPromotion($id);
        if($isRemoved) {
            RouteService::redirect('admin/admin', 'adminPanel', true);
        }
        echo 'Error during remove from promotion.';
    }

    public function removeAllProductsDiscount($id){
        $isDeleted = $this->_eshopData->getProductsRepository()->removeAllProductsDiscount($id);
        if($isDeleted){
            RouteService::redirect('admin/admin', 'adminPanel', true);
        }
        echo 'Error during remove promo';
    }

    public function putDiscountOnAllProducts(AddAllProductsPromoBindingModel $model)
    {
        if($model->getDiscount() < 1) {
            throw new InvalidUserInputException("Discount cannot be equal or less than 0.");
        }
        $hasPromotion = $this->_eshopData->getProductsRepository()->allProductsPromotionAvailable();
        if($hasPromotion) {
            throw new InvalidUserOperationException("There is already valid promo for all products.");
        }
        $isDiscounted = $this->_eshopData->getProductsRepository()->putAllProductsOnPromotion($model->getDiscount());
        if($isDiscounted) {
            RouteService::redirect('admin/admin', 'adminPanel', true);
        }
        echo 'Error during add all products promo';
    }
}