<?php

namespace EShop\ViewModels;
use EShop\Config\FolderConfig;
use EShop\Helpers\ViewHelpers\FormViewHelper;
use EShop\Helpers\ViewHelpers\ViewHelper;

abstract class ViewModel
{
    abstract public function render();

    protected function loadTemplate($file, $model) {
        $file = FolderConfig::VIEWS_DEFAULT_FOLDER . $file;

        if(isset($model) && !empty($model) && $model !== null) {
            $contents = file_get_contents($file);
            $rows = explode("\n", $contents);
            $modelTypeAnnotation = $rows[0];

            preg_match_all("/([A-Z])\w+/", $modelTypeAnnotation, $matches);
            $expectedType = implode('\\', $matches[0]);
            if(is_array($model) && isset($model[0])) {
                if(get_class($model[0]) != $expectedType) {
                    throw new \Exception("Invalid type of ViewModel!");
                }
            }else {
                if(get_class($model) != $expectedType) {
                    throw new \Exception("Invalid type of ViewModel!");
                }
            }
        }

        require $file;
    }
}