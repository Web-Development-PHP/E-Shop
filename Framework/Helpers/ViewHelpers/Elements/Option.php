<?php
/**
 * Created by PhpStorm.
 * User: Krisss
 * Date: 01.10.2015
 * Time: 15:07
 */

namespace EShop\Helpers\ViewHelpers\Elements;


class Option extends Element
{
    public function __construct($value, $text = null, $isSelected = false) {
        $this->elementName = "option";
        if($isSelected) {
            $this->setAttribute('selected', 'selected');
        }
        $this->setValue($value);
        $this->setAttribute('text', $text);
        return $this;
    }
}