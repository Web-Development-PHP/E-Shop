<?php
/**
 * Created by PhpStorm.
 * User: Krisss
 * Date: 28.09.2015
 * Time: 19:31
 */

namespace EShop\Controllers;

use EShop\Helpers\RouteService;
use EShop\Models\BindModels\CreateCategoryBindingModel;
use EShop\Models\BindModels\DeleteCategoryBindingModel;
use EShop\Models\BindModels\UpdateCategoryBindingModel;
use EShop\Repositories\CategoriesRepository;
use EShop\Services\ElectronicShopData;
use EShop\ViewModels\CategoryProductsViewModel;
use EShop\ViewModels\CategoryViewModel;
use EShop\ViewModels\ViewModel;

/**
 * Class CategoriesController
 * @package EShop\Controllers
 * @Authorize
 */
class CategoriesController extends Controller
{
    /**
     * @var ElectronicShopData
     */
    private $_eshopData;

    public function __construct() {
        parent::__construct();

        $this->_eshopData = new ElectronicShopData();
    }

    // GET categories/all
    public function all() {
        $categories = $this->_eshopData->getCategoriesRepository()->all();
        $viewModel = new CategoryViewModel();
        $viewModel->categoryViewModel = $categories;
        $viewModel->render();
    }

    // POST categories/add
    public function add(CreateCategoryBindingModel $model) {
        $isCreated = $this->_eshopData->getCategoriesRepository()->create($model);
        if($isCreated) {
            RouteService::redirect('categories', 'all', true);
        }
        echo 'Error during create category';
    }

    // POST categories/delete
    /**
     * @param DeleteCategoryBindingModel $model
     * @throws \Exception
     * @Admin
     * @Editor
     */
    public function delete(DeleteCategoryBindingModel $model) {
        $isDeleted = $this->_eshopData->getCategoriesRepository()->remove($model->getCategoryId());
        // TODO ADD JAVASCRIPT CONFIRMATION BOX
        if($isDeleted) {
            RouteService::redirect('categories', 'all', true);
        }else {
            echo 'Error during delete category';
        }
    }

    // GET categories/products/id
    /**
     * @param $categoryId
     * @Route("products")
     */
    public function getProducts($categoryId) {
        $userId = $this->getCurrentUserId();
        $userCartId = $this->_eshopData->getCartsRepository()->getCartForCurrentUser($userId);
        $products = $this->_eshopData->getCategoriesRepository()->getAllProducts($userId, $userCartId, $categoryId);
        if($products) {
            $viewModel = new CategoryProductsViewModel();
            $viewModel->productViewModel = $products;
            $viewModel->currentCategoryId = $categoryId;
            $viewModel->render();
        }
    }

    public function index() {
        // TODO: Implement index() method.
    }
}