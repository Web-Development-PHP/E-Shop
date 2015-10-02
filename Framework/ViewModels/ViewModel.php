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
            $this->escapeAll($model);
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

    protected function escapeAll($toEscape) {
        if(is_array($toEscape)) {
            foreach ($toEscape as $key => &$value) {
                if(is_object($value)) {
                    $reflection = new \ReflectionClass($value);
                    $properties = $reflection->getProperties();

                    foreach ($properties as &$property) {
                        $property->setAccessible(true);
                        $property->setValue($value, $this->escapeAll($property->getValue($value)));
                    }
                }elseif(is_array($value)) {
                    $this->escapeAll($value);
                }else {
                    $value = htmlspecialchars($value);
                }
            }
        }elseif(is_object($toEscape)) {
            $reflection = new \ReflectionClass($toEscape);
            $properties = $reflection->getProperties();

            foreach ($properties as &$property) {
                $property->setAccessible(true);
                $property->setValue($toEscape, $this->escapeAll($property->getValue($toEscape)));
            }
        }else {
            $toEscape = htmlspecialchars($toEscape);
        }

        return $toEscape;
    }
}