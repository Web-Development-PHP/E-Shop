<?php
/**
 * Created by PhpStorm.
 * User: Krisss
 * Date: 28.09.2015
 * Time: 19:12
 */

namespace EShop\Repositories;


use EShop\Models\IBindingModel;

interface IRepository
{
    public function findById($id);

    public function remove($id);
}