<?php
/**
 * Created by PhpStorm.
 * User: Krisss
 * Date: 30.09.2015
 * Time: 13:08
 */

namespace EShop\Helpers\ViewHelpers\Elements;


class TextArea extends Element
{
    public function __construct() {
        $this->elementName = "textarea";
        $this->innerValue = true;
        return $this;
    }
}