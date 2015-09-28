<?php

namespace EShop\ViewModels;
use EShop\Helpers\ViewHelpers\FormViewHelper;
use EShop\Helpers\ViewHelpers\ViewHelper;

abstract class ViewModel
{
    /**
     * @var ViewHelper
     */
    protected $helper;

    abstract public function render();
}