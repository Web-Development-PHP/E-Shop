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
use EShop\Repositories\CategoriesRepository;
use EShop\ViewModels\CategoryViewModel;

/**
 * Class CategoriesController
 * @package EShop\Controllers
 * @Authorize
 */
class CategoriesController extends Controller
{
    /**
     * @var CategoriesRepository
     */
    private $_repository;

    public function __construct() {
        parent::__construct();
        $this->_repository = new CategoriesRepository();
    }


    public function all() {
        $categories = $this->_repository->all();
        $viewModel = new CategoryViewModel();
        $this->escapeAll($categories);
        $viewModel->categoryViewModel = $categories;

        $viewModel->render();
    }

    public function add(CreateCategoryBindingModel $model) {
        $this->isModelStateValid($model);
        $isCreated = $this->_repository->create($model);
        if($isCreated) {
            RouteService::redirect('categories', 'all', true);
        }
        echo 'Error during create category';
    }

    public function delete($id) {
        var_dump($id);
    }


    public function index()
    {
        // TODO: Implement index() method.
    }

    public function getRoles()
    {
        // TODO: Implement getRoles() method.
    }
}