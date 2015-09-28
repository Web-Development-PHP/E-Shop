<?php
/**
 * Created by PhpStorm.
 * User: Krisss
 * Date: 27.09.2015
 * Time: 13:37
 */

namespace EShop\ViewModels;


use EShop\Config\FolderConfig;
use EShop\Helpers\ViewHelpers\FormViewHelper;

class HomeViewModel extends ViewModel
{
    public function __construct() {
        $this->helper = FormViewHelper::getInstance();
    }

    public function render()
    {
        $file= FolderConfig::VIEWS_DEFAULT_FOLDER . "/home/home.php";
        include_once $file;
//        $html = $this->helper->buildTextField('test123', '<script>alert()</script>', null, ['class' => 'pesho']);
//
//        $passWord = $this->helper->buildPasswordField('test12', '<script>alert()</script>', null, ['class' => 'pesho']);
//        $opt1 = $this->helper->buildOption('opt1', 'Opt1');
//        $opt2 = $this->helper->buildOption('opt2', 'Opt2');
//        $opt3 = $this->helper->buildOption('opt3', 'Opt3');
//        $arr = [];
//        array_push($arr, $opt1, $opt2, $opt3);
//        $slect = $this->helper->buildSelect('select1', $arr);
//
//        $submit = $this->helper->buildSubmitButton('submitbtn', 'Regiterr');
//        $tags = [];
//        array_push($tags, $html, $passWord, $slect, $submit);
//        $form = $this->helper->buildForm('name123', '', 'post', $tags);
//
//        $this->helper->render($file, $form);
    }
}