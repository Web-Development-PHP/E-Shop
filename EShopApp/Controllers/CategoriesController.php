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
use EShop\Models\BindModels\UpdateCategoryBindingModel;
use EShop\Repositories\CategoriesRepository;
use EShop\Services\ElectronicShopData;
use EShop\ViewModels\CategoryProductsViewModel;
use EShop\ViewModels\CategoryViewModel;
use EShop\ViewModels\EditCategoryViewModel;
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


    public function all() {
        $categories = $this->_eshopData->getCategoriesRepository()->all();
        $viewModel = new CategoryViewModel();
        $this->escapeAll($categories);
        $viewModel->categoryViewModel = $categories;

        $viewModel->render();
    }

    public function add(CreateCategoryBindingModel $model) {
        $this->isModelStateValid($model);
        $isCreated = $this->_eshopData->getCategoriesRepository()->create($model);
        if($isCreated) {
            RouteService::redirect('categories', 'all', true);
        }
        echo 'Error during create category';
    }

    public function delete($id) {
        $isDeleted = $this->_eshopData->getCategoriesRepository()->remove($id);
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
            $this->escapeAll($products);
            $viewModel = new CategoryProductsViewModel();
            $viewModel->productViewModel = $products;
            $viewModel->render();
        }
    }

    public function index() {
        // TODO: Implement index() method.
    }
}