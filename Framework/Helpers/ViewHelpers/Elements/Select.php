<?php
/**
 * Created by PhpStorm.
 * User: Krisss
 * Date: 01.10.2015
 * Time: 15:01
 */

namespace EShop\Helpers\ViewHelpers\Elements;


class Select extends Element
{
    public function __construct() {
        $this->elementName = "select";
        $this->innerElements = [];
        return $this;
    }

    public function addOption($value, $text = null, $isSelected = false) {
        $option = new Option($value, $text, $isSelected);
        $this->innerElements[] = $option;
        return $this;
    }
}