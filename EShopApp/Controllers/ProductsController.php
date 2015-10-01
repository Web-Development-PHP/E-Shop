<?php

namespace EShop\Controllers;

use EShop\Helpers\RouteService;
use EShop\Models\BindModels\AddProductBindingModel;
use EShop\Services\ElectronicShopData;

class ProductsController extends Controller
{
    /**
     * @var ElectronicShopData
     */
    private $_eshopData;

    public function __construct() {
        parent::__construct();
        $this->_eshopData = new ElectronicShopData();
    }

    public function index()
    {
    }

    public function addProduct(AddProductBindingModel $model)
    {
        $isAdded = $this->_eshopData->getProductsRepository()->create($model);
        if($isAdded) {
            RouteService::redirect('categories', 'all', true);
        }
        echo "Unable to add product";
    }
}