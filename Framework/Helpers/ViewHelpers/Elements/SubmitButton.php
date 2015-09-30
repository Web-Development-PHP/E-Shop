<?php
/**
 * Created by PhpStorm.
 * User: Krisss
 * Date: 30.09.2015
 * Time: 13:29
 */

namespace EShop\Helpers\ViewHelpers\Elements;


class SubmitButton extends Element
{
    public function __construct() {
        $this->elementName = "input";
        $this->setAttribute("type", "submit");
        return $this;
    }
}