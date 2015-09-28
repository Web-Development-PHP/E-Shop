<?php

namespace EShop\Helpers\ViewHelpers;
abstract class ViewHelper
{
    abstract public function render( $fileName, $htmlBuilderType);
}