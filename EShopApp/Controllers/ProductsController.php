<?php

namespace EShop\Controllers;

use EShop\Exceptions\InvalidUserInputException;
use EShop\Helpers\RouteService;
use EShop\Models\BindModels\AddProductBindingModel;
use EShop\Models\BindModels\DeleteProductBindingModel;
use EShop\Models\BindModels\EditProductBindingModel;
use EShop\Models\Product;
use EShop\Services\ElectronicShopData;
use EShop\ViewModels\EditProductViewModel;

/**
 * Class ProductsController
 * @package EShop\Controllers
 * @Authorize
 */
class ProductsController extends Controller
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

    // GET products/index
    public function index()
    {
    }

    // POST products/fillEditForm
    /**
     * @param EditProductBindingModel $model
     * @Route("getEdit")
     */
    public function fillEditForm(EditProductBindingModel $model)
    {
        $categories = $this->_eshopData->getCategoriesRepository()->all();
        $viewModel = new EditProductViewModel();
        $viewModel->productOldInformation = $model;
        $viewModel->categories = $categories;
        $viewModel->render();
    }

    // POST products/edit
    /**
     * @param EditProductBindingModel $model
     * @Admin
     * @Editor
     */
    public function edit(EditProductBindingModel $model)
    {
        $isEdited = $this->_eshopData->getProductsRepository()->update($model);
        if($isEdited) {
            RouteService::redirect('categories', 'products/'. $model->getCategoryId(), true);
        }
        echo 'Error during edit';
    }

    // POST products/addProduct
    public function addProduct(AddProductBindingModel $model)
    {
        $isAdded = $this->_eshopData->getProductsRepository()->create($model);
        if($isAdded) {
            RouteService::redirect('categories', 'all', true);
        }
        echo "Unable to add product";
    }

    // POST products/deleteProduct
    /**
     * @param DeleteProductBindingModel $model
     * @throws InvalidUserInputException
     * @throws \Exception
     * @Admin
     * @Editor
     */
    public function deleteProduct(DeleteProductBindingModel $model)
    {
        $exists = $this->_eshopData->getProductsRepository()->findById($model->getProductId());
        if(!$exists) {
            throw new InvalidUserInputException("Product with such id does not exists");
        }
        $isDeleted = $this->_eshopData->getProductsRepository()->remove($model->getProductId());
        if($isDeleted) {
            RouteService::redirect('categories', 'products/' . $model->getCategoryId(), true);
        }
        echo "Error during delete product";
    }
}