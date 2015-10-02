<?php

namespace EShop\ViewModels;

use EShop\Config\FolderConfig;
use EShop\Models\AjaxTest;

class TestViewModel extends ViewModel
{
    /**
     * @var AjaxTest[]
     */
    public $testArr = [];

    public function renderSampleData ()
    {
        $outPut = '<table border="1">';
        foreach ($this->testArr as $data) {

            $outPut .= "<tr>";
            $outPut .= "<td>{$data['Name']}</td>";
            $outPut .= "<td>{$data['Email']}</td>";
            $outPut .= "</tr>";
        }
        $outPut .= "</table>";
        echo $outPut;
    }

    public function render()
    {
        include_once FolderConfig::VIEWS_DEFAULT_FOLDER .  "/home/test.php";
    }
}