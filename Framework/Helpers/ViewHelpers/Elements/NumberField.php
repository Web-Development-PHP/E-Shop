<?php
/**
 * Created by PhpStorm.
 * User: Krisss
 * Date: 01.10.2015
 * Time: 23:46
 */

namespace EShop\Helpers\ViewHelpers\Elements;


class NumberField extends Element
{
    public function __construct() {
        $this->elementName = "input";
        $this->setAttribute("type", "number");
        return $this;
    }
}