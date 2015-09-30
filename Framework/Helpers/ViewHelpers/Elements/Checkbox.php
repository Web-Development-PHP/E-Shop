<?php
/**
 * Created by PhpStorm.
 * User: Krisss
 * Date: 30.09.2015
 * Time: 13:07
 */

namespace EShop\Helpers\ViewHelpers\Elements;


class Checkbox extends Element
{
    public function __construct() {
        $this->elementName = "input";
        $this->setAttribute("type", "checkbox");
        return $this;
    }
}