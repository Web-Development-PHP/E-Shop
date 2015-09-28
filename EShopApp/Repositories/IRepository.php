<?php
/**
 * Created by PhpStorm.
 * User: Krisss
 * Date: 28.09.2015
 * Time: 19:12
 */

namespace EShop\Repositories;


interface IRepository
{
    public function find($id);

    public function remove($id);
}