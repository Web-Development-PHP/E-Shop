<?php
/**
 * Created by PhpStorm.
 * User: Krisss
 * Date: 01.10.2015
 * Time: 18:54
 */

namespace EShop\Helpers\ViewHelpers\Elements;


class HiddenField extends Element
{
    public function __construct() {
        $this->elementName = "input";
        $this->setAttribute("type", "hidden");
        return $this;
    }
}