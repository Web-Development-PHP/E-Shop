<?php
/**
 * Created by PhpStorm.
 * User: Krisss
 * Date: 27.09.2015
 * Time: 13:37
 */

namespace EShop\ViewModels;


use EShop\Config\FolderConfig;
use EShop\Helpers\ViewHelpers\FormViewHelper;

class HomeViewModel extends ViewModel
{

    public function renderSampleAjax()
    {
        \EShop\Helpers\ViewHelpers\FormViewHelper::init(true);
        \EShop\Helpers\ViewHelpers\FormViewHelper::setAction(\EShop\Config\RouteConfig::getBasePath(). "test/testAjax");
        \EShop\Helpers\ViewHelpers\FormViewHelper::setMethod("post");
        \EShop\Helpers\ViewHelpers\FormViewHelper::initTextField()
            ->setName("limit")->setAttribute('placeholder', 'Limit')->create();
        \EShop\Helpers\ViewHelpers\FormViewHelper::initSubmitButton()
            ->setName('btn')
            ->setValue('Generate Table')
            ->create()
            ->render();
    }

    public function render()
    {
        $file=  "/home/home.php";
        $this->loadTemplate($file,  new HomeViewModel());
    }
}