<?php
/**
 * Created by PhpStorm.
 * User: Krisss
 * Date: 30.09.2015
 * Time: 13:09
 */

namespace EShop\Helpers\ViewHelpers\Elements;


class TextField extends Element
{
    public function __construct() {
        $this->elementName = "input";
        $this->setAttribute("type", "text");
        return $this;
    }
}