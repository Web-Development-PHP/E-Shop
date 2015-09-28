<?php
/**
 * Created by PhpStorm.
 * User: Krisss
 * Date: 28.09.2015
 * Time: 19:11
 */

namespace EShop\Repositories;
use EShop\Config\DatabaseConfig;
use EShop\Core\Database;
use EShop\Models\BindModels\CreateCategoryBindingModel;
use EShop\Models\BindModels\UpdateCategoryBindingModel;
use EShop\Models\Category;


class CategoriesRepository implements IRepository
{
    /**
     * @var Database
     */
    protected $db;
    const CATEGORIES_TABLENAME = 'categories';

    public function __construct() {
        $this->db = \EShop\Core\Database::getInstance(DatabaseConfig::DB_INSTANCE);
    }

    public function all() {
        $data = $this->db->getAllEntities(self::CATEGORIES_TABLENAME);

        $categories = [];
        foreach ($data as $cat) {
            $category = new Category($cat);
            array_push($categories, $category);
        }
        return $categories;
    }

    public function find($id) {
        $data = $this->db->getEntityById(self::CATEGORIES_TABLENAME, $id);
        if($data == null) {
            return null;
        }
        $category = new Category($data);

        return $category;
    }


    public function remove($id)
    {
        $cat = $this->find($id);
        if($cat == null) {
            throw new \Exception("category with such id does not exist!");
        }
        $this->db->deleteEntityByPrimaryKey(self::CATEGORIES_TABLENAME, 'id', $id);
        return true;
    }

    public function create(CreateCategoryBindingModel $model)
    {
        $isCreated = $this->db->insertEntity(self::CATEGORIES_TABLENAME, array(
            'name' => $model->getName()
        ));

        return $isCreated;
    }

    public function update($id, UpdateCategoryBindingModel $model)
    {
        $isUpdated = $this->db->updateEntityById(
            self::CATEGORIES_TABLENAME,
            array('name' => $model->getName()),
            $id
        );
        return $isUpdated;
    }
}