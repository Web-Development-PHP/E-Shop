<?php

namespace EShop\Helpers\ViewHelpers;

class FormViewHelper extends ViewHelper
{
    private static $instance = null;
    const TYPE_INPUT_TEXT = 'text';
    const TYPE_INPUT_PASSWORD = 'password';
    const TYPE_INPUT_RADIO_BUTTON = 'radio';
    const TYPE_INPUT_CHECKBOX = 'checkbox';
    const TYPE_INPUT_SUBMIT = 'submit';
    const TYPE_INPUT_HIDDEN = 'hidden';

    private function __construct() {
    }

    public static function getInstance() {
        if(self::$instance == null) {
            self::$instance = new FormViewHelper();
        }
        return self::$instance;
    }

    public function buildForm($name, $action, $method, $htmlTags = [],
                              $attributes = [], $acceptCharset= null,
                              $autoComplete = 'off', $target = null,
                              $novalidate = null) {
        $arr = [];
        array_push($arr, $name, $action, $method, $attributes, $acceptCharset, $autoComplete, $target, $novalidate);
        $this->escapeUserInput($arr);

        $formTag = '<form action="'.$action.'" method="'.$method.'" accept-charset="'.$acceptCharset.'" autocomplete="'.$autoComplete.'" ';
        $formTag .= ' target="'.$target.'" novalidate="'.$novalidate.'"';
        foreach ($attributes as $aKey => $aValue) {
            $formTag .= $aKey .'="'. $aValue .'" ';
        }
        $formTag .= ' >';
        foreach ($htmlTags as $tag) {
            $formTag .= $tag;
        }
        $formTag .= '</form>';
        return $formTag;
    }

    public function buildSelect($name, $optionTags = [], $isAutoFocus = false, $isRequired = false, $attributes = []) {
        $arr = [];
        array_push($arr, $name, $attributes);
        $this->escapeUserInput($arr);
        $selectTag = '<select name="'.$name.'" autofocus="'.$isAutoFocus.'" required="'.$isRequired.'" ';
        foreach ($attributes as $aKey => $aValue) {
            $selectTag .= $aKey .'="'. $aValue .'" ';
        }
        $selectTag .= ' >';
        foreach ($optionTags as $optionTag) {
            $selectTag .= $optionTag;
        }
        $selectTag .= '</select>';
        return $selectTag;
    }

    public function buildOption($value, $label, $isDisabled = false, $isSelected = false, $attributes = []) {
        $arr = [];
        array_push($arr, $label, $value, $attributes);
        $this->escapeUserInput($arr);
        $optionTag = '<option value="'.$value.'" disable="'.$isDisabled.'" selected="'.$isSelected.'" ';
        foreach ($attributes as $aKey => $aValue) {
            $optionTag .= $aKey .'="'. $aValue .'" ';
        }
        $optionTag .= ' >' . $label;
        $optionTag .= '</option>';
        return $optionTag;
    }

    public function buildTextArea($name, $rows=10, $cols=15, $value=null, $attributes = []) {
        $arr = [];
        array_push($arr, $name, $rows, $cols, $value, $attributes);
        $this->escapeUserInput($arr);
        $textArea = '<textarea name="'.$name.'" rows="'.$rows.'" cols="'.$cols.'" ';
        foreach ($attributes as $aKey => $aValue) {
            $textArea .= $aKey .'="'. $aValue .'" ';
        }
        $textArea .= ' >' . $value;
        $textArea .= '</textarea>';
        return $textArea;
    }

    public function buildHiddenField($name, $value) {
        $hiddenField = $this->buildInput(self::TYPE_INPUT_HIDDEN, $name, null, $value);
        return $hiddenField;
    }

    public function buildCheckbox($name, $placeholder, $value, $attributes = []) {
        $checkBox = $this->buildInput(self::TYPE_INPUT_CHECKBOX, $name, $placeholder, $value, $attributes);
        return $checkBox;
    }

    public function buildRadionButton($name, $placeholder, $value, $attributes = []){
        $radioButton = $this->buildInput(self::TYPE_INPUT_RADIO_BUTTON, $name, $placeholder, $value, $attributes);
        return $radioButton;
    }

    public function buildPasswordField($name, $placeholder, $value, $attributes = []) {
        $passwordField = $this->buildInput(self::TYPE_INPUT_PASSWORD, $name, $placeholder, $value, $attributes);
        return $passwordField;
    }

    public function buildSubmitButton($name, $value, $attributes = []) {
        $submitBtn = $this->buildInput(self::TYPE_INPUT_SUBMIT, $name, null, $value, $attributes);
        return $submitBtn;
    }

    public function buildTextField($name, $placeholder, $value, $attributes = []) {
        $textField = $this->buildInput(self::TYPE_INPUT_TEXT, $name, $placeholder, $value, $attributes);
        return $textField;
    }

    public function render($fileName, $htmlBuilder)
    {
        echo $htmlBuilder;;
    }

    private function buildInput($type, $name, $placeholder, $value, $attributes = []) {
        $arr = [];
        array_push($arr, $name, $placeholder, $value, $attributes);
        $this->escapeUserInput($arr);
        $input = '<input type="'.$type.'" name="'. $name .'" placeholder="'. $placeholder .'" ';
        $input .= 'value="'. $value .'"';
        foreach ($attributes as $aKey => $aValue) {
            $input .= $aKey .'="'. $aValue .'" ';
        }
        $input .= ' />';
        return $input;
    }

    private function escapeUserInput($arr) {
        foreach ($arr as &$element) {
            if(is_array($element)) {
                $element = $this->escapeUserInput($element);
            }else {
                $element = htmlspecialchars($element);
            }
        }
        return $arr;
    }
}